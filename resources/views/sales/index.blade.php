@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add New Sale</a>
    <table class="table">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->invoice_number }}</td>
                <td>{{ $sale->date->format('Y-m-d') }}</td>
                <td>{{ $customers[0]->account }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>
                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
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
