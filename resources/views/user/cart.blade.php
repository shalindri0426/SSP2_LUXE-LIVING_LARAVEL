<x-app-layout>
    @include('user.partials.catnav');

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

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
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
                                        <tr class="hover:bg-gray-50" id="cart-row-{{ $item->id }}">
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
                                                    <!-- Decrease Quantity Form -->
                                                    @if($item->quantity > 1)
                                                        <form method="POST" action="{{ route('cart.update') }}" class="inline-block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                                            <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                            <button type="submit" 
                                                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button disabled 
                                                                class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center cursor-not-allowed">
                                                            <i class="fas fa-minus text-xs"></i>
                                                        </button>
                                                    @endif
                                                    
                                                    <!-- Current Quantity Display -->
                                                    <span class="w-12 text-center text-sm font-medium">
                                                        {{ $item->quantity }}
                                                    </span>
                                                    
                                                    <!-- Increase Quantity Form -->
                                                    @if($item->quantity < $item->product->stock)
                                                        <form method="POST" action="{{ route('cart.update') }}" class="inline-block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                            <button type="submit" 
                                                                    class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center transition-colors">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button disabled 
                                                                class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center cursor-not-allowed">
                                                            <i class="fas fa-plus text-xs"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Stock: {{ $item->product->stock }}
                                                </p>
                                            </td>

                                            <!-- Total -->
                                            <td class="px-6 py-6 text-center">
                                                <span class="text-sm font-bold text-gray-900" id="total-{{ $item->id }}">
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
                                                    <button onclick="removeFromCart({{ $item->product_id }})" 
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
                                <span class="font-medium" id="cart-subtotal">Rs. {{ number_format($cartTotal, 2) }}</span>
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
                                <span class="text-blue-600" id="cart-total">Rs. {{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('orders.checkout') }}" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors mb-3 block text-center">
                            <i class="fas fa-credit-card mr-2"></i>
                            Proceed to Checkout
                        </a>
                        
                        <form method="POST" action="{{ route('cart.clear') }}" class="w-full" onsubmit="return confirmClearCart()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Clear Cart
                            </button>
                        </form>

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

<!-- Success/Error Messages -->
<div id="notification-container" class="fixed top-4 right-4 z-50"></div>

{{-- JavaScript --}}
<script>
// Update quantity function 
function updateQuantity(cartItemId, newQuantity) {
    if (newQuantity < 1) return;
    
    console.log('Updating quantity:', {cartItemId, newQuantity});
    
    const row = document.getElementById(`cart-row-${cartItemId}`);
    const quantitySpan = document.getElementById(`quantity-${cartItemId}`);
    const totalSpan = document.getElementById(`total-${cartItemId}`);
    
    // Add loading state
    if (row) {
        row.classList.add('loading');
    }
    
    fetch('{{ route("cart.update") }}', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            cart_item_id: cartItemId,
            quantity: newQuantity
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Success response:', data);
        if (data.success) {
            if (quantitySpan) quantitySpan.textContent = newQuantity;
            if (totalSpan) totalSpan.textContent = `Rs. ${data.item_total}`;
            updateCartSummary();
            showNotification(data.message, 'success');
            
            // Update button states
            updateQuantityButtons(cartItemId, newQuantity);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        // Remove loading state
        if (row) {
            row.classList.remove('loading');
        }
    });
}

// Update quantity buttons state
function updateQuantityButtons(cartItemId, currentQuantity) {
    const minusBtn = document.querySelector(`button[onclick*="updateQuantity(${cartItemId}, ${currentQuantity - 1})"]`);
    const plusBtn = document.querySelector(`button[onclick*="updateQuantity(${cartItemId}, ${currentQuantity + 1})"]`);
    
    if (minusBtn) {
        minusBtn.disabled = currentQuantity <= 1;
        minusBtn.onclick = () => updateQuantity(cartItemId, currentQuantity - 1);
    }
    
    if (plusBtn) {
        const stockElement = document.querySelector(`#cart-row-${cartItemId} .text-xs.text-gray-500`);
        const stockText = stockElement ? stockElement.textContent : '';
        const stock = parseInt(stockText.replace('Stock: ', '')) || 999;
        
        plusBtn.disabled = currentQuantity >= stock;
        plusBtn.onclick = () => updateQuantity(cartItemId, currentQuantity + 1);
    }
}

// Remove from cart function with better debugging
function removeFromCart(productId) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) {
        return;
    }
    
    console.log('Removing from cart:', productId);
    
    fetch('{{ route("cart.remove") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => {
        console.log('Remove response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Remove success response:', data);
        if (data.success) {
            // Find and remove the row
            const rows = document.querySelectorAll('[id^="cart-row"]');
            rows.forEach(row => {
                const removeBtn = row.querySelector(`button[onclick*="removeFromCart(${productId})"]`);
                if (removeBtn) {
                    row.remove();
                }
            });
            
            updateCartSummary();
            showNotification(data.message, 'success');
            
            // Reload page if cart is empty
            if (data.cart_count === 0) {
                setTimeout(() => location.reload(), 1500);
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Remove error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    });
}

// Update cart summary
function updateCartSummary() {
    let subtotal = 0;
    const totalSpans = document.querySelectorAll('[id^="total-"]');
    
    totalSpans.forEach(span => {
        const amountText = span.textContent.replace('Rs. ', '').replace(/,/g, '');
        const amount = parseFloat(amountText);
        if (!isNaN(amount)) {
            subtotal += amount;
        }
    });
    
    const subtotalElement = document.getElementById('cart-subtotal');
    const totalElement = document.getElementById('cart-total');
    
    if (subtotalElement) {
        subtotalElement.textContent = `Rs. ${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }
    
    if (totalElement) {
        totalElement.textContent = `Rs. ${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }
}

// Clear entire cart

function confirmClearCart() {
    return confirm('Are you sure you want to clear your entire cart? This action cannot be undone.');
}

// Show notification
function showNotification(message, type) {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
    const notification = document.createElement('div');
    
    const typeColors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const typeIcons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        info: 'fa-info-circle'
    };
    
    notification.className = `${typeColors[type]} text-white px-6 py-4 rounded-lg shadow-lg mb-4 max-w-sm`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${typeIcons[type]} mr-3"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Debug function - call this in browser console to check cart state
function debugCart() {
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    console.log('Update URL:', '{{ route("cart.update") }}');
    console.log('Remove URL:', '{{ route("cart.remove") }}');
}

// Initialize debugging
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cart page loaded');
    debugCart();
});
</script>

<style>
/* Additional styles for better mobile responsiveness */
@media (max-width: 768px) {
    .overflow-x-auto table {
        min-width: 600px;
    }
    
    .lg\:col-span-8,
    .lg\:col-span-4 {
        grid-column: span 1;
    }
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading * {
    cursor: wait !important;
}
</style>
</x-app-layout>