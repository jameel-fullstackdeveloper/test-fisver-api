@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Journal Entry</h2>
    <form action="{{ route('journal-entries.update', $entry->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $entry->date }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $entry->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="debit_account_id" class="form-label">Debit Account</label>
            <select class="form-select" id="debit_account_id" name="debit_account_id" required>
                @foreach ($accounts as $account)
                <option value="{{ $account->id }}" @if($account->id == $entry->debit_account_id) selected @endif>{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="credit_account_id" class="form-label">Credit Account</label>
            <select class="form-select" id="credit_account_id" name="credit_account_id" required>
                @foreach ($accounts as $account)
                <option value="{{ $account->id }}" @if($account->id == $entry->credit_account_id) selected @endif>{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type of="number" class="form-control" id="amount" name="amount" value="{{ $entry->amount }}" step="0.01" required>
        </div>
        <button
