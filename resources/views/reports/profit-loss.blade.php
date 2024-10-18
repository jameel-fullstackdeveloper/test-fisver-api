@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Income Statement ({{ $startDate }} - {{ $endDate }})</h1>
    <div>
        <h2>Revenues</h2>
        <ul>
            @foreach($revenues as $revenue)
                <li>{{ $revenue->account }}: ${{ number_format($revenue->credit - $revenue->debit, 2) }}</li>
            @endforeach
        </ul>
        <strong>Total Revenues: ${{ number_format($totalRevenues, 2) }}</strong>
    </div>
    <div>
        <h2>Expenses</h2>
        <ul>
            @foreach($expenses as $expense)
                <li>{{ $expense->account }}: ${{ number_format($expense->debit - $expense->credit, 2) }}</li>
            @endforeach
        </ul>
        <strong>Total Expenses: ${{ number_format($totalExpenses, 2) }}</strong>
    </div>
    <div>
        <h3>Net Income: ${{ number_format($netIncome, 2) }}</h3>
    </div>
</div>
@endsection
