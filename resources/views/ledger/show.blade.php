
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ledger for {{ $account->account }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ledger as $entry)
            <tr>
                <td>{{ $entry['date'] }}</td>
                <td>{{ $entry['description'] }}</td>
                <td>{{ number_format($entry['debit'], 2) }}</td>
                <td>{{ number_format($entry['credit'], 2) }}</td>
                <td>{{ $entry['balance'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
