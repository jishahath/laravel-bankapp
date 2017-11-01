@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Transactions</div>

                <div class="panel-body">
                	@if (count($transactions) > 1)
	                    <table class="table table-striped">
						  <thead class="thead-light">
						    <tr> 
						      <th scope="col">#</th>
						      <th scope="col">Date Time</th>
						      <th scope="col">Amount</th>
						      <th scope="col">Transaction Type</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach ($transactions as $transaction)
							    <tr>
							      <th scope="row">{{ $loop->iteration }}</th>
							      <td>{{ $transaction->created_at }}</td>
							      <td>{{ $transaction->amount }}</td>
							      <td>
							      	{{ $transaction->type }}
							        @if($transaction->transfer_id)
							      	  by Transfer
							        @endif
							      </td>
							    </tr>
						    @endforeach
						  </tbody>
						</table>
					@else
						No transactions found !
					@endif 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
