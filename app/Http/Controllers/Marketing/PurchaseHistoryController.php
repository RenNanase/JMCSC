<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Receipt;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function show($memberId)
    {
        $member = Member::findOrFail($memberId);
        $receipts = Receipt::where('member_id', $memberId)
            ->orderBy('purchase_date', 'desc')
            ->get();

        return view('marketing.purchase_history', compact('member', 'receipts'));
    }
}
