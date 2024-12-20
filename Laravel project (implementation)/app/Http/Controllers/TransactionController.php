<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TransactionRepository;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Flash;

class TransactionController extends AppBaseController
{
    /** @var TransactionRepository $transactionRepository*/
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the Transaction.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $transactions = Transaction::query() // Start the query
            ->when($search, function ($query) use ($search) {
                // Search within 'order' relationship
                $query->whereHas('order', function ($query) use ($search) {
                    // Ensure you are correctly searching by the columns in the 'orders' table
                    $query->where('status', 'like', '%' . $search . '%') // Search order status
                          ->orWhere('order_date', 'like', '%' . $search . '%'); // Optionally, you can search the order date
                })
                // Search the transaction fields
                ->orWhere('transaction_reference', 'like', '%' . $search . '%') // Search transaction reference
                ->orWhere('payment_method', 'like', '%' . $search . '%') // Search payment method
                ->orWhere('status', 'like', '%' . $search . '%') // Search transaction status
                ->orWhere('amount_paid', 'like', '%' . $search . '%') // Search amount paid
                ->orWhereDate('payment_date', 'like', '%' . $search . '%') // Search payment date
                // Search within the 'client' relationship through 'order' relationship
                ->orWhereHas('order.client', function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%') // Search client's first name
                          ->orWhere('last_name', 'like', '%' . $search . '%'); // Search client's last name
                });
            })
            ->paginate(10);
        
        return view('transactions.index')->with('transactions', $transactions);
    }
    
    
    

    /**
     * Show the form for creating a new Transaction.
     */
    public function create()
    {
        $clients = \App\Models\Client::all(); 
        $orders = \App\Models\Order::all();  
        $paymentMethods = [
            'credit_card' => 'Credit Card',
            'mobile_payment' => 'Mpesa',
            'bank_transfer' => 'Bank Transfer',
            'cash' => 'Cash',
        ];

    
        return view('transactions.create', compact('clients', 'orders','paymentMethods'));
    }
    
    

    /**
     * Store a newly created Transaction in storage.
     */
    public function store(CreateTransactionRequest $request)
    {
        // Retrieve validated data
        $input = $request->all();
    
        // Check if the order and client exist (additional safety check)
        $order = \App\Models\Order::find($input['order_id']);
        $client = \App\Models\Client::find($input['client_id']);
    
        if (!$order || !$client) {
            Flash::error('Order or Client not found.');
            return redirect(route('transactions.create'));
        }
    
        // Create the transaction
        $transaction = $this->transactionRepository->create($input);
    
        // Update the order status to "completed"
        $order->update(['status' => 'completed']);
    
        // Flash a success message
        Flash::success('Transaction saved successfully and order marked as completed.');
    
        return redirect(route('transactions.index'));
    }
    
    /**
     * Display the specified Transaction.
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        return view('transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified Transaction.
     */
    public function edit($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }


        return view('transactions.edit')->with('transaction',$transaction);  
     }

    /**
     * Update the specified Transaction in storage.
     */
    public function update($id, UpdateTransactionRequest $request)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        $transaction = $this->transactionRepository->update($request->all(), $id);

        Flash::success('Transaction updated successfully.');

        return redirect(route('transactions.index'));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        $this->transactionRepository->delete($id);

        Flash::success('Transaction deleted successfully.');

        return redirect(route('transactions.index'));
    }
}
