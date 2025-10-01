{{-- <h1>CREATE product</h1>

<form action="{{ route('add.product') }}" method="POST">
 @csrf
    <label for="name">product Name</label><br>
    <input type="text" name="product_name" placeholder="Enter product name"><br><br>

    <button value="Create">
        Add product
    </button>
</form> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <i class="fas fa-plus-circle text-blue-600"></i>
                        CREATE PRODUCT
                    </h1>
                    <a href="{{ route('product.manage') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-left"></i>
                        Back to Products
                    </a>
                </div>
                <p class="text-gray-600 mt-2">Add new products</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-edit text-gray-600"></i>
                    Product Information
                </h3>
                <p class="text-gray-600 text-sm mt-1">Fill in the details for your new product</p>
            </div>

            <!-- Form Content -->
            <div class="px-8 py-8">
                

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-red-800 font-medium">Please fix the following errors:</p>
                            <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('add.product') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- category Dropdown -->
                    <div class="space-y-2">
                        <label for="category_id" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-list text-purple-500"></i>
                            product
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-800">
                            <option value="">-- Select category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- product Name Field -->
                    <div class="space-y-2">
                        <label for="product_name" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-tag text-blue-500"></i>
                            Product Name
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="product_name"
                                   name="product_name" 
                                   value="{{ old('product_name') }}"
                                   placeholder="Enter product name" 
                                   required
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400 text-gray-800">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-pencil-alt text-gray-400"></i>
                            </div>
                        </div>
                        @error('product_name')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror

                        @if (session('success'))
                        <p class="text-green-600 text-sm flex items-center gap-1">
                            {{ session('success') }}
                        </p>
                        @endif
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <label for="image" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-image text-pink-500"></i>
                            Product Image
                        </label>
                        <input type="file" id="image" name="image"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 text-gray-800" required>
                        @error('image')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <label for="price" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-green-500"></i>
                            Price
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" required step="0.01" id="price" name="price" value="{{ old('price') }}" required
                            placeholder="Enter price"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-800">
                        @error('price')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- discount -->
                    <div class="space-y-2">
                        <label for="price" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-green-500"></i>
                            Discount
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number"  step="0.01" id="discount" name="discount" value="{{ old('discount') }}" required
                            placeholder="Enter price"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-800">
                        @error('discount')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-indigo-500"></i>
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4" placeholder="Enter product description"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-800">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Material -->
                    <div class="space-y-2">
                        <label for="material" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-couch text-yellow-500"></i>
                            Material
                        </label>
                        <input type="text" id="material" name="material" value="{{ old('material') }}"
                            placeholder="Enter material (e.g., Wood, Leather)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 text-gray-800">
                        @error('material')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Colour -->
                    <div class="space-y-2">
                        <label for="colour" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-palette text-red-500"></i>
                            Colour
                        </label>
                        <input type="text" id="colour" name="colour" value="{{ old('colour') }}"
                            placeholder="Enter colour"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-gray-800">
                        @error('colour')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="space-y-2">
                        <label for="stock" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-boxes text-blue-500"></i>
                            Stock
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock') }}" required
                            placeholder="Enter available stock"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-800">
                        @error('stock')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Success Message -->
                @if(session('added'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-green-800 font-medium">Success!</p>
                            <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-save"></i>
                            Add Product
                        </button>
                        
                        <button type="button" 
                                onclick="window.location.href='{{ route('product.manage') }}'"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-blue-800 font-semibold mb-2">Tips for Creating Categories</h4>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                            Use clear, descriptive names that customers will easily understand
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                            Consider how products will be grouped and organized
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                            Keep product names concise but informative
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced UX -->
    <script>
        // Auto-focus on the input field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('product_name').focus();
            document.getElementById('description').focus();
            document.getElementById('material').focus();
            document.getElementById('colour').focus();
            document.getElementById('stock').focus();

        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const productName = document.getElementById('product_name').value.trim();
            const productImage = document.getElementById('image').value.trim();
            const productPrice = document.getElementById('price').value.trim();
            const productStock = document.getElementById('stock').value.trim();

            
            if (!productName) {
                e.preventDefault();
                alert('Please enter a product name');
                document.getElementById('product_name').focus();
                return false;
            }
            
            if (productName.length < 2) {
                e.preventDefault();
                alert('product name must be at least 2 characters long');
                document.getElementById('product_name').focus();
                return false;
            }

            if (!productImage) {
                e.preventDefault();
                alert('Please upload an image');
                document.getElementById('image').focus();
                return false;
            }

            if (!productPrice) {
                e.preventDefault();
                alert('Please enter a price');
                document.getElementById('price').focus();
                return false;
            }

            if (!productStock) {
                e.preventDefault();
                alert('Please enter the quantity');
                document.getElementById('stock').focus();
                return false;
            }
        });

        // Real-time validation feedback
        document.getElementById('product_name').addEventListener('input', function() {
            const value = this.value.trim();
            const submitBtn = document.querySelector('button[type="submit"]');
            
            if (value.length >= 2) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                this.classList.remove('border-green-300');
                if (value.length > 0) {
                    this.classList.add('border-red-300');
                }
            }
        });
    </script>
</body>
</html>