<button wire:click="addToCart" 
        wire:loading.attr="disabled"
        class="flex-1 bg-orange-500 text-white py-2 px-3 rounded-lg font-medium hover:bg-orange-600 transition-all duration-300 text-sm flex items-center justify-center transform hover:scale-105 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
    <i class="fas fa-shopping-cart mr-1" wire:loading.remove wire:target="addToCart"></i>
    <i class="fas fa-spinner fa-spin mr-1" wire:loading wire:target="addToCart"></i>
    <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
    <span wire:loading wire:target="addToCart">Adding...</span>
</button>