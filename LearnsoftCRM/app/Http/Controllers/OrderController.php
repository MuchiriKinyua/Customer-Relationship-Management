<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OrderRepository;
use App\Models\Order;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;

class OrderController extends AppBaseController
{
    /** @var OrderRepository $orderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $orders = Order::with(['products', 'client', 'lead']) // Eager load product, client, and lead
                        ->when($search, function ($query) use ($search) {
                            $query->where(function ($query) use ($search) {
                                $query->whereHas('product', function ($query) use ($search) {
                                    $query->where('product_name', 'like', '%' . $search . '%'); // Search by product name
                                })
                                ->orWhere('status', 'like', '%' . $search . '%') // Search by order status
                                ->orWhereHas('client', function ($query) use ($search) {
                                    // Search by first name or last name of the client
                                    $query->where('first_name', 'like', '%' . $search . '%')
                                          ->orWhere('last_name', 'like', '%' . $search . '%');
                                })
                                ->orWhereDate('order_date', 'like', '%' . $search . '%'); // Search by order date
                            });
                        })
                        ->paginate(10);
        
        return view('orders.index')->with('orders', $orders);
    }
    
    

    /**
     * Show the form for creating a new Order.
     */
    public function create(Request $request)
    {
        // Fetch all employees
        $employees = Employee::all(); 
    
        // Fetch all clients and concatenate first and last name for display
        $clients = Client::all()->mapWithKeys(function ($client) {
            return [$client->id => $client->first_name . ' ' . $client->last_name];
        })->toArray();
         
        // Fetch all leads using the full_name field
        $leads = Lead::pluck('full_name', 'id')->toArray();
         
        // Filter products based on the selected lead
        $products = [];
        if ($request->has('lead_id')) {
            $lead = Lead::with('products')->find($request->lead_id); // Eager load products
            if ($lead) {
                $products = $lead->products->pluck('product_name', 'id')->toArray(); // Only products associated with the selected lead
            }
        } else {
            $products = Product::pluck('product_name', 'id')->toArray(); // Default to all products if no lead is selected
        }
     
        return view('orders.create', compact('products', 'clients', 'employees', 'leads'));
    }
    
    

    /**
     * Store a newly created Order in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();
    
        // Generate a unique order number
        $orderNumber = $this->generateOrderNumber();
    
        // Add the generated order number to the input
        $input['order_ref_number'] = $orderNumber;
    
        // Handle lead if provided
        if ($request->has('lead_id') && $request->lead_id) {
            $lead = \App\Models\Lead::find($request->lead_id);
    
            if ($lead) {
                // Handle client creation or assignment
                $existingClient = \App\Models\Client::where('phone_number', $lead->phone_number)->first();
    
                if ($existingClient) {
                    $input['client_id'] = $existingClient->id;
                } else {
                    $client = new \App\Models\Client();
                    $client->full_name = $lead->full_name;
                    $client->email_address = $lead->email;
                    $client->phone_number = $lead->phone_number;
                    $client->lead_id = $lead->id;
    
                    // Set employee
                    if ($lead->employee_id) {
                        $client->employee_id = $lead->employee_id;
                    } elseif (auth()->check() && auth()->user()->employee_id) {
                        $client->employee_id = auth()->user()->employee_id;
                    }
    
                    // Set order date
                    if ($request->has('order_date')) {
                        $client->client_date = $request->order_date;
                    }
    
                    $client->save();
                    $input['client_id'] = $client->id;
                    $lead->status = 'Converted to a client';
                    $lead->save();
                }
    
                // Set type as Client
                $input['type'] = 'Client';
    
                // Set status to 'Pending' if not provided
                if (!$request->has('status') || empty($request->status)) {
                    $input['status'] = 'Pending'; // Default status
                }
    
                // Now, sync the products, quantities, and prices
                $productsData = [];
                $totalPrice = 0;
    
                foreach ($request->input('products', []) as $productId) {
                    $product = \App\Models\Product::find($productId);
    
                    if ($product) {
                        // Get the quantity from the form
                        $quantity = $request->input('quantities.' . $productId, 1); // Default to 1 if no quantity provided
                        $totalPrice += $product->price * $quantity;
    
                        $productsData[$product->id] = [
                            'quantity' => $quantity,
                            'price' => $product->price,
                            'total_price' => $product->price * $quantity,
                        ];
                    }
                }
    
                $input['total_price'] = $totalPrice; // Set the overall total price
                $order = $this->orderRepository->create($input);
    
                // Sync products to the order with pivot data
                $order->products()->sync($productsData);
            }
        }
    
        Flash::success('Order created successfully. Reference Number: ' . $order->order_ref_number);
        return redirect(route('orders.index'));
    }
    
    /**
     * Generate a unique order reference number.
     *
     * @return string
     */
    protected function generateOrderNumber()
    {
        // Get the current date in YYYYMMDD format
        $date = date('Ymd');
        
        // Generate a random 4-digit number
        $randomNumber = rand(1000, 9999);
        
        // Return the unique order number
        return 'ORD-' . $date . '-' . $randomNumber;
    }

    /**
     * Show the form for editing the specified Order.
     */
    public function edit($id, Request $request)
    {
        $order = $this->orderRepository->find($id);
    
        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }
    
        // Fetch all clients
        $clients = Client::pluck('full_name', 'id')->toArray();
    
        // Fetch all leads
        $leads = Lead::pluck('full_name', 'id')->toArray();
    
        // Fetch products associated with the lead, or all products if no lead is selected
        $products = [];
        if ($request->has('lead_id')) {
            $lead = Lead::with('products')->find($request->lead_id); // Eager load products
            if ($lead) {
                $products = $lead->products->pluck('product_name', 'id')->toArray();
            }
        } else {
            $products = Product::pluck('product_name', 'id')->toArray();
        }
    
        return view('orders.edit', compact('order', 'products', 'clients', 'leads'));
    }
    

    /**
     * Update the specified Order in storage.
     */
    public function update($id, UpdateOrderRequest $request)
{
    $order = $this->orderRepository->find($id);
    
    if (empty($order)) {
        Flash::error('Order not found');
        return redirect(route('orders.index'));
    }
    
    $input = $request->all();

    // Handle lead if provided
    if ($request->has('lead_id') && $request->lead_id) {
        $lead = \App\Models\Lead::find($request->lead_id);

        if ($lead) {
            // Handle client creation or assignment
            $existingClient = \App\Models\Client::where('phone_number', $lead->phone_number)->first();

            if ($existingClient) {
                $input['client_id'] = $existingClient->id;
            } else {
                $client = new \App\Models\Client();
                $client->full_name = $lead->full_name;
                $client->email_address = $lead->email_address;
                $client->phone_number = $lead->phone_number;
                $client->lead_id = $lead->id;

                // Set employee based on the lead or authenticated user
                $client->employee_id = $lead->employee_id ?: (auth()->check() ? auth()->user()->employee_id : null);
                
                // Set client date based on the order date
                if ($request->has('order_date')) {
                    $client->client_date = $request->order_date;
                }

                $client->save();
                $input['client_id'] = $client->id;
                $lead->status = 'Converted to a client';
                $lead->save();
            }

            $input['type'] = 'Client';
        }
    } elseif ($request->has('client_id') && $request->client_id) {
        $input['client_id'] = $request->client_id;
        $input['type'] = 'Client';
    }

    // Sync products, quantities, and prices
    $productsData = [];
    $totalPrice = 0;

    foreach ($request->products as $productId) {
        $product = Product::find($productId);
        
        if ($product) {
            $quantity = isset($request->quantities[$productId]) ? $request->quantities[$productId] : 1;
            $totalPrice += $product->price * $quantity;

            // Ensure pivot table data includes 'product_id', 'quantity', 'price', and 'total_price'
            $productsData[$product->id] = [
                'quantity' => $quantity,
                'price' => $product->price,
                'total_price' => $product->price * $quantity,
            ];
        }
    }

    $input['total_price'] = $totalPrice; // Update the total price

    // Sync product data with the order (ensure product_id and other pivot fields are correctly updated)
    $order->products()->sync($productsData); 

    // Update the order with the provided data
    $this->orderRepository->update($input, $id);

    Flash::success('Order updated successfully.');

    return redirect(route('orders.index'));
}

    /**
     * Display the specified Order.
     */
    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Get order data based on a specified interval.
     */
    public function getOrderData(Request $request)
    {
        $interval = $request->get('interval', 'days'); // Default to daily

        $query = DB::table('orders')
            ->select(
                DB::raw('SUM(quantity_ordered) as total_quantity'),
                DB::raw("DATE_FORMAT(order_date, CASE WHEN '$interval' = 'days' THEN '%Y-%m-%d' WHEN '$interval' = 'weeks' THEN '%Y-%u' WHEN '$interval' = 'months' THEN '%Y-%m' END) as date_group")
            )
            ->groupBy('date_group')
            ->orderBy('date_group');

        $data = $query->get();

        return response()->json($data);
    }

    /**
     * Remove the specified Order from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }



    public function byClient($clientId)
{
    $client = Client::findOrFail($clientId);
    $orders = Order::where('client_id', $clientId)->with('products')->get();

    return view('orders.by_client', compact('client', 'orders'));
}


public function byLead($lead_id)
    {
        // Fetch the lead
        $lead = Lead::findOrFail($lead_id);
        
        // Get all orders made by this lead
        $orders = Order::where('lead_id', $lead_id)->get();

        return view('orders.by_lead', compact('orders', 'lead'));
    }

}