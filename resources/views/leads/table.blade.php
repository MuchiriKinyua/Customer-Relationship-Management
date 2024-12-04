<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Employee</th>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Description</th>
                    <th>Grand Total</th>
                    <th>Lead Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    @foreach($leads as $lead)
        <tr>
            <!-- Full Name -->
            <td>{{ $lead->full_name ?? 'No Lead' }}</td>

            <!-- Email -->
            <td>{{ $lead->email ?? 'No Email' }}</td>

            <!-- Phone Number -->
            <td>{{ $lead->phone_number ?? 'No Phone' }}</td>

            <!-- Status -->
            <td>{{ $lead->status ?? 'No Status' }}</td>

            <!-- Employee -->
            <td>{{ $lead->employee->full_name ?? 'No Employee' }}</td>

            <!-- Products -->
            <td>
                @foreach($lead->products as $product)
                    {{ $product->product_name }}<br>
                @endforeach
            </td>

            <!-- Quantity -->
            <td>
                @foreach($lead->products as $product)
                    {{ $product->pivot->quantity }}<br>
                @endforeach
            </td>

            <!-- Total Price (per product) -->
            <td>
                @foreach($lead->products as $product)
                    {{ $product->price && $product->pivot->quantity ? $product->price * $product->pivot->quantity : 'No Price' }}<br>
                @endforeach
            </td>

            <!-- Description -->
            <td>{{ $lead->description ?? 'No Description' }}</td>

            <!-- Grand Total -->
            <td>
                {{ $lead->products->sum(fn($product) => $product->price * $product->pivot->quantity) ?? 'No Price' }}
            </td>

            <!-- Lead Date -->
            <td>{{ \Carbon\Carbon::parse($lead->lead_date)->format('Y-m-d') }}</td>

            <!-- Actions -->
            <td style="width: 120px">
                {!! Form::open(['route' => ['leads.destroy', $lead->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                <div class='btn-group'>
                    <!-- View -->
                    <a href="{{ route('leads.show', [$lead->id]) }}" class='btn btn-default btn-xs'>
                        <i class="far fa-eye"></i>
                    </a>

                    <!-- Edit -->
                    <a href="{{ route('leads.edit', [$lead->id]) }}" class='btn btn-default btn-xs'>
                        <i class="far fa-edit"></i>
                    </a>

                    <!-- Add Details ("+" button) -->
                    <a href="{{ route('leads.addDetails', [$lead->id]) }}" class='btn btn-success btn-xs'>
                        <i class="fas fa-plus"></i>
                    </a>

                    <!-- Delete -->
                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
</tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $leads])
        </div>
    </div>
</div>
