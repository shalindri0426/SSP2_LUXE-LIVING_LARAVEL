<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Wishlist</h1>
            <p class="mt-2 text-gray-600">{{ $wishlist->count() }} items in your wishlist</p>
        </div>

        @if($wishlist->isEmpty())
            <!-- Empty Wishlist -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-6">Start adding products you love!</p>
                <a href="{{ route('user.user') }}" class="inline-block bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition-colors">
                    Continue Shopping
                </a>
            </div>
        @else
            <!-- Wishlist Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlist as $item)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 wishlist-item" data-item-id="{{ $item['id'] }}" data-product-id="{{ $item['product']->id }}">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ asset('images/products' . $item['product']->image) }}" 
                                 alt="{{ $item['product']->name }}"
                                 class="w-full h-full object-cover">
                            
                            <!-- Remove Button -->
                            <button onclick="removeFromWishlist({{ $item['product']->id }})" 
                                    class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center hover:bg-red-50 transition-colors group">
                                <i class="fas fa-times text-gray-600 group-hover:text-red-500"></i>
                            </button>
                        </div>

                        <!-- Product Details -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">
                                {{ $item['product']->name }}
                            </h3>
                            
                            <div class="flex items-center justify-between mt-3">
                                <div>
                                    <p class="text-xl font-bold text-orange-500">
                                        Rs. {{ number_format($item['product']->price, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Added {{ $item['created_at']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('user.show', $item['product']->id) }}" 
                                   class="block w-full bg-orange-500 text-white text-center py-2 rounded-lg hover:bg-orange-600 transition-colors">
                                    View Details
                                </a>
                                <button onclick="addToCart({{ $item['product']->id }})" 
                                        class="block w-full bg-gray-100 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bulk Actions -->
            <div class="mt-8 flex justify-between items-center">
                <button onclick="clearWishlist()" class="text-red-500 hover:text-red-600 font-medium">
                    <i class="fas fa-trash mr-2"></i>Clear All
                </button>
                <a href="{{ route('user.user') }}" class="text-orange-500 hover:text-orange-600 font-medium">
                    <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Remove item from wishlist
async function removeFromWishlist(productId) {
    if (!confirm('Remove this item from your wishlist?')) {
        return;
    }

    try {
        const response = await fetch(`/customer/wishlist/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || data.message || 'Failed to remove item');
        }

        // Remove item from DOM with animation
        const itemElement = document.querySelector(`[data-product-id="${productId}"]`);
        if (itemElement) {
            itemElement.style.transition = 'opacity 0.3s, transform 0.3s';
            itemElement.style.opacity = '0';
            itemElement.style.transform = 'scale(0.9)';
            
            setTimeout(() => {
                itemElement.remove();
                
                // Check if wishlist is empty and reload page if needed
                const remainingItems = document.querySelectorAll('.wishlist-item');
                if (remainingItems.length === 0) {
                    location.reload();
                } else {
                    // Update count in header
                    const countElement = document.querySelector('.text-gray-600');
                    if (countElement) {
                        countElement.textContent = `${remainingItems.length} items in your wishlist`;
                    }
                }
            }, 300);
        }

        // Update counter in navbar
        if (data.count !== undefined) {
            updateWishlistCounter(data.count);
        }
        
        showNotification(data.message || 'Item removed from wishlist', 'success');

    } catch (error) {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to remove item', 'error');
    }
}

// Add to cart function
async function addToCart(productId) {
    try {
        // Implement your add to cart logic here
        // Example:
        const response = await fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: 1 })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || data.message || 'Failed to add to cart');
        }

        showNotification(data.message || 'Added to cart successfully', 'success');
        
        // Optional: Update cart counter
        if (data.cart_count !== undefined) {
            updateCartCounter(data.cart_count);
        }

    } catch (error) {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to add to cart', 'error');
    }
}

// Clear entire wishlist
async function clearWishlist() {
    if (!confirm('Are you sure you want to clear your entire wishlist?')) {
        return;
    }

    const items = document.querySelectorAll('.wishlist-item');
    const productIds = Array.from(items).map(item => item.dataset.productId);
    
    let successCount = 0;
    let errorCount = 0;

    for (const productId of productIds) {
        try {
            const response = await fetch(`/customer/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                successCount++;
            } else {
                errorCount++;
            }
        } catch (error) {
            console.error('Error removing item:', error);
            errorCount++;
        }
    }

    if (errorCount === 0) {
        showNotification('Wishlist cleared successfully', 'success');
    } else {
        showNotification(`${successCount} items removed, ${errorCount} failed`, 'error');
    }

    setTimeout(() => location.reload(), 1000);
}

// Update wishlist counter
function updateWishlistCounter(count) {
    const counter = document.getElementById('wishlist-counter');
    if (counter) {
        counter.textContent = count;
        counter.style.display = count > 0 ? 'flex' : 'none';
    }
}

// Update cart counter (optional)
function updateCartCounter(count) {
    const counter = document.getElementById('cart-counter');
    if (counter) {
        counter.textContent = count;
        counter.style.display = count > 0 ? 'flex' : 'none';
    }
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
</x-app-layout>
