<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="transactions-table">
            <thead>
                <tr>
                    <th>Order Ref Number</th>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                   <!-- <th>Payment Method</th>-->
                    <th>Transaction Reference</th>
                    <th>Client</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <!-- Display the related Order Ref Number -->
                        <td>
                            @if($transaction->order)
                                {{ $transaction->order->order_ref_number }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $transaction->amount_paid }}</td>
                        <td>{{ $transaction->payment_date }}</td>
                       <!-- <td>{{ $transaction->payment_method }}</td>-->
                        <td>{{ $transaction->transaction_reference }}</td>
                        
                        <!-- Display the related Client's Full Name -->
                        <td>
                            @if($transaction->order && $transaction->order->client)
                                {{ $transaction->order->client->full_name }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td style="width: 120px">
                            {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('transactions.show', [$transaction->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('transactions.edit', [$transaction->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $transactions])
        </div>
    </div>
</div>
