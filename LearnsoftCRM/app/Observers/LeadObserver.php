<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\Lead;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        // You can add logic for when a lead is created, if needed
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead)
    {
        // Check if the status was changed to "converted"
        if ($lead->isDirty('status') && $lead->status === 'converted') {
            // Check if this lead is already a client
            if (Client::where('lead_id', $lead->id)->exists()) {
                return; // Lead is already converted, skip
            }

            // Split full name into first and last names if needed
            $nameParts = explode(' ', $lead->full_name, 2); // Split by space, and limit to 2 parts
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : null;

            // Create a client from the lead data
            Client::create([
                'first_name' => $firstName,
                'last_name' => $lastName,  // Last name may be null
                'company_name' => 'unknown', // Set company name as 'unknown'
                'email_address' => $lead->email,
                'phone_number' => $lead->phone_number,
                'lead_id' => $lead->id,
                'location' => 'Unknown', // Location can be adjusted as needed, or left as 'Unknown'
            ]);
        }
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        // You can add logic for when a lead is deleted, if needed
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        // You can add logic for when a lead is restored, if needed
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        // You can add logic for when a lead is force deleted, if needed
    }
}
