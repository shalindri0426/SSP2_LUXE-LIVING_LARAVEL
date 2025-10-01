<!-- Navigation -->
<nav class="bg-luxe-dark text-white py-3 sticky top-0 z-40 shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <!-- Scrollable Navigation Container -->
            <div class="relative flex-1 max-w-full mr-6">
                <!-- Left Gradient Shadow -->
                <div class="absolute left-0 top-0 h-full w-8 bg-gradient-to-r from-luxe-dark to-transparent z-10 pointer-events-none"></div>
                
                <!-- Right Gradient Shadow -->
                <div class="absolute right-0 top-0 h-full w-8 bg-gradient-to-l from-luxe-dark to-transparent z-10 pointer-events-none"></div>
                
                <!-- Scrollable Content -->
                <div class="overflow-x-auto overflow-y-hidden scrollbar-hide scroll-smooth px-8" 
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    <div class="flex space-x-8 whitespace-nowrap min-w-max py-1">
                        <a href="{{ route('user.user') }}" class="py-2 px-3 border-b-2 border-white font-semibold hover:border-orange-400 transition-all duration-300 hover:text-orange-400 flex-shrink-0">
                            HOME
                        </a>
                        
                        @php
                            $categories = App\Models\Category::all();
                        @endphp
                        
                        @foreach($categories as $category)
                            <a href="{{ route('user.category.products', $category->id) }}" class="py-2 px-3 border-b-2 border-transparent hover:border-orange-400 transition-all duration-300 hover:text-orange-400 hover:scale-105 flex-shrink-0">
                                {{ strtoupper($category->category_name) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <button id="scrollLeft" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-luxe-dark/80 hover:bg-luxe-dark text-white p-2 rounded-r z-20 transition-all duration-300 opacity-0 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button id="scrollRight" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-luxe-dark/80 hover:bg-luxe-dark text-white p-2 rounded-l z-20 transition-all duration-300 opacity-0 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Cart and Wishlist Actions -->
            <div class="flex items-center space-x-6">
                <!-- Wishlist Button -->
                <a href="{{ route('wishlist.index') }}" class="relative group text-white hover:text-orange-400 transition-all duration-300 transform hover:scale-110">
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <i class="fas fa-heart text-xl"></i>
                            <span id="wishlist-counter" class="wishlist-counter absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" style="display: none;">
                                0
                            </span>
                        </div>
                        <span class="text-xs mt-1 opacity-80 group-hover:opacity-100 hidden sm:block">Wishlist</span>
                    </div>
                </a>

                <!-- Cart Button -->
                <a href="{{ route('cart.view') }}" class="relative group text-white hover:text-orange-400 transition-all duration-300 transform hover:scale-110">
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span class="cart-counter absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" 
                                style="display: {{ $cartCount ?? 0 > 0 ? 'flex' : 'none' }};" 
                                data-cart-count>
                                {{ $cartCount ?? 0 }}
                            </span>
                        </div>
                        <span class="text-xs mt-1 opacity-80 group-hover:opacity-100 hidden sm:block">Cart</span>
                    </div>
                </a>

                <!-- Mobile Menu Button -->
                <button class="md:hidden ml-4 text-white hover:text-orange-400 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Custom CSS for enhanced scrolling and cart/wishlist styling -->
<style>
    /* Hide scrollbar for webkit browsers */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Smooth scrolling behavior */
    .scroll-smooth {
        scroll-behavior: smooth;
    }
    
    /* Fade in arrows on hover */
    .container:hover #scrollLeft,
    .container:hover #scrollRight {
        opacity: 0.7;
    }
    
    /* Active link styling */
    .nav-link-active {
        border-bottom-color: #fb923c !important;
        color: #fb923c !important;
    }
    
    /* Cart and Wishlist button animations */
    .group:hover .fas {
        animation: bounce 0.6s ease-in-out;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-3px);
        }
        60% {
            transform: translateY(-2px);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .flex.items-center.space-x-6 {
            space-x: 1rem;
        }
    }
</style>

<!-- JavaScript for scroll functionality and cart/wishlist counters -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.overflow-x-auto');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');
    
    if (scrollLeftBtn && scrollRightBtn && scrollContainer) {
        // Scroll left
        scrollLeftBtn.addEventListener('click', function() {
            scrollContainer.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });
        
        // Scroll right
        scrollRightBtn.addEventListener('click', function() {
            scrollContainer.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });
        
        // Show/hide arrows based on scroll position
        function updateArrowsVisibility() {
            const isAtStart = scrollContainer.scrollLeft <= 0;
            const isAtEnd = scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer.clientWidth - 1;
            
            scrollLeftBtn.style.display = isAtStart ? 'none' : 'block';
            scrollRightBtn.style.display = isAtEnd ? 'none' : 'block';
        }
        
        // Update arrows on scroll
        scrollContainer.addEventListener('scroll', updateArrowsVisibility);
        
        // Initial check
        updateArrowsVisibility();
        
        // Update on window resize
        window.addEventListener('resize', updateArrowsVisibility);
    }
    
    // Mouse wheel horizontal scrolling
    if (scrollContainer) {
        scrollContainer.addEventListener('wheel', function(e) {
            if (e.deltaY !== 0) {
                e.preventDefault();
                scrollContainer.scrollBy({
                    left: e.deltaY,
                    behavior: 'smooth'
                });
            }
        });
    }
    
    // Cart and Wishlist counter functions
    function updateCartCounter(count) {
        const counter = document.querySelector('.cart-counter');
        if (counter) {
            if (count > 0) {
                counter.textContent = count > 99 ? '99+' : count;
                counter.style.display = 'flex';
            } else {
                counter.style.display = 'none';
            }
        }
    }
    
    function updateWishlistCounter(count) {
        const counter = document.querySelector('.wishlist-counter');
        if (counter) {
            if (count > 0) {
                counter.textContent = count > 99 ? '99+' : count;
                counter.style.display = 'flex';
            } else {
                counter.style.display = 'none';
            }
        }
    }
    
    // Example usage - you can call these functions when items are added/removed
    // updateCartCounter(3); // Shows "3" on cart icon
    // updateWishlistCounter(5); // Shows "5" on wishlist icon
});
</script>