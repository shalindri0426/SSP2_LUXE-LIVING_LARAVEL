<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20  rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="logo">
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">LUXE - LIVING</h2>
                    <p class="text-sm text-amber-700">Admin Dashboard</p>
                </div>
            </div>
           
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100">
                            <svg class="w-8 h-8 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalProducts ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100">
                            <svg class="w-8 h-8 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Categories</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCategories ?? '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-amber-50">
                    <nav class="flex space-x-8 px-8 py-4" id="tab-nav">
                <ul class="list-none flex">
                    <li class="{{ request()->routeIs('product.manage') ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-amber-100 hover:text-amber-700' }} 
                            px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-200">
                        <a href="{{ route('product.manage') }}" class="flex items-center">
                            All Products
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('admin.order') ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-amber-100 hover:text-amber-700' }} 
                            px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-200">
                        <a href="{{ route('admin.order') }}" class="flex items-center">
                            All Orders
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('user.manage') ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-amber-100 hover:text-amber-700' }} 
                            px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-200">
                        <a href="{{ route('user.manage') }}" class="flex items-center">
                            All Users
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('category.manage') ? 'bg-amber-600 text-white' : 'text-gray-700 hover:bg-amber-100 hover:text-amber-700' }} 
                            px-6 py-3 text-sm font-semibold rounded-lg transition-all duration-200">
                        <a href="{{ route('category.manage') }}" class="flex items-center">
                            All Categories
                        </a>
                    </li>
                </ul>

                    </nav>
                </div>

                <!-- Tab Content Container -->
                <div class="p-8" id="tab-content-container">
                    <!-- Loading indicator -->
                    <div id="loading-indicator" class="hidden">
                        <div class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-amber-600"></div>
                            <span class="ml-3 text-gray-600">Loading...</span>
                        </div>
                    </div>
                    
                    <!-- Default content or active tab content will be loaded here -->
                    <div id="default-welcome" class="text-center py-12">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 bg-gradient-to-br from-amber-100 to-orange-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-12 h-12 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Welcome to LUXE-LIVING Admin</h3>
                            <p class="text-gray-600 mb-6">Select a tab above to manage products, orders, or customers.</p>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    <style>
        .tab-button.active {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }
        
        .tab-button:not(.active) {
            color: #6b7280;
            background: transparent;
        }
        
        .tab-button:not(.active):hover {
            background: rgba(217, 119, 6, 0.1);
            color: #d97706;
        }
    </style>

    <script>
        let currentActiveTab = null;

        // Function to load tab content via AJAX
        async function loadTabContent(url, buttonElement) {
            const container = document.getElementById('tab-content-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            const defaultWelcome = document.getElementById('default-welcome');
            
            // Update active tab button
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            buttonElement.classList.add('active');
            currentActiveTab = buttonElement;
            
            // Show loading indicator
            defaultWelcome.style.display = 'none';
            loadingIndicator.classList.remove('hidden');
            
            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    }
                });
                
                if (response.ok) {
                    const html = await response.text();
                    
                    // Hide loading indicator
                    loadingIndicator.classList.add('hidden');
                    
                    // Create a temporary container to parse the response
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Try to find the main content (you might need to adjust this selector based on your page structure)
                    let content = tempDiv.querySelector('.max-w-7xl') || tempDiv.querySelector('main') || tempDiv.querySelector('.container') || tempDiv;
                    
                    // If the response contains the full HTML structure, extract just the content
                    if (tempDiv.querySelector('x-app-layout')) {
                        content = tempDiv.querySelector('x-app-layout') || content;
                    }
                    
                    // Replace the container content
                    container.innerHTML = content.innerHTML;
                    
                    // Execute any scripts in the loaded content
                    const scripts = container.querySelectorAll('script');
                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        if (script.src) {
                            newScript.src = script.src;
                        } else {
                            newScript.textContent = script.textContent;
                        }
                        document.body.appendChild(newScript);
                        document.body.removeChild(newScript);
                    });
                    
                } else {
                    throw new Error('Failed to load content');
                }
            } catch (error) {
                console.error('Error loading tab content:', error);
                loadingIndicator.classList.add('hidden');
                container.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-red-600 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Error Loading Content</h3>
                        <p class="text-gray-600 mb-4">Unable to load the requested page. Please try again.</p>
                        <button onclick="loadTabContent('${url}', currentActiveTab)" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors">
                            Retry
                        </button>
                    </div>
                `;
            }
        }

        // Load initial content based on current route
        document.addEventListener('DOMContentLoaded', function() {
            const activeButton = document.querySelector('.tab-button.active');
            if (activeButton) {
                const route = activeButton.onclick.toString().match(/loadTabContent\('([^']+)'/);
                if (route) {
                    loadTabContent(route[1], activeButton);
                }
            }
        });
    </script>
</x-app-layout>