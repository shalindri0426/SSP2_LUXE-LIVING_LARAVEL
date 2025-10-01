<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <i class="fas fa-edit text-emerald-600"></i>
                        EDIT product
                    </h1>
                    <a href="{{ route('product.manage') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-left"></i>
                        Back to Categories
                    </a>
                </div>
                <p class="text-gray-600 mt-2">Update the details for "{{ $product_info->product_name }}"</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-pencil-alt text-gray-600"></i>
                    Update product Information
                </h3>
                <p class="text-gray-600 text-sm mt-1">Make changes to your product details</p>
            </div>

            <!-- Form Content -->
            <div class="px-8 py-8">
                <!-- Success Message -->
                @if (session('success'))
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

                @if (session('updated'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-green-800 font-medium">Updated Successfully!</p>
                            <p class="text-green-700 text-sm">{{ session('updated') }}</p>
                        </div>
                    </div>
                </div>
                @endif

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

                <!-- Current product Info Card -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-info text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-blue-800 font-medium">Current product</p>
                            <p class="text-blue-700 text-sm">ID: {{ $product_info->id }} | Name: "{{ $product_info->product_name }}"</p>
                        </div>
                    </div>
                </div>

                <form action="{{route('update.product',$product_info->id )}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    
                    <!-- Category Dropdown -->
                    <div class="space-y-2">
                        <label for="category_id" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-list text-purple-500"></i>
                            Category
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-gray-800">
                            <option value="">-- Select category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product_info->category_id) == $cat->id ? 'selected' : '' }}>
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
                        <p class="text-gray-500 text-xs">Select the appropriate category for this product</p>
                    </div>

                    <!-- Product Name Field -->
                    <div class="space-y-2">
                        <label for="product_name" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-tag text-emerald-500"></i>
                            Product Name
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                id="product_name"
                                name="product_name" 
                                value="{{ old('product_name', $product_info->product_name) }}"
                                placeholder="Enter updated product name" 
                                required
                                class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 placeholder-gray-400 text-gray-800">
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
                        <p class="text-gray-500 text-xs">Update the product name as needed</p>
                    </div>

                    <!-- Current Image Display & New Image Upload -->
                    <div class="space-y-2">
                        <label for="image" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-image text-pink-500"></i>
                            Product Image
                        </label>
                        
                        <!-- Display Current Image -->
                        @if($product_info->image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ asset('images/products/' . $product_info->image) }}" 
                                alt="Current product image" 
                                class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            <p class="text-xs text-gray-500 mt-1">{{ $product_info->image }}</p>
                        </div>
                        @endif
                        
                        <input type="file" id="image" name="image"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 text-gray-800">
                        @error('image')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Leave empty to keep current image, or upload a new one to replace it</p>
                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <label for="price" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-green-500"></i>
                            Price
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" required step="0.01" id="price" name="price" 
                            value="{{ old('price', $product_info->price) }}" required
                            placeholder="Enter updated price"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-800">
                        @error('price')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the product price</p>
                    </div>

                    <!-- discount -->
                    <div class="space-y-2">
                        <label for="discount" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-green-500"></i>
                            Discount
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" required step="0.01" id="discount" name="discount" 
                            value="{{ old('discount', $product_info->discount) }}" required
                            placeholder="Enter updated price"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-800">
                        @error('discount')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the product discount</p>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-indigo-500"></i>
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4" placeholder="Enter updated product description"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-gray-800">{{ old('description', $product_info->description) }}</textarea>
                        @error('description')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the product description if needed</p>
                    </div>

                    <!-- Material -->
                    <div class="space-y-2">
                        <label for="material" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-couch text-yellow-500"></i>
                            Material
                        </label>
                        <input type="text" id="material" name="material" 
                            value="{{ old('material', $product_info->material) }}"
                            placeholder="Enter updated material (e.g., Wood, Leather)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 text-gray-800">
                        @error('material')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the material if needed</p>
                    </div>

                    <!-- Colour -->
                    <div class="space-y-2">
                        <label for="colour" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-palette text-red-500"></i>
                            Colour
                        </label>
                        <input type="text" id="colour" name="colour" 
                            value="{{ old('colour', $product_info->colour) }}"
                            placeholder="Enter updated colour"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-gray-800">
                        @error('colour')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the colour if needed</p>
                    </div>

                    <!-- Stock -->
                    <div class="space-y-2">
                        <label for="stock" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-boxes text-blue-500"></i>
                            Stock
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" 
                            value="{{ old('stock', $product_info->stock) }}" required
                            placeholder="Enter updated available stock"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-800">
                        @error('stock')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the available stock quantity</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-save"></i>
                            Update product
                        </button>
                        
                        <button type="button" 
                                onclick="window.location.href='{{ route('product.manage') }}'"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        
                        <button type="button" 
                                onclick="resetForm()"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-undo"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change History Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-history text-gray-600"></i>
                <h4 class="text-lg font-semibold text-gray-800">Edit Information</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-600 font-medium">product ID</p>
                    <p class="text-gray-800 font-semibold">{{ $product_info->id }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-600 font-medium">Original Name</p>
                    <p class="text-gray-800 font-semibold">"{{ $product_info->product_name }}"</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-600 font-medium">Last Modified</p>
                    <p class="text-gray-800 font-semibold">{{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-amber-50 border border-amber-200 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-amber-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-amber-800 font-semibold mb-2">Edit Tips</h4>
                    <ul class="text-amber-700 text-sm space-y-1">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-amber-500 mt-0.5 text-xs"></i>
                            Make sure the new name is descriptive and clear
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-amber-500 mt-0.5 text-xs"></i>
                            Consider how this change will affect product organization
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-amber-500 mt-0.5 text-xs"></i>
                            Use the reset button to restore the original name if needed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced UX -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    // Save the original form data when page loads
    const initialData = new FormData(form);
    let initialEntries = {};
    initialData.forEach((value, key) => {
        initialEntries[key] = value;
    });

    form.addEventListener('submit', function (e) {
        const currentData = new FormData(form);
        let changed = false;

        // Compare each field
        currentData.forEach((value, key) => {
            if (initialEntries[key] != value) {
                changed = true;
            }
        });

        // If nothing changed, show confirm box
        if (!changed) {
            const proceed = confirm('No changes detected. Do you still want to update?');
            if (!proceed) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>

</body>
</html>