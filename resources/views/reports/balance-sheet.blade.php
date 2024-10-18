@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Balance Sheet as of {{ $date }}</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Assets</h2>
            <ul>
                @foreach($assets as $asset)
                <li>{{ $asset->account }}: {{ number_format($asset->debit - $asset->credit, 2) }}</li>
                @endforeach
            </ul>
            <strong>Total Assets:{{ number_format($totalAssets, 2) }}</strong>
        </div>
        <div class="col-md-6">
            <h2>Liabilities and Equity</h2>
            <ul>
                @foreach($liabilities as $liability)
                <li>{{ $liability->account }}: {{ number_format($liability->credit - $liability->debit, 2) }}</li>
                @endforeach
                @foreach($equities as $equity)
                <li>{{ $equity->account }}: {{ number_format($equity->credit - $equity->debit, 2) }}</li>
                @endforeach
            </ul>
            <strong>Total Liabilities and Equity: {{ number_format($totalLiabilities + $totalEquities, 2) }}</strong>
        </div>
    </div>
</div>
@endsection
