@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Journal Entry</h2>
    <form action="{{ route('journal-entries.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="debit_account_id" class="form-label">Debit Account</label>
            <select class="form-select" id="debit_account_id" name="debit_account_id" required>
                @foreach ($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="credit_account_id" class="form-label">Credit Account</label>
            <select class="form-select" id="credit_account_id" name="credit_account_id" required>
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
        <a href="{{ route('journal-entries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
