{{-- <!-- resources/views/livewire/test-component.blade.php -->
<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Livewire Test</h2>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="mb-4">
        <p class="text-lg">Count: <span class="font-bold text-blue-600">{{ $count }}</span></p>
    </div>
    
    <button 
        wire:click="increment" 
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>Increment</span>
        <span wire:loading>Loading...</span>
    </button>
</div> --}}