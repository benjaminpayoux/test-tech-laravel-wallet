<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class DashboardController
{
    public function __invoke(Request $request)
    {
        $wallet = $request->user()->wallet;
        
        if ($wallet == null)
        {
            $wallet = new Wallet;
            $wallet->user_id = $request->user()->id;            
            $wallet->balance = 0;
            $wallet->save();
        }

        $transactions = $wallet->transactions()->with('transfer')->orderByDesc('id')->get();
        $balance = $wallet->balance;
        
        return view('dashboard', compact('transactions', 'balance'));
    }
}
