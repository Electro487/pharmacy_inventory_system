@extends('layouts.app')
@section('title', 'Create Purchase')
@section('content')
<h2>Create Purchase</h2>

<form action="{{ route('purchases.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Supplier</label>
        <select name="supplier_id" class="form-select">
            <option value="">Select Supplier</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Purchase Date</label>
        <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" class="form-input">
    </div>

    <div class="form-group">
        <label>Remarks</label>
        <textarea name="remarks" class="form-input">{{ old('remarks') }}</textarea>
    </div>

    <button type="button" id="add-row" class="btn btn-secondary">Add Medicine</button>

    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
                <th>Batch</th>
                <th>Expiry</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="purchase-items">
        </tbody>
    </table>

    <h3>Total: <span id="grand-total">0.00</span></h3>

    <button type="submit" class="btn">Save Purchase</button>
</form>

<script>
    const medicines = @json($medicines);
    const tbody = document.getElementById('purchase-items');
    const addRowButton = document.getElementById('add-row');
    const grandTotal = document.getElementById('grand-total');

    function addRow()
    {
        let options = '<option value="">Select Medicine</option>';

        medicines.forEach(function (medicine) {
            options += `
                <option value="${medicine.id}">
                    ${medicine.name}
                </option>
            `;
        });

        const row = `
            <tr>
                <td>
                    <select name="medicine_id[]" class="form-select">
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
                        name="purchase_price[]"
                        class="purchase-price form-input"
                        value="0.01"
                        step="0.01"
                        min="0.01">
                </td>

                <td>
                    <input
                        type="number"
                        name="selling_price[]"
                        class="selling-price form-input"
                        value="0.01"
                        step="0.01"
                        min="0.01">
                </td>

                <td>
                    <input
                        type="text"
                        name="batch_no[]"
                        class="form-input">
                </td>

                <td>
                    <input
                        type="date"
                        name="expiry_date[]"
                        class="form-input">
                </td>

                <td class="subtotal">
                    0.00
                </td>

                <td>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-row">
                        Remove
                    </button>
                </td>

            </tr>
            `;
        tbody.insertAdjacentHTML('beforeend', row);

        const currentRow = tbody.lastElementChild;

        const quantity = currentRow.querySelector('.quantity');
        const purchasePrice = currentRow.querySelector('.purchase-price');

        quantity.addEventListener('input', function () {
            calculateRow(currentRow);
        });

        purchasePrice.addEventListener('input', function () {
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
        const purchasePrice = row.querySelector('.purchase-price');
        const subtotal = row.querySelector('.subtotal');

        const qty = Number(quantity.value);
        const price = Number(purchasePrice.value);

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