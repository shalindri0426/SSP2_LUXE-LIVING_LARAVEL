<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
                        EDIT CATEGORY
                    </h1>
                    <a href="{{ route('category.manage') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-left"></i>
                        Back to Categories
                    </a>
                </div>
                <p class="text-gray-600 mt-2">Update the details for "{{ $category_info->category_name }}"</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-pencil-alt text-gray-600"></i>
                    Update Category Information
                </h3>
                <p class="text-gray-600 text-sm mt-1">Make changes to your category details</p>
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

                <!-- Current Category Info Card -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-info text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-blue-800 font-medium">Current Category</p>
                            <p class="text-blue-700 text-sm">ID: {{ $category_info->id }} | Name: "{{ $category_info->category_name }}"</p>
                        </div>
                    </div>
                </div>

                <form action="{{route('update.category',$category_info->id )}}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Category Name Field -->
                    <div class="space-y-2">
                        <label for="category_name" class=" text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-tag text-emerald-500"></i>
                            Category Name
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="category_name"
                                   name="category_name" 
                                   value="{{ old('category_name', $category_info->category_name) }}"
                                   placeholder="Enter updated category name" 
                                   required
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 placeholder-gray-400 text-gray-800">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-pencil-alt text-gray-400"></i>
                            </div>
                        </div>
                        @error('category_name')
                        <p class="text-red-600 text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-gray-500 text-xs">Update the category name as needed</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-save"></i>
                            Update Category
                        </button>
                        
                        <button type="button" 
                                onclick="window.location.href='{{ route('category.manage') }}'"
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
                    <p class="text-gray-600 font-medium">Category ID</p>
                    <p class="text-gray-800 font-semibold">{{ $category_info->id }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-600 font-medium">Original Name</p>
                    <p class="text-gray-800 font-semibold">"{{ $category_info->category_name }}"</p>
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
        // Store original value for reset functionality
        const originalValue = "{{ $category_info->category_name }}";
        
        // Auto-focus on the input field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('category_name');
            input.focus();
            // Select all text for easy editing
            input.select();
        });

        // Reset form function
        function resetForm() {
            const input = document.getElementById('category_name');
            input.value = originalValue;
            input.focus();
            input.select();
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const categoryName = document.getElementById('category_name').value.trim();
            
            if (!categoryName) {
                e.preventDefault();
                alert('Please enter a category name');
                document.getElementById('category_name').focus();
                return false;
            }
            
            if (categoryName.length < 2) {
                e.preventDefault();
                alert('Category name must be at least 2 characters long');
                document.getElementById('category_name').focus();
                return false;
            }
            
            // Check if value actually changed
            if (categoryName === originalValue) {
                const proceed = confirm('No changes detected. Do you still want to update?');
                if (!proceed) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Real-time validation feedback
        document.getElementById('category_name').addEventListener('input', function() {
            const value = this.value.trim();
            const submitBtn = document.querySelector('button[type="submit"]');
            const resetBtn = document.querySelector('button[onclick="resetForm()"]');
            
            if (value.length >= 2) {
                this.classList.remove('border-red-300');
                this.classList.add('border-emerald-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                this.classList.remove('border-emerald-300');
                if (value.length > 0) {
                    this.classList.add('border-red-300');
                }
            }
            
            // Enable/disable reset button based on changes
            if (value !== originalValue) {
                resetBtn.classList.remove('opacity-50');
                resetBtn.disabled = false;
            } else {
                resetBtn.classList.add('opacity-50');
                resetBtn.disabled = true;
            }
        });

        // Initialize reset button state
        document.addEventListener('DOMContentLoaded', function() {
            const resetBtn = document.querySelector('button[onclick="resetForm()"]');
            resetBtn.classList.add('opacity-50');
            resetBtn.disabled = true;
        });
    </script>
</body>
</html>