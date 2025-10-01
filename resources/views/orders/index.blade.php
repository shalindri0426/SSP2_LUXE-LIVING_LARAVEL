<x-app-layout>
    @include('user.partials.catnav')

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                        <p class="text-gray-600 mt-2">Track and manage your furniture orders</p>
                    </div>
                    <a href="{{ route('user.user') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-gray-50 px-6 py-4 border-b">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Order ID</p>
                                            <p class="font-semibold text-gray-900">{{ $order->order_id }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Order Date</p>
                                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Total Amount</p>
                                            <p class="font-semibold text-blue-600">Rs. {{ number_format($order->total_amount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 mt-4 sm:mt-0">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $order->order_status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $order->payment_status === 'payment confirmed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Products -->
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-3">Items Ordered</h3>
                                        <div class="space-y-2">
                                            @foreach($order->products as $product)
                                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $product['product_name'] }}</p>
                                                        <p class="text-sm text-gray-500">Qty: {{ $product['quantity'] }} × Rs. {{ number_format($product['price'], 2) }}</p>
                                                    </div>
                                                    <p class="font-semibold text-gray-900">Rs. {{ number_format($product['total'], 2) }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Delivery Info -->
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-3">Delivery Information</h3>
                                        <div class="text-sm text-gray-700 space-y-1">
                                            <p><strong>Name:</strong> {{ $order->delivery_name }}</p>
                                            <p><strong>Phone:</strong> {{ $order->delivery_phone }}</p>
                                            <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
                                            @if($order->special_instructions)
                                                <p><strong>Instructions:</strong> {{ $order->special_instructions }}</p>
                                            @endif
                                        </div>

                                        <!-- Payment Info -->
                                        @if($order->payment)
                                            <div class="mt-4">
                                                <h4 class="font-semibold text-gray-900 mb-2">Payment Details</h4>
                                                <div class="text-sm text-gray-700">
                                                    <p><strong>Method:</strong> 
                                                        {{ $order->payment->payment_method === 'bank_transfer' ? 'Bank Transfer' : 'Online Payment' }}
                                                    </p>
                                                    @if($order->payment->payment_method === 'bank_transfer' && $order->payment->receipt_pdf)
                                                        <p class="mt-1">
                                                            <a href="{{ asset('storage/' . $order->payment->receipt_pdf) }}" 
                                                               target="_blank" 
                                                               class="text-blue-600 hover:underline">
                                                                <i class="fas fa-file-pdf mr-1"></i>
                                                                View Receipt
                                                            </a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Order Actions -->
                            @if($order->payment_status === 'pending' && !$order->payment)
                                <div class="bg-gray-50 px-6 py-4 border-t">
                                    <a href="{{ route('orders.payment', $order) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Complete Payment
                                    </a>
                                </div>
                            @elseif($order->payment_status === 'payment confirmed')
                                <div class="bg-green-50 px-6 py-4 border-t">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span class="font-medium">Payment Completed</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Orders -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-receipt text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No orders yet</h3>
                        <p class="text-gray-500 mb-6">
                            You haven't placed any orders yet. Start shopping to see your orders here.
                        </p>
                        <a href="{{ route('user.user') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>