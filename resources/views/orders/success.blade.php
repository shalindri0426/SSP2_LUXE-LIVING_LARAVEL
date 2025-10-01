<x-app-layout>
    @include('user.partials.catnav')

    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Success Icon -->
                <div class="mb-8">
                    <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-5xl"></i>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Confirmed!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Thank you for your order. Your payment has been successfully processed.
                </p>

                <!-- Order Details Card -->
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <div class="border-b pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
                    </div>
                    
                    <div class="space-y-3 text-left">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold">{{ $order->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-semibold text-blue-600">Rs. {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Status:</span>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="mt-6 pt-4 border-t">
                        <h3 class="font-semibold text-gray-900 mb-2">Delivery Information</h3>
                        <div class="text-left text-sm text-gray-600">
                            <p><strong>Name:</strong> {{ $order->delivery_name }}</p>
                            <p><strong>Phone:</strong> {{ $order->delivery_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
                            @if($order->special_instructions)
                                <p><strong>Special Instructions:</strong> {{ $order->special_instructions }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- What's Next -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">What happens next?</h3>
                    <div class="text-blue-700 text-sm space-y-2">
                        <p>✓ We've received your order and payment confirmation</p>
                        <p>✓ Our team will process your order within 1-2 business days</p>
                        <p>✓ You'll receive a call to schedule delivery within 3-5 business days</p>
                        <p>✓ Free delivery and assembly service included</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-list mr-2"></i>
                        View My Orders
                    </a>
                    <a href="{{ route('user.user') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Continue Shopping
                    </a>
                </div>

                <!-- Contact Information -->
                <div class="mt-12 text-sm text-gray-600">
                    <p class="mb-2">Need help with your order?</p>
                    <p>Contact us at <a href="tel:+94112345678" class="text-blue-600 hover:underline">+94 11 234 5678</a> 
                    or <a href="mailto:orders@furniturestore.lk" class="text-blue-600 hover:underline">orders@furniturestore.lk</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>