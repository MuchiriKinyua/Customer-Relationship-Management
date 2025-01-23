<!-- Type Selector Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type', ['client' => 'Client', 'lead' => 'Lead'], null, ['class' => 'form-control', 'id' => 'type_selector', 'placeholder' => 'Select type']) !!}
</div>

<!-- Client Id Field (hidden by default) -->
<div class="form-group col-sm-6" id="client_id_field" style="display: none;">
    {!! Form::label('client_id', 'Client:') !!}
    {!! Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => 'Select a client']) !!}
</div>

<!-- Lead Id Field (hidden by default) -->
<div class="form-group col-sm-6" id="lead_id_field" style="display: none;">
    {!! Form::label('lead_id', 'Lead:') !!}
    {!! Form::select('lead_id', $leads, null, ['class' => 'form-control', 'placeholder' => 'Select a lead']) !!}
</div>

<!-- Multi-Select Dropdown for Products -->
<div class="form-group col-sm-12">
    <label for="products">Products</label>
    <select name="products[]" id="products" class="form-control" multiple>
        @foreach($products as $id => $product)
            <option value="{{ $id }}">{{ $product }}</option> <!-- product should be a string (product_name) -->
        @endforeach
    </select>
</div>

<!-- Container for Dynamic Quantities -->
<div id="product-quantities" class="mt-3">
    <!-- Quantities for selected products will be added here dynamically -->
</div>

<!-- Order Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_date', 'Order Date:') !!}
    {!! Form::date('order_date', null, ['class' => 'form-control', 'id' => 'order_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelector = document.getElementById('type_selector');
            const clientField = document.getElementById('client_id_field');
            const leadField = document.getElementById('lead_id_field');

            // Initially hide the client and lead fields
            clientField.style.display = 'none';
            leadField.style.display = 'none';

            // Listen for change in the type selector and show the appropriate field
            typeSelector.addEventListener('change', function() {
                toggleFields(typeSelector.value);
            });

            function toggleFields(selectedType) {
                // Hide both client and lead fields by default
                clientField.style.display = 'none';
                leadField.style.display = 'none';

                // Show the relevant field based on selected type
                if (selectedType === 'client') {
                    clientField.style.display = 'block';
                } else if (selectedType === 'lead') {
                    leadField.style.display = 'block';
                } 
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Assuming products is available globally (you can pass this data from the controller)
            const products = @json($products); // Ensure $products is passed from the controller

            // Initialize multi-select (can use libraries like Select2 for better UI)
            $('#products').on('change', function() {
                const selectedProducts = $(this).val(); // Get selected product IDs
                const container = $('#product-quantities');

                // Clear the container before re-adding quantity inputs
                container.html('');

                // Loop through selected products and add quantity inputs
                if (selectedProducts) {
                    selectedProducts.forEach(productId => {
                        const productName = products[productId]; // Get product name from the products array
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
