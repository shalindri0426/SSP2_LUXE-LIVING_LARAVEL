<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check()) {
            $this->count = Cart::getCartCount(Auth::id());
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}