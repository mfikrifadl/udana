<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBalance;
use App\Models\TransactionBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function topup()
    {
        return view('admin.topup');
    }

    public function store_balance(StoreBalance $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->balance +=  $request->balance;
            $user->save();

            TransactionBalance::create([
                'user_id' => $user->id,
                'debit' => $request->balance,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Top Up Balance!');
    }

    public function withdraw()
    {
        $data['withdraws'] = TransactionBalance::where('credit', '>', '0')->where('user_id', Auth::user()->id)->get();
        return view('admin.withdraw')->with($data);
    }

    public function store_withdraw(StoreBalance $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->balance -=  $request->balance;
            $user->pending_balance +=  $request->balance;
            $user->save();

            TransactionBalance::create([
                'user_id' => $user->id,
                'credit' => $request->balance,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Withdraw Balance!');
    }
}
