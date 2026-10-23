<?php

namespace App\Http\Controllers;

use App\Models\TailoringOrder;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->filled('phone') && $request->filled('pin')) {
            $searched = true;
            $order = TailoringOrder::with(['customer', 'branch', 'items'])
                ->where('token_pin', trim($request->pin))
                ->whereHas('customer', function ($q) use ($request) {
                    $q->where('phone', 'like', '%' . trim($request->phone) . '%');
                })
                ->first();
        } elseif ($request->filled('order_number')) {
            $searched = true;
            $order = TailoringOrder::with(['customer', 'branch', 'items'])
                ->where('order_number', trim($request->order_number))
                ->first();
        }

        return view('public.track-order', compact('order', 'searched'));
    }
}
