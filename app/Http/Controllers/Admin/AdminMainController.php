<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class AdminMainController extends Controller
{
    public function index(){
        $totalUsers = User::where('role',1)->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        return view('admin.admin',compact('totalUsers','totalProducts','totalCategories','totalOrders'));
    }

    // public function order(){
    //     return view('admin.orders');
    // }

    public function cart(){
        return view('admin.cart');
    }

    public function ccindex(){
        return view('admin.createcategory');
    }

    public function cmanage(){
        $categories=Category::all();
        return view('admin.managecategory',compact('categories'));
    }

    public function pcindex(){
        $categories=Category::all();
        return view('admin.createproduct',compact('categories'));
    }

    public function pmanage(){
        $categories = Category::all();
        $products=Product::all(); 
        return view('admin.manageproduct',compact('products'));
    }

    public function umanage(){
        $users=User::all();
        return view('admin.manageuser',compact('users'));
    }
}
