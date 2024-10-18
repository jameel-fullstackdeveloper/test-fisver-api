@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Chart of Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('chart-of-accounts.update', $chartOfAccount->id) }}">
                        @csrf
                        @method('PUT')

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
                                <option value="Asset" {{ $chartOfAccount->type == 'Asset' ? 'selected' : '' }}>{{ __('Asset') }}</option>
                                <option value="Liability" {{ $chartOfAccount->type == 'Liability' ? 'selected' : '' }}>{{ __('Liability') }}</option>
                                <option value="Equity" {{ $chartOfAccount->type == 'Equity' ? 'selected' : '' }}>{{ __('Equity') }}</option>
                                <option value="Revenue" {{ $chartOfAccount->type == 'Revenue' ? 'selected' : '' }}>{{ __('Revenue') }}</option>
                                <option value="Expense" {{ $chartOfAccount->type == 'Expense' ? 'selected' : '' }}>{{ __('Expense') }}</option>
                            </select>

                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="head" class="form-label">{{ __('Account Head') }}</label>
                            <input id="head" type="text" class="form-control @error('head') is-invalid @enderror" name="head" value="{{ old('head', $chartOfAccount->head) }}" required>

                            @error('head')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="account" class="form-label">{{ __('Account Name') }}</label>
                            <input id="account" type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account', $chartOfAccount->account) }}" required>

                            @error('account')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="balance" class="form-label">{{ __('Balance') }}</label>
                            <input id="balance" type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance',$chartOfAccount->balance ) }}" required>

                            @error('balance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="balance_type" class="form-label">{{ __('Balance Type') }}</label>
                            <select id="balance_type" class="form-select @error('balance_type') is-invalid @enderror" name="balance_type" required>
                                <option value="Dr." {{ $chartOfAccount->balance_type == 'Dr.' ? 'selected' : '' }}>{{ __('Dr.') }}</option>
                                <option value="Cr." {{ $chartOfAccount->balance_type == 'Cr.' ? 'selected' : '' }}>{{ __('Cr.') }}</option>
                            </select>

                            @error('balance_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Account') }}
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
