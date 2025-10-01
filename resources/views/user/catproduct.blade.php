<x-app-layout>
    @include('user.partials.catnav');

<div class="min-h-screen bg-gray-50">
    <!-- Category Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $category->category_name }}</h1>
                    <p class="text-gray-600 mt-2">
                        {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
                    </p>
                </div>
                <a href="{{ route('user.user') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to All Products
                </a>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container mx-auto px-4 py-8">
        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            @if($product->hasDiscount())
                                <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $product->discount }}% OFF
                                </div>
                            @endif

                            <!-- Stock Status -->
                            @if(!$product->isInStock())
                                <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    Out of Stock
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->product_name }}</h3>
                            
                            <!-- Price Section -->
                            <div class="mb-3">
                                @if($product->hasDiscount())
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg font-bold text-red-600">{{ $product->formatted_discounted_price }}</span>
                                        <span class="text-sm text-gray-500 line-through">{{ $product->formatted_price }}</span>
                                    </div>
                                @else
                                    <span class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                @endif
                            </div>

                            <!-- Product Meta -->
                            <div class="space-y-1 mb-4">
                                @if($product->material)
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Material:</span> {{ $product->material }}
                                    </p>
                                @endif
                                @if($product->colour)
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Color:</span> {{ $product->colour }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-600">
                                    <span class="font-medium">Stock:</span> {{ $product->stock }} available
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <a href="{{ route('user.show', $product) }}" 
                                   class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center block">
                                    View Details
                                </a>

                                @if($product->isInStock())
                                    <div class="flex space-x-2">
                                        <!-- Add to Cart Button -->
                                        <button onclick="addToCart({{ $product->id }})" 
                                                id="add-to-cart-btn-{{ $product->id }}"
                                                class="flex-1 bg-orange-500 text-white py-2 px-3 rounded-lg font-medium hover:bg-orange-600 transition-all duration-300 text-sm flex items-center justify-center transform hover:scale-105 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                            <i class="fas fa-shopping-cart mr-1" id="cart-icon-{{ $product->id }}"></i>
                                            <span id="cart-text-{{ $product->id }}">Add to Cart</span>
                                            <div id="cart-spinner-{{ $product->id }}" class="hidden ml-2">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </button>
                                        
                                        <button onclick="buyNow({{ $product->id }})" 
                                                class="flex-1 bg-green-600 text-white py-2 px-3 rounded-lg font-medium hover:bg-green-700 transition-colors text-sm">
                                            <i class="fas fa-bolt mr-1"></i>
                                            Buy Now
                                        </button>
                                    </div>
                                @else
                                    <button disabled 
                                            class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg font-medium cursor-not-allowed">
                                        <i class="fas fa-times mr-2"></i>
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-6">
                        There are currently no products available in the "{{ $category->category_name }}" category.
                    </p>
                    <a href="{{ route('user.user') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Browse All Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Javascript for addto cart --}}

<script>
function addToCart(productId) {
    const button = document.getElementById(`add-to-cart-btn-${productId}`);
    const icon = document.getElementById(`cart-icon-${productId}`);
    const text = document.getElementById(`cart-text-${productId}`);
    const spinner = document.getElementById(`cart-spinner-${productId}`);
    
    // Disable button and show loading state
    button.disabled = true;
    icon.style.display = 'none';
    spinner.classList.remove('hidden');
    text.textContent = 'Adding...';
    
    // Make AJAX request - adjust URL to match your route structure
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success state
            icon.className = 'fas fa-check mr-1';
            icon.style.display = 'inline';
            text.textContent = 'Added!';
            button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
            button.classList.add('bg-green-500', 'hover:bg-green-600');
            
            // Show success message
            showNotification(data.message, 'success');
            
            // Update cart count in navbar if exists
            updateCartCount(data.cart_count);
            
            // Reset button after 2 seconds
            setTimeout(() => {
                resetButton(productId);
            }, 2000);
        } else {
            // Show error message
            showNotification(data.message, 'error');
            resetButton(productId);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
        resetButton(productId);
    })
    .finally(() => {
        spinner.classList.add('hidden');
    });
}

function resetButton(productId) {
    const button = document.getElementById(`add-to-cart-btn-${productId}`);
    const icon = document.getElementById(`cart-icon-${productId}`);
    const text = document.getElementById(`cart-text-${productId}`);
    
    // Reset button state
    button.disabled = false;
    icon.className = 'fas fa-shopping-cart mr-1';
    icon.style.display = 'inline';
    text.textContent = 'Add to Cart';
    button.classList.remove('bg-green-500', 'hover:bg-green-600');
    button.classList.add('bg-orange-500', 'hover:bg-orange-600');
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function updateCartCount(count) {
    // Update cart count in navbar if element exists
    const cartCountElements = document.querySelectorAll('.cart-count, #cart-count, [data-cart-count]');
    cartCountElements.forEach(element => {
        element.textContent = count;
    });
}

function buyNow(productId) {
    // Add to cart first, then redirect to checkout
    addToCart(productId);
    setTimeout(() => {
        // Redirect to checkout page (replace with your actual route)
        window.location.href = '/checkout';
    }, 1000);
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
</x-app-layout>