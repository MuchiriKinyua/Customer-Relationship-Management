@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Add Details for {{ $lead->full_name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form method="POST" action="{{ route('leads.storeDetails', $lead->id) }}">
                @csrf

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <!-- Lead Date Field -->
                <div class="form-group">
                    <label for="lead_date">Lead Date</label>
                    <input type="text" name="lead_date" id="lead_date" class="form-control" value="{{ old('lead_date') }}" required>
                </div>

                <!-- Employee Dropdown -->
                <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Select an Employee</option>
                        @foreach($employees as $employee) 
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Products Multi-Select -->
                <div class="form-group">
                    <label for="products">Products</label>
                    <select name="products[]" id="products" class="form-control" multiple>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Interaction Type -->
                <div class="form-group">
                <label for="interactionTypes">Form of contact</label>
                <select id="interactionTypes" name="interactionTypes" class="form-control" required>
                    @foreach($interactionTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>

                </div>

                <!-- Product Quantities -->
                <div id="product-quantities" class="mt-3"></div>

                <button type="submit" class="btn btn-primary">Save Details</button>
                <a href="{{ route('leads.index') }}" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(document).ready(function () {
            $('#lead_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $('#products').on('change', function () {
                const selectedProducts = $(this).val();
                const container = $('#product-quantities');
                container.html('');
                if (selectedProducts) {
                    selectedProducts.forEach(productId => {
                        const productName = $('#products option[value="' + productId + '"]').text();
                        container.append(`
                            <div class="form-group">
                                <label for="quantity_${productId}">Quantity for ${productName}</label>
                                <input type="number" name="quantities[${productId}]" id="quantity_${productId}" class="form-control" min="1" value="1" required>
                            </div>
                        `);
                    });
                }
            });
        });
    </script>
@endpush
