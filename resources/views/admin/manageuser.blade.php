 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage user</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <i class="fas fa-layer-group text-blue-600"></i>
                        MANAGE USER
                    </h1>
                    
                </div>
            </div>
        </div>

        <!-- User Table Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list text-gray-600"></i>
                    All Users
                </h3>
                <p class="text-gray-600 text-sm mt-1">Manage all Users</p>
            </div>
    
            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-900">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag"></i>
                                    ID
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tag"></i>
                                    User Name
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tag"></i>
                                    Email
                                </div>
                            </th>
                            <th class="px-8 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fas fa-cogs"></i>
                                    Created At
                                </div>
                            </th>
                            <th class="px-8 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fas fa-cogs"></i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    @if (session('deleted'))
                        <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between shadow-sm">
                            <p class="text-sm font-medium">
                                {{ session('deleted') }}
                            </p>
                            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                                
                            </button>
                        </div>
                    @endif

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-25' }}">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-700">{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->created_at }}</div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-3">
                                         <form action="{{route('delete.user',$user->id )}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                           <input 
                                           type="submit" 
                                           value="Delete" 
                                           class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white text-xs font-semibold rounded-lg hover:from-red-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-sm hover:shadow-md">
                                           {{-- onclick="return confirm('Are you sure you want to delete this user?')" --}}
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Empty State -->
                @if(count($users) == 0)
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-folder-open text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Users Found</h3>
                    
                </div>
                @endif
            </div>
        </div>

        <!-- Stats Footer -->
        <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800">{{ count($users) }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Last updated: {{ now()->format('M d, Y') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>