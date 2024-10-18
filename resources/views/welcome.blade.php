@extends('layouts.app')

@section('content')

<h1>Payment Form</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('payment.process') }}">
    @csrf
    <!-- Card Details -->
    <label for="card_number">Card Number:</label>
    <input type="text" id="card_number" name="card_number" value="4111111111111111" required>

    <label for="exp_month">Expiry Month (MM):</label>
    <input type="text" id="exp_month" name="exp_month" value="12" required>

    <label for="exp_year">Expiry Year (YY):</label>
    <input type="text" id="exp_year" name="exp_year" value="25" required>

    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" value="123" required>

    <!-- Payment Details -->
    <label for="amount">Amount (£):</label>
    <input type="text" id="amount" name="amount" value="100" required>

    <button type="submit">Pay Now</button>
</form>



@endsection
