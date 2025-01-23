<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="products-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity Available</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <!-- Product Name -->
                        <td>
                            {{ $product->product_name ?? 'N/A' }}
                        </td>

                        <!-- Product Description -->
                        <td>
                            {{ $product->description ?? 'N/A' }}
                        </td>

                        <!-- Product Price -->
                        <td>
                            {{ $product->price ? number_format($product->price, 2) : 'N/A' }}
                        </td>

                        <!-- Quantity Available -->
                        <td>
                            {{ $product->quantity_available ?? 'N/A' }}
                        </td>

                        <!-- Action Buttons -->
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}
                                <div class="btn-group">
                                    <!-- View Product -->
                                    <a href="{{ route('products.show', [$product->id]) }}" class="btn btn-default btn-xs">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <!-- Edit Product -->
                                    <a href="{{ route('products.edit', [$product->id]) }}" class="btn btn-default btn-xs">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <!-- Delete Product -->
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-xs',
                                        'onclick' => "return confirm('Are you sure?')"
                                    ]) !!}
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
            @include('adminlte-templates::common.paginate', ['records' => $products])
        </div>
    </div>
</div>
