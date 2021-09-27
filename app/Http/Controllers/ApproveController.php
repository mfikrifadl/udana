<?php

namespace App\Http\Controllers;

use App\Models\TransactionBalance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['withdraws'] = TransactionBalance::where('credit', '>', 0)->orderBy('status', 'ASC')->get();
        return view('admin.approve')->with($data);
    }

    public function approve(TransactionBalance $transaction)
    {
        DB::beginTransaction();
        try {
            $user = User::find($transaction->user_id);
            $user->pending_balance -=  $transaction->credit;
            $user->save();

            $transaction->update([
                'status' => 2,
                'action_by' => Auth::user()->id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Approve Balance!');
    }

    public function reject(TransactionBalance $transaction)
    {
        DB::beginTransaction();
        try {
            $user = User::find($transaction->user_id);
            $user->pending_balance -=  $transaction->credit;
            $user->balance +=  $transaction->credit;
            $user->save();

            $transaction->update([
                'status' => 1,
                'action_by' => Auth::user()->id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        return redirect()->back()->withSuccess('Success Reject Balance!');
    }
}
