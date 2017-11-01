@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    Welcome <strong> {{ Auth::user()->name }} </strong> ! Your account balance is
                    <div class="balance">
                        INR {{ $balance }}/-
                    </div>
                    <div class="links">
                        <a href="{{ route('showDeposit') }}">Deposit</a>,
                        <a href="{{ route('showWithdrawal') }}">withdraw</a>  or
                        <a href="{{ route('showTransfer') }}">transfer</a> some money.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Styles -->
<style>

    .alert {
        font-size: 16px;
        font-family: monospace;
    }

    .balance {
        font-size: 56px;
        font-family: monospace;
    }

</style>