<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Transaction;
use App\Transfer;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Deposit money.
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        $this->validateAmount($request);

        $transaction = new \App\Transaction;
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->type = "DEPOSIT";
        $transaction->save();
        
        $message = 'Deposit of INR ' . $request->amount . ' is success';

        return redirect()->route('home')->with('message', $message);
    }

    /**
     * Withdraw money.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        $this->validateAmount($request);

        if ( ! $this->validateBalance($request)) {
            return redirect()->back()
                ->with('error', 'Transaction failed due to insufficient fund !')
                ->withInput();
        }

        $transaction = new \App\Transaction;
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->type = "WITHDRAWAL";
        $transaction->save();
        
        $message = 'Withdrawal of INR ' . $request->amount . ' is success';

        return redirect()->route('home')->with('message', $message);
    }

    /**
     * Transfer money.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        $this->validateAmount($request);

        if ( ! $this->validateBalance($request)) {
            return redirect()->back()
                ->with('error', 'Transaction failed due to insufficient fund !')
                ->withInput();
        }

        $beneficiary = \App\User::where('email', $request->email)->first();
        if ( ! $beneficiary) {
             return redirect()->back()
                ->with('error', 'No beneficiary found with provided email !')
                ->withInput();
        }

        if ($beneficiary->id == Auth::user()->id) {
            return redirect()->back()
                ->with('error', 'Cannot transfer to own account !')
                ->withInput();
        }

        $transfer = new \App\Transfer;
        $transfer->from_id = Auth::user()->id;
        $transfer->to_id = $beneficiary->id;
        $transfer->amount = $request->amount;
        $transfer->save();

        $transaction = new \App\Transaction;
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->transfer_id = $transfer->id;
        $transaction->type = "WITHDRAWAL";
        $transaction->save();

        $transaction = new \App\Transaction;
        $transaction->amount = $request->amount;
        $transaction->user_id = $beneficiary->id;
        $transaction->transfer_id = $transfer->id;
        $transaction->type = "DEPOSIT";
        $transaction->save();

        $message = 'Transfer of INR ' . $request->amount . ' to ' . $beneficiary->name . ' is success';

        return redirect()->route('home')->with('message', $message);
    }

     /**
     * Validate amount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateAmount(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
        ]);
    }

     /**
     * Validate balance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function validateBalance(Request $request)
    {
        $userId = Auth::user()->id;
        $totalDeposit = \App\Transaction::where('user_id', $userId)
            ->where('type', 'DEPOSIT')
            ->sum('amount');
        $totalWithdrawal = \App\Transaction::where('user_id', $userId)
            ->where('type', 'WITHDRAWAL')
            ->sum('amount');

        $balance = $totalDeposit - $totalWithdrawal;

        return $request->amount <= $balance;
    }
}
