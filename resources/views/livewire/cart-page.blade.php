<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Cart</h1>
                    <p class="text-gray-600 mt-2">
                        {{ $cartCount }} {{ Str::plural('item', $cartCount) }} in your cart
                    </p>
                </div>
                <a href="{{ route('user.user') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Product</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Price</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Quantity</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Total</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Product Info -->
                                            <td class="px-6 py-6">
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
                                                    <div class="min-w-0 flex-1">
                                                        <h3 class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $item->product->product_name }}
                                                        </h3>
                                                        @if($item->product->material)
                                                            <p class="text-xs text-gray-500 mt-1">
                                                                Material: {{ $item->product->material }}
                                                            </p>
                                                        @endif
                                                        @if($item->product->colour)
                                                            <p class="text-xs text-gray-500">
                                                                Color: {{ $item->product->colour }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Price -->
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-sm font-medium text-gray-900">
                                                    Rs. {{ number_format($item->price, 2) }}
                                                </span>
                                            </td>

                                            <!-- Quantity -->
<td class="px-6 py-6 text-center">
    <div class="flex items-center justify-center space-x-2">
        <button wire:click="updateQuantity({{ $item->id }}, -1)" 
                @if($item->quantity <= 1) disabled @endif
                class="w-8 h-8 rounded-full {{ $item->quantity <= 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300' }} flex items-center justify-center transition-colors">
            <i class="fas fa-minus text-xs"></i>
        </button>
        
        <span class="w-12 text-center text-sm font-medium">
            {{ $item->quantity }}
        </span>
        
        <button wire:click="updateQuantity({{ $item->id }}, 1)" 
                @if($item->quantity >= $item->product->stock) disabled @endif
                class="w-8 h-8 rounded-full {{ $item->quantity >= $item->product->stock ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300' }} flex items-center justify-center transition-colors">
            <i class="fas fa-plus text-xs"></i>
        </button>
    </div>
    <p class="text-xs text-gray-500 mt-1">
        Stock: {{ $item->product->stock }}
    </p>
</td>

                                            <!-- Total -->
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-sm font-bold text-gray-900">
                                                    Rs. {{ number_format($item->price * $item->quantity, 2) }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-6 text-center">
                                                <div class="flex flex-col space-y-2">
                                                    <a href="{{ route('user.show', $item->product) }}" 
                                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        View Details
                                                    </a>
                                                    <button wire:click="removeItem({{ $item->product_id }})" 
                                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-full hover:bg-red-700 transition-colors">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Remove
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ $cartCount }} items)</span>
                                <span class="font-medium">Rs. {{ number_format($cartTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-green-600 font-medium">Free</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium">Rs. 0.00</span>
                            </div>
                            <hr class="my-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-600">Rs. {{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('orders.checkout') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors mb-3 block text-center">
                            <i class="fas fa-credit-card mr-2"></i>
                            Proceed to Checkout
                        </a>
                        
                        <button wire:click="clearCart" 
                                onclick="return confirm('Are you sure you want to clear your entire cart? This action cannot be undone.')"
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-shopping-cart text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">
                        Looks like you haven't added anything to your cart yet.
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