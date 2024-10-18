@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trial Balance</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Account Name</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
            <tr>
                <td>{{ $account->account }}</td>
                <td>{{ number_format($account->debit, 2) }}</td>
                <td>{{ number_format($account->credit, 2) }}</td>
            </tr>
            @endforeach
            <tr class="table-primary"> <!-- Highlight the total row -->
                <th>Total</th>
                <th>{{ number_format($totalDebit, 2) }}</th>
                <th>{{ number_format($totalCredit, 2) }}</th>
            </tr>
        </tbody>
    </table>
</div>
@endsection
