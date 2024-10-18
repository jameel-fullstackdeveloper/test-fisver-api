@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Voucher</h2>
    <form action="{{ route('vouchers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="voucher_type" class="form-label">Voucher Type</label>
            <select class="form-select" id="voucher_type" name="voucher_type" required>
                <option value="Payment">Payment</option>
                <option value="Receipt">Receipt</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="account_id" class="form-label">Account</label>
            <select class="form-select" id="account_id" name="account_id" required>
                @foreach ($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
