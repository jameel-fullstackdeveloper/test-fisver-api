@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Voucher</h2>
    <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="voucher_type" class="form-label">Voucher Type</label>
            <select class="form-select" id="voucher_type" name="voucher_type" required>
                <option value="Payment" @if($voucher->voucher_type == 'Payment') selected @endif>Payment</option>
                <option value="Receipt" @if($voucher->voucher_type == 'Receipt') selected @endif>Receipt</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $voucher->date->format('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $voucher->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="account_id" class="form-label">Account</label>
            <select class="form-select" id="account_id" name="account_id" required>
                @foreach ($accounts as $account)
                <option value="{{ $account->id }}" @if($account->id == $voucher->account_id) selected @endif>{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-
