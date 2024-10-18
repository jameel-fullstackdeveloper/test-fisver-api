@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Journal Entries</h2>
    <a href="{{ route('journal-entries.create') }}" class="btn btn-primary mb-3">Add New Entry</a>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Debit Account</th>
                <th>Credit Account</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
            <tr>
                <td>{{ $entry->date }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->debitAccount->account }}</td>
                <td>{{ $entry->creditAccount->account }}</td>
                <td>{{ $entry->amount }}</td>
                <td>
                    <a href="{{ route('journal-entries.edit', $entry->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('journal-entries.destroy', $entry->id) }}" method="POST" style="display: inline-block;">
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
