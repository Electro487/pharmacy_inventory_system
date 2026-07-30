@extends('layouts.app')
@section('title', 'Create Sale')
@section('content')
<h2>Create Sale</h2>

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Customer</label>
        <select name="customer_id" class="form-select">
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
        @error('customer_id')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Sale Date</label>
        <input type="date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" class="form-input">
        @error('sale_date')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" class="form-input">{{ old('remarks') }}</textarea>
    </div>

    <button type="button" id="add-row" class="btn btn-primary btn-sm">Add Medicine</button>

    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="sale-items">
        </tbody>
    </table>

    <h3>Total: <span id="grand-total">0.00</span></h3>

    <button type="submit" class="btn btn-primary">Save Sale</button>
</form>

<script>
    const medicines = @json($medicines);
    const tbody = document.getElementById('sale-items');
    const addRowButton = document.getElementById('add-row');
    const grandTotal = document.getElementById('grand-total');

    function addRow()
    {
        let options = '<option value="">Select Medicine</option>';

        medicines.forEach(function (medicine) {
            options += `
                <option value="${medicine.id}" data-price="${medicine.selling_price}">
                    ${medicine.name} (${medicine.brand}) [${medicine.stock} in stock]
                </option>
            `;
        });

        const row = `
            <tr>
                <td>
                    <select name="medicine_id[]" class="medicine-select form-select">
                        ${options}
                    </select>
                </td>
                <td>
                    <input
                        type="number"
                        name="quantity[]"
                        class="quantity form-input"
                        value="1"
                        min="1">
                </td>
                <td>
                    <input
                        type="number"
                        name="selling_price[]"
                        class="selling-price form-input"
                        value="0"
                        step="0.01"
                        min="0"
                        readonly>
                </td>
                <td class="subtotal">
                    0.00
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                </td>
            </tr>
            `;
        tbody.insertAdjacentHTML('beforeend', row);

        const currentRow = tbody.lastElementChild;

        const medicineSelect = currentRow.querySelector('.medicine-select');
        const quantity = currentRow.querySelector('.quantity');
        const sellingPrice = currentRow.querySelector('.selling-price');

        medicineSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            sellingPrice.value = price.toFixed(2);
            calculateRow(currentRow);
        });

        quantity.addEventListener('input', function () {
            calculateRow(currentRow);
        });

        sellingPrice.addEventListener('input', function () {
            calculateRow(currentRow);
        });

        calculateRow(currentRow);
    }

    addRowButton.addEventListener('click', function () {
        addRow();
    });

    addRow();

    function calculateRow(row) {
        const quantity = row.querySelector('.quantity');
        const sellingPrice = row.querySelector('.selling-price');
        const subtotal = row.querySelector('.subtotal');

        const qty = Number(quantity.value);
        const price = Number(sellingPrice.value);

        const total = qty * price;

        subtotal.textContent = total.toFixed(2);

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        const subtotals = document.querySelectorAll('.subtotal');

        let total = 0;

        subtotals.forEach(function (subtotal) {
            total += Number(subtotal.textContent);
        });

        grandTotal.textContent = total.toFixed(2);
    }

    tbody.addEventListener('click', function (event) {
        if (!event.target.classList.contains('remove-row')) {
            return;
        }

        const row = event.target.closest('tr');

        row.remove();

        calculateGrandTotal();
    });
</script>

@endsection