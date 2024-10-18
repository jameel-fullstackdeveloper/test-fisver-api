@extends('layouts.app')

@section('content')


<div class="container">
    <h1>Create Sale</h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

          <!-- Display all validation errors -->
          @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

        <div class="mb-3">
            <label for="invoice_number" class="form-label">Invoice Number</label>
            <input type="text" class="form-control" id="invoice_number" name="invoice_number" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', isset($sale) ? $sale->date->format('Y-m-d') : '') }}" required>

        </div>
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select" id="customer_id" name="customer_id" required>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
