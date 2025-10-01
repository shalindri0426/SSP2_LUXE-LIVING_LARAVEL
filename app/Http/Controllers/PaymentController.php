<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if payment already exists for this order
        if ($order->payment()->exists()) {
            return redirect()->route('orders.success', $order->id)
                ->with('error', 'Payment has already been processed for this order.');
        }

        // Check if order payment status is already confirmed
        if ($order->payment_status === 'payment confirmed') {
            return redirect()->route('orders.success', $order->id)
                ->with('error', 'This order has already been paid.');
        }


        $rules = [
            'payment_method' => 'required|in:bank_transfer,online_transfer'
        ];

        // Add validation rules based on payment method
        if ($request->payment_method === 'bank_transfer') {
            $rules['receipt_pdf'] = 'required|file|mimes:pdf|max:2048';
        } else {
            $rules['card_number'] = 'required|string|size:16';
            $rules['exp_date'] = 'required|string|size:5';
            $rules['cvv'] = 'required|string|size:3';
            $rules['card_holder_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $paymentData = [
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'status' => 'confirmed'
            ];

            if ($request->payment_method === 'bank_transfer') {
                // Store PDF receipt
                $file = $request->file('receipt_pdf');
                $filename = 'receipt_' . $order->order_id . '_' . time() . '.pdf';
                $filePath = $file->storeAs('receipts', $filename, 'public');
                $paymentData['receipt_pdf'] = $filePath;
            } else {
                // Store card details (encrypted)
                $paymentData['card_number'] = $request->card_number;
                $paymentData['exp_date'] = $request->exp_date;
                $paymentData['cvv'] = $request->cvv;
                $paymentData['card_holder_name'] = $request->card_holder_name;
            }

            // Create payment record
            Payment::create($paymentData);

            // Update order payment status
            $order->update(['payment_status' => 'payment confirmed']);

            // Clear user's cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.success', $order->id)
                ->with('success', 'Payment confirmed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment processing failed. Please try again.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }
}
