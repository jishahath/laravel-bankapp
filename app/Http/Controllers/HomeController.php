<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Transaction;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $totalDeposit = \App\Transaction::where('user_id', $userId)
            ->where('type', 'DEPOSIT')
            ->sum('amount');
        $totalWithdrawal = \App\Transaction::where('user_id', $userId)
            ->where('type', 'WITHDRAWAL')
            ->sum('amount');

        $balance = $totalDeposit - $totalWithdrawal;
        
        return view('home')->with('balance', $balance);
    }

    /**
     * Show transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactions()
    {
        return view('transactions');
    }

    /**
     * Show withdrawal screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function showWithdrawal()
    {
        return view('withdrawal');
    }

    /**
     * Show deposit screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDeposit()
    {
        return view('deposit');
    }

    /**
     * Show transfer screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransfer()
    {
        return view('transfer');
    }
}
