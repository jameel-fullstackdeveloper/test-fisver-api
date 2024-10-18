@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chart of Accounts</h2>
    <a href="{{ route('chart-of-accounts.create') }}" class="btn btn-primary">Add New Account</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Type</th>
                <th>Head</th>
                <th>Account</th>
                <th>Balance</th>
                <th></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->type }}</td>
                    <td>{{ $account->head }}</td>
                    <td>
                        <a href="{{ url('ledger/show?account_id=')}}{{ $account->id}}"> {{ $account->account }} </a> </td>
                    <td>{{ number_format($account->balance, 2) }}</td>
                    <td>{{ $account->balance_type }}</td>
                    <td>
                        <a href="{{ route('chart-of-accounts.edit', $account->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('chart-of-accounts.destroy', $account->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
