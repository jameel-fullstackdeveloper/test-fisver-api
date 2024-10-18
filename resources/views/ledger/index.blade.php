@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Select Account for Ledger</h1>
    <form action="{{ route('ledger.show') }}" method="GET">
        <div class="form-group">
            <label for="account_id">Account:</label>
            <select class="form-control" id="account_id" name="account_id">
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->account }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">View Ledger</button>
    </form>
</div>
@endsection
