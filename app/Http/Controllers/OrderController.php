<?php
// app/Http/Controllers/OrderController.php (Updated with debugging)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty!');
        }
        
        $cartTotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        return view('orders.checkout', compact('user', 'cartItems', 'cartTotal'));
    }

    public function store(Request $request)
    {
        // Log the incoming request
        Log::info('Order store request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'delivery_name' => 'required|string|max:255',
            'delivery_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string',
            'special_instructions' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
            
            Log::info('Cart items found', ['count' => $cartItems->count()]);
            
            if ($cartItems->isEmpty()) {
                Log::warning('Cart is empty for user', ['user_id' => $user->id]);
                return redirect()->route('cart.view')->with('error', 'Your cart is empty!');
            }

            // Prepare products data
            $products = $cartItems->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->quantity * $item->price
                ];
            })->toArray();

            Log::info('Products prepared', ['products' => $products]);

            $totalAmount = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            Log::info('Total amount calculated', ['total' => $totalAmount]);

            // Generate order ID
            $orderId = Order::generateOrderId();
            Log::info('Order ID generated', ['order_id' => $orderId]);

            // Prepare order data
            $orderData = [
                'order_id' => $orderId,
                'user_id' => $user->id,
                'products' => $products,
                'total_amount' => $totalAmount,
                'delivery_name' => $request->delivery_name,
                'delivery_phone' => $request->delivery_phone,
                'delivery_address' => $request->delivery_address,
                'special_instructions' => $request->special_instructions,
                'order_status' => 'confirmed'
            ];

            Log::info('Order data prepared', ['order_data' => $orderData]);

            // Create order
            $order = Order::create($orderData);
            
            Log::info('Order created successfully', ['order_id' => $order->id]);

            DB::commit();

            return redirect()->route('orders.payment', $order->id)
                ->with('success', 'Order confirmed! Please proceed with payment.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the actual error
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            
            return back()->withInput()->with('error', 'Order confirmation failed: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if payment already exists
        if ($order->payment()->exists()) {
            return redirect()->route('orders.success', $order->id)
                ->with('info', 'Payment has already been completed for this order.');
        }

        // Check if order payment status is already confirmed
        if ($order->payment_status === 'payment confirmed') {
            return redirect()->route('orders.success', $order->id)
                ->with('info', 'This order has already been paid.');
        }

        return view('orders.payment', compact('order'));
    }

    public function orders()
    {
        $orders = Order::with('payment')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function showOrders(){
        $orders=Order::all();

        return view('admin.orders',compact('orders'));
    }
}