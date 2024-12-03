@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Lead</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form method="POST" action="{{ route('leads.store') }}">
                @csrf

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                

                <!-- Phone Number Field -->
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                </div>

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
                            <option value="{{ $employee->id }}">
                                {{ $employee->full_name }} 
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Multi-Select Dropdown for Products -->
                <div class="form-group">
                    <label for="products">Products</label>
                    <select name="products[]" id="products" class="form-control" multiple>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="interactionTypes">Form of contact</label>
        <select id="interactionTypes" name="interactionTypes" required>
            @foreach($interactionTypes as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select><br><br>



                <!-- Container for Dynamic Quantities -->
                <div id="product-quantities" class="mt-3">
                    <!-- Quantities for selected products will be added here dynamically -->
                </div>

                <button type="submit" class="btn btn-primary">Save Lead</button>
                <a href="{{ route('leads.index') }}" class="btn btn-default"> Cancel </a>

             

            </form>
        </div>
    </div>

@endsection

@push('page_scripts')
    <!-- Include jQuery UI Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#lead_date').datepicker({
                dateFormat: 'yy-mm-dd'  // Set format as per your requirements
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Initialize multi-select (can use libraries like Select2 for better UI)
        $('#products').on('change', function () {
            const selectedProducts = $(this).val(); // Get selected product IDs
            const container = $('#product-quantities');

            // Clear the container before re-adding quantity inputs
            container.html('');

            // Loop through selected products and add quantity inputs
            if (selectedProducts) {
                selectedProducts.forEach(productId => {
                    const productName = $('#products option[value="' + productId + '"]').text(); // Get product name
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
