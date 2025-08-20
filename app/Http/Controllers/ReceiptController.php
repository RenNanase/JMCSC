<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:members,id',
            'receipt_number' => 'required|unique:receipts,receipt_number',
            'purchase_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $receipt = Receipt::create($request->all());

        return response()->json([
            'message' => 'Receipt created successfully',
            'receipt' => $receipt
        ]);
    }

    public function getMemberReceipts($memberId)
    {
        $receipts = Receipt::where('member_id', $memberId)
            ->orderBy('purchase_date', 'desc')
            ->get();

        return response()->json($receipts);
    }
}
