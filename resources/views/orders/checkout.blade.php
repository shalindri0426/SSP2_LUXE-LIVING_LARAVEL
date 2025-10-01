<x-app-layout>
    @include('user.partials.catnav')

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Order Confirmation</h1>
                        <p class="text-gray-600 mt-2">Review your order and delivery details</p>
                    </div>
                    <a href="{{ route('cart.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Order Form -->
                <div class="lg:col-span-7">
                    <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Customer Information -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Customer Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" value="{{ $user->name }}" readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" value="{{ $user->email }}" readonly 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Delivery Information</h2>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Contact Name *</label>
                                        <input type="text" name="delivery_name" value="{{ old('delivery_name', $user->name) }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Phone *</label>
                                        <input type="tel" name="delivery_phone" value="{{ old('delivery_phone') }}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address *</label>
                                    <textarea name="delivery_address" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('delivery_address') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Instructions</label>
                                    <textarea name="special_instructions" rows="2" placeholder="Assembly instructions, preferred delivery time, etc."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('special_instructions') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>
                            Confirm Order
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                        
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->product_name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">
                                            {{ $item->product->product_name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rs. {{ number_format($cartTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery</span>
                                <span class="text-green-600 font-medium">Free</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold border-t pt-2">
                                <span>Total</span>
                                <span class="text-blue-600">Rs. {{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>