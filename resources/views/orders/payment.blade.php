<x-app-layout>
    @include('user.partials.catnav')

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Payment</h1>
                        <p class="text-gray-600 mt-2">Order ID: {{ $order->order_id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600">Rs. {{ number_format($order->total_amount, 2) }}</p>
                        <p class="text-sm text-gray-600">Total Amount</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Payment Form -->
                <div class="lg:col-span-7">
                    <form method="POST" action="{{ route('payments.store', $order) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Payment Method Selection -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Select Payment Method</h2>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                                    <label for="bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                        Bank Transfer
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="online_transfer" id="online_transfer" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="online_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                        Online Payment (Card)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Details -->
                        <div id="bank_transfer_details" class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Bank Transfer Details</h2>
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h3 class="font-semibold text-gray-800 mb-2">Transfer to:</h3>
                                <p class="text-sm text-gray-700">Bank: Commercial Bank</p>
                                <p class="text-sm text-gray-700">Account Name: Furniture Store Ltd</p>
                                <p class="text-sm text-gray-700">Account Number: 1234567890</p>
                                <p class="text-sm text-gray-700">Branch: Colombo Main</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Payment Receipt (PDF) *</label>
                                <input type="file" name="receipt_pdf" accept=".pdf" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Please upload your bank transfer receipt as PDF</p>
                            </div>
                        </div>

                        <!-- Online Payment Details -->
                        <div id="online_transfer_details" class="bg-white rounded-lg shadow-md p-6 hidden">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Card Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Holder Name *</label>
                                    <input type="text" name="card_holder_name" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Number *</label>
                                    <input type="text" name="card_number" maxlength="16" placeholder="1234567890123456"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date *</label>
                                        <input type="text" name="exp_date" placeholder="MM/YY" maxlength="5"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV *</label>
                                        <input type="text" name="cvv" maxlength="3" placeholder="123"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>
                            Confirm Payment
                        </button>
                    </form>
                </div>

                <!-- Order Details -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Details</h2>
                        
                        <!-- Order Info -->
                        <div class="mb-6 pb-4 border-b">
                            <p class="text-sm text-gray-600">Order ID</p>
                            <p class="font-semibold text-gray-900">{{ $order->order_id }}</p>
                            <p class="text-sm text-gray-600 mt-2">Order Date</p>
                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>

                        <!-- Delivery Info -->
                        <div class="mb-6 pb-4 border-b">
                            <h3 class="font-semibold text-gray-900 mb-2">Delivery Information</h3>
                            <p class="text-sm text-gray-600">{{ $order->delivery_name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->delivery_phone }}</p>
                            <p class="text-sm text-gray-600">{{ $order->delivery_address }}</p>
                        </div>

                        <!-- Products -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Items Ordered</h3>
                            <div class="space-y-3">
                                @foreach($order->products as $product)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $product['product_name'] }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $product['quantity'] }} × Rs. {{ number_format($product['price'], 2) }}</p>
                                        </div>
                                        <p class="text-sm font-medium">Rs. {{ number_format($product['total'], 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Amount</span>
                                <span class="text-blue-600">Rs. {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankTransfer = document.getElementById('bank_transfer');
            const onlineTransfer = document.getElementById('online_transfer');
            const bankDetails = document.getElementById('bank_transfer_details');
            const onlineDetails = document.getElementById('online_transfer_details');

            function togglePaymentMethod() {
                if (bankTransfer.checked) {
                    bankDetails.classList.remove('hidden');
                    onlineDetails.classList.add('hidden');
                } else {
                    bankDetails.classList.add('hidden');
                    onlineDetails.classList.remove('hidden');
                }
            }

            bankTransfer.addEventListener('change', togglePaymentMethod);
            onlineTransfer.addEventListener('change', togglePaymentMethod);

            // Format card number input
            const cardNumberInput = document.querySelector('input[name="card_number"]');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }

            // Format expiry date input
            const expDateInput = document.querySelector('input[name="exp_date"]');
            if (expDateInput) {
                expDateInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // Format CVV input
            const cvvInput = document.querySelector('input[name="cvv"]');
            if (cvvInput) {
                cvvInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }
        });
    </script>
</x-app-layout>