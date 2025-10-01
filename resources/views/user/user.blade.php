<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LUXE-LIVING | Premium Furniture Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'luxe-brown': '#8B4513',
                        'luxe-cream': '#F5F5DC',
                        'luxe-dark': '#2C3E50'
                    }
                }
            }
        }
    </script>
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .product-card {
            transition: all 0.3s ease;
            cursor: pointer;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .price-badge {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(44, 62, 80, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
            z-index: 10;
        }
        
        .product-image {
            height: 250px;
            width: 100%;
            object-fit: cover;
            background-color: #f3f4f6;
        }
        
        .product-image-placeholder {
            height: 250px;
            width: 100%;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(1.1); }
            75% { transform: scale(1.2); }
        }
        
        @keyframes heartBreak {
            0% { transform: scale(1.1); }
            50% { transform: scale(0.8); }
            100% { transform: scale(1); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .wishlist-btn:hover .wishlist-icon {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        .wishlist-btn:disabled {
            pointer-events: none;
            opacity: 0.7;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    @include('user.partials.catnav')

    <!-- Hero Section -->
    <section class="relative h-96 bg-gradient-to-r from-orange-100 to-orange-50 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
        <div class="relative h-full flex items-center">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="text-left">
                        <!-- Search Bar -->
                        <div class="hidden md:flex flex-1 max-w-md mx-6">
                            <div class="relative w-full">
                                <input type="text" placeholder="Search furniture..." 
                                       class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-luxe-brown focus:border-transparent">
                                <button class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-search text-gray-400"></i>
                                </button>
                            </div>
                        </div><br><br>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4 leading-tight">
                            NEW ARRIVALS JUST DROPPED!
                        </h1>
                        <p class="text-xl text-gray-700 mb-6 font-medium">
                            UPGRADE YOUR SPACE TODAY
                        </p>
                        <button class="bg-luxe-dark text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            Shop Now
                        </button>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-orange-200 to-orange-100 rounded-2xl p-8 shadow-xl">
                            <div class="flex items-center justify-center h-64">
                                <div class="text-center">
                                    <i class="fas fa-couch text-6xl text-luxe-brown mb-4"></i>
                                    <p class="text-lg text-gray-700 font-medium">Premium Furniture Collection</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-sm text-gray-600 mb-2">Welcome to</h2>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-6">LUXE - LIVING</h1>
                <p class="text-lg text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    Discover timeless elegance and modern comfort with our curated collection of luxury furniture. From statement sofas to 
                    artisan-crafted accents, every piece is designed to transform your space into a sanctuary of style.
                </p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">OUR PRODUCTS</h2>
                @if(isset($products) && $products->total() > 0)
                    <div class="text-gray-600">
                        Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products
                    </div>
                @endif
            </div>
            
            @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="product-card group" onclick="window.location.href='{{ route('user.show', $product) }}'">
                            <div class="relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}" 
                                         alt="{{ $product->product_name ?? 'Product Image' }}" 
                                         class="product-image group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-chair text-5xl text-white opacity-80"></i>
                                    </div>
                                @endif
                                
                                @if(isset($product->price) && $product->price > 0)
                                    <span class="price-badge">
                                        LKR {{ number_format($product->price, 0) }}
                                    </span>
                                @endif

                                <!-- Heart Button -->
                                <button onclick="toggleWishlist({{ $product->id }}, this, event)" 
                                        data-product-id="{{ $product->id }}"
                                        class="absolute top-3 right-3 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity wishlist-btn z-10">
                                    <i class="fas fa-heart text-gray-400 hover:text-red-500 transition-colors wishlist-icon"></i>
                                </button>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 truncate">
                                    {{ $product->product_name ?? 'Unnamed Product' }}
                                </h3>
                                
                                @if(isset($product->description) && $product->description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    @if(isset($product->category) && $product->category)
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                            {{ is_object($product->category) ? $product->category->name : $product->category }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Uncategorized</span>
                                    @endif
                                    
                                    @if(isset($product->stock))
                                        @if($product->stock > 0)
                                            <span class="text-xs text-green-600 font-medium">
                                                <i class="fas fa-check"></i> In Stock
                                            </span>
                                        @else
                                            <span class="text-xs text-red-600 font-medium">
                                                <i class="fas fa-times"></i> Out of Stock
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">No products found</h3>
                    <p class="text-gray-500">Check back later for new products!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-luxe-dark text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-couch text-luxe-dark text-lg"></i>
                        </div>
                        <span class="text-xl font-bold">LUXE-LIVING</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        We bring you luxury furniture that stands out in style, comfort, and craftsmanship. From elegant 
                        to statement pieces, every item is backed by our trusted authenticity and delivered with care.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">About Us</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Our Story</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Press</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="font-semibold mb-4">Help Center</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Returns</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <p>luxeliving@gmail.com</p>
                        <p>Hot Line: 070 000 000</p>
                    </div>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    Copyright © 2025 LUXE-LIVING
                </p>
            </div>
        </div>
    </footer>

    <script>
    // CSRF Token - defined at top level
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Toggle wishlist function
    async function toggleWishlist(productId, button, event) {
        // Prevent event bubbling and default behavior
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        // Prevent multiple clicks
        if (button.disabled) return;
        button.disabled = true;

        const icon = button.querySelector('.wishlist-icon');
        const isInWishlist = icon.classList.contains('text-red-500');

        try {
            let response;
            
            if (isInWishlist) {
                // Remove from wishlist
                response = await fetch(`/customer/wishlist/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            } else {
                // Add to wishlist
                response = await fetch('/customer/wishlist/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ product_id: productId })
                });
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || data.message || 'Failed to update wishlist');
            }

            // Update icon appearance
            if (data.inWishlist) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
                icon.style.animation = 'heartBeat 0.6s ease-in-out';
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-400');
                icon.style.animation = 'heartBreak 0.4s ease-in-out';
            }

            // Reset animation
            setTimeout(() => {
                icon.style.animation = '';
            }, 600);

            // Update wishlist counter
            if (data.count !== undefined) {
                updateWishlistCounter(data.count);
            } else {
                fetchWishlistCount();
            }

            // Show notification
            showNotification(data.message, 'success');

        } catch (error) {
            console.error('Wishlist error:', error);
            showNotification(error.message || 'Failed to update wishlist', 'error');
        } finally {
            button.disabled = false;
        }
    }

    // Fetch wishlist count
    async function fetchWishlistCount() {
        try {
            const response = await fetch('/customer/wishlist/count', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                updateWishlistCounter(data.count);
            }
        } catch (error) {
            console.error('Failed to fetch wishlist count:', error);
        }
    }

    // Update wishlist counter in navbar
    function updateWishlistCounter(count) {
        const counter = document.getElementById('wishlist-counter');
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

    // Check wishlist status on page load
    document.addEventListener('DOMContentLoaded', async function() {
        const wishlistButtons = document.querySelectorAll('.wishlist-btn');
        
        // Fetch count first
        fetchWishlistCount();
        
        // Check each product's wishlist status
        for (const button of wishlistButtons) {
            const productId = button.dataset.productId;
            if (!productId) continue;

            try {
                const response = await fetch(`/customer/wishlist/check/${productId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const icon = button.querySelector('.wishlist-icon');
                    
                    if (data.inWishlist && icon) {
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-red-500');
                    }
                }
            } catch (error) {
                console.error('Failed to check wishlist status:', error);
            }
        }
    });
</script>
</body>
</html>
</x-app-layout>