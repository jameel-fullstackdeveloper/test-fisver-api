@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Chart of Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('chart-of-accounts.store') }}">
                        @csrf

                          <!-- Display all validation errors -->
                          @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Account Type') }}</label>
                            <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                                <option value="Asset">{{ __('Asset') }}</option>
                                <option value="Liability">{{ __('Liability') }}</option>
                                <option value="Equity">{{ __('Equity') }}</option>
                                <option value="Revenue">{{ __('Revenue') }}</option>
                                <option value="Expense">{{ __('Expense') }}</option>
                            </select>

                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="head" class="form-label">{{ __('Account Head') }}</label>
                            <input id="head" type="text" class="form-control @error('head') is-invalid @enderror" name="head" value="{{ old('head') }}" required>

                            @error('head')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="account" class="form-label">{{ __('Account Name') }}</label>
                            <input id="account" type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account') }}" required>

                            @error('account')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="balance" class="form-label">{{ __('Balance') }}</label>
                            <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance') }}" required>

                            @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create Account') }}
                            </button>
                            <a href="{{ route('chart-of-accounts.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
