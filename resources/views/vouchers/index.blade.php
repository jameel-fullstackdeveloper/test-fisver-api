@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vouchers</h2>
    <a href="{{ route('vouchers.create') }}" class="btn btn-primary mb-3">Add New Voucher</a>
    <table class="table">
        <thead>
            <tr>
                <th>Voucher Type</th>
                <th>Date</th>
                <th>Description</th>
                <th>Account</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vouchers as $voucher)
            <tr>
                <td>{{ $voucher->voucher_type }}</td>
                <td>{{ $voucher->date->format('Y-m-d') }}</td>
                <td>{{ $voucher->description }}</td>
                <td>{{ $voucher->account->account }}</td>
                <td>{{ number_format($voucher->amount, 2) }}</td>
                <td>
                    <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
