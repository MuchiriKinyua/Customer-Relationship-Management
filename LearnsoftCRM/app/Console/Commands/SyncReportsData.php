<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Product;
use App\Models\Report;
use App\Models\Order;

class SyncReportsData extends Command
{
    protected $signature = 'sync:reports';
    protected $description = 'Sync data from leads, clients, and products into the reports table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $leads = Lead::all();
        $clients = Client::all();
        $products = Product::all();
    
        // Loop through each lead and client pair
        foreach ($leads as $lead) {
            foreach ($clients as $client) {
    
                // Check if a report already exists for this lead-client pair
                $existingReport = Report::where('lead_id', $lead->id)
                    ->where('client_id', $client->id)
                    ->first();
    
                // Only create a new report if one doesn't exist yet
                if (!$existingReport) {
                    // Calculate the total quantity ordered from the order_product table for this lead-client pair
                    $totalQuantityOrdered = \DB::table('order_product as op')
                        ->join('orders as o', 'op.order_id', '=', 'o.id')
                        ->where('o.lead_id', $lead->id)
                        ->where('o.client_id', $client->id)
                        ->sum('op.quantity');
    
                    // Skip the creation of the report if the quantity ordered is 0
                    if ($totalQuantityOrdered == 0) {
                        continue; // Skip this lead-client pair
                    }
    
                    // Loop through each product and create the report
                    foreach ($products as $product) {
                        Report::create([
                            'lead_id' => $lead->id,
                            'client_id' => $client->id,
                            'lead_date' => $lead->lead_date,
                            'client_date' => $client->client_date,
                            'product_id' => $product->id,
                            'quantity_ordered' => $totalQuantityOrdered, // Use the summed quantity ordered
                        ]);
                    }
                }
            }
        }
    
        $this->info('Reports data synced successfully.');
    }
    
    
}
