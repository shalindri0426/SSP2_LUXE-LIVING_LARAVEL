<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name ?? 'Product' }} - LUXE LIVING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .product-image {
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .price-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .btn-custom {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-cart {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
        }
        
        .btn-cart:hover {
            background: linear-gradient(45deg, #218838, #1ea080);
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-buy {
            background: linear-gradient(45deg, #fd7e14, #e63946);
            border: none;
            color: white;
        }
        
        .btn-buy:hover {
            background: linear-gradient(45deg, #e8590c, #dc2f3a);
            transform: translateY(-2px);
            color: white;
        }
        
        .stock-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #28a745;
        }
        
        .breadcrumb-item a {
            text-decoration: none;
            color: #6c757d;
        }
        
        .breadcrumb-item a:hover {
            color: #007bff;
        }
        
        .alert-success {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.user') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name ?? 'Product' }}</li>
            </ol>
        </nav>

        <!-- Success Messages -->
        <div id="success-message" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
            <i class="fas fa-check-circle me-2"></i>
            <span id="message-text"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-md-6">
                @if($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" 
                         class="img-fluid product-image w-100" 
                         alt="{{ $product->product_name ?? 'Product Image' }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center product-image w-100">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="h-100 d-flex flex-column">
                    <!-- Category Badge -->
                    @if(isset($product->category) && $product->category)
                        <span class="badge bg-secondary mb-3 align-self-start">
                            <i class="fas fa-tag me-1"></i>{{ is_object($product->category) ? $product->category->name : $product->category }}
                        </span>
                    @endif

                    <!-- Product Name -->
                    <h1 class="display-5 fw-bold mb-3">{{ $product->product_name ?? 'Product Name' }}</h1>

                    <!-- Price -->
                    <div class="price-display mb-4">
                        @if(isset($product->price))
                            LKR {{ number_format($product->price, 0) }}
                        @else
                            Price not available
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">Description</h5>
                        <p class="lead text-muted">{{ $product->description ?? 'No description available.' }}</p>
                    </div>

                    <!-- Stock Information -->
                    <div class="stock-info mb-4">
                        @if(isset($product->stock) && $product->stock > 0)
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <strong class="text-success">In Stock</strong>
                                <span class="ms-2 text-muted">({{ $product->stock }} available)</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center">
                                <i class="fas fa-times-circle text-danger me-2"></i>
                                <strong class="text-danger">Out of Stock</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if($product->isInStock())
                        <div class="d-flex gap-3 mb-4">
                            <!-- Add to Cart Button -->
                            <button onclick="addToCart({{ $product->id }})" 
                                    id="add-to-cart-btn-{{ $product->id }}"
                                    class="btn btn-cart btn-custom flex-fill d-flex align-items-center justify-content-center position-relative"
                                    style="min-height: 50px;">
                                <i class="fas fa-shopping-cart me-2" id="cart-icon-{{ $product->id }}"></i>
                                <span id="cart-text-{{ $product->id }}">Add to Cart</span>
                                <div id="cart-spinner-{{ $product->id }}" class="d-none position-absolute">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </button>
                            
                            <button onclick="buyNow({{ route('orders.checkout') }})" 
                                    class="btn btn-buy btn-custom flex-fill d-flex align-items-center justify-content-center"
                                    style="min-height: 50px;">
                                <i class="fas fa-bolt me-2"></i>
                                Buy Now
                            </button>
                        </div>
                    @else
                        <button disabled 
                                class="btn btn-secondary btn-custom w-100 d-flex align-items-center justify-content-center"
                                style="min-height: 50px;">
                            <i class="fas fa-times me-2"></i>
                            Out of Stock
                        </button>
                    @endif

                    <!-- Additional Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="row text-muted">
                            <div class="col-6">
                                <i class="fas fa-truck me-2"></i>Free shipping
                            </div>
                            <div class="col-6">
                                <i class="fas fa-shield-alt me-2"></i>Secure payment
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-5">
            <div class="col-12">
                <a href="{{ route('user.user') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Javascript for addto cart --}}

<script>
function addToCart(productId) {
    const button = document.getElementById(`add-to-cart-btn-${productId}`);
    const icon = document.getElementById(`cart-icon-${productId}`);
    const text = document.getElementById(`cart-text-${productId}`);
    const spinner = document.getElementById(`cart-spinner-${productId}`);
    
    // Disable button and show loading state
    button.disabled = true;
    button.classList.add('disabled');
    icon.style.display = 'none';
    spinner.classList.remove('d-none');
    text.textContent = 'Adding...';
    
    // Make AJAX request
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
            icon.className = 'fas fa-check me-2';
            icon.style.display = 'inline';
            text.textContent = 'Added!';
            button.classList.remove('btn-cart');
            button.classList.add('btn-success');
            
            // Show Bootstrap success message
            showBootstrapNotification(data.message, 'success');
            
            // Update cart count in navbar if exists
            updateCartCount(data.cart_count);
            
            // Reset button after 2 seconds
            setTimeout(() => {
                resetButton(productId);
            }, 2000);
        } else {
            // Show error message
            showBootstrapNotification(data.message, 'error');
            resetButton(productId);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showBootstrapNotification('An error occurred. Please try again.', 'error');
        resetButton(productId);
    })
    .finally(() => {
        spinner.classList.add('d-none');
    });
}

function resetButton(productId) {
    const button = document.getElementById(`add-to-cart-btn-${productId}`);
    const icon = document.getElementById(`cart-icon-${productId}`);
    const text = document.getElementById(`cart-text-${productId}`);
    
    // Reset button state
    button.disabled = false;
    button.classList.remove('disabled', 'btn-success');
    button.classList.add('btn-cart');
    icon.className = 'fas fa-shopping-cart me-2';
    icon.style.display = 'inline';
    text.textContent = 'Add to Cart';
}

function showBootstrapNotification(message, type) {
    const alertDiv = document.getElementById('success-message');
    const messageText = document.getElementById('message-text');
    
    // Update message and show
    messageText.textContent = message;
    alertDiv.style.display = 'block';
    
    // Update alert class based on type
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}

function updateCartCount(count) {
    // Update cart count in navbar if element exists
    const cartCountElements = document.querySelectorAll('.cart-count, #cart-count, [data-cart-count]');
    cartCountElements.forEach(element => {
        element.textContent = count;
        // Add a little animation
        element.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            element.classList.remove('animate__animated', 'animate__pulse');
        }, 1000);
    });
}

function buyNow(productId) {
    // Add to cart first, then redirect to checkout
    addToCart(productId);
    setTimeout(() => {
        // Redirect to checkout page (replace with your actual route)
        window.location.href = '/checkout';
    }, 1500);
}
</script>
</body>
</html>