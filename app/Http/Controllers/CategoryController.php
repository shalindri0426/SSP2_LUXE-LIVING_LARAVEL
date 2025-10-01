<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class CategoryController extends Controller
{
    public function addcat(Request $request){
        $validate_data=$request->validate([
            'category_name'=>'unique:categories|max:100',
        ]);

       Category::create($validate_data);
       return redirect()->back()->with('success', 'Category Added Successfully!');
    }

    public function showcat($id){
        $category_info = Category::find($id);

        return view('admin.editcat',compact('category_info'));
    }

    public function updatecat(Request $request,$id){
        $category=Category::findOrFail($id);
        $validate_data=$request->validate([
            'category_name'=>'unique:categories|max:100',
        ]);

        $category->update($validate_data);

        return redirect()->back()->with('updated', 'Category Updated Successfully!');
    }

    public function deletecat($id){
        Category::findOrFail($id)->delete();

        return redirect()->back()->with('deleted','Category Deleted Successfully!');
    }

    //to get categories for the nav bar
    public function getcatnav(){
        $categories=Category::all();

        return view('user.partials.catnav',compact('categories'));
    }

    //toshow products by category
    public function showCategoryProducts($id){
        $category=Category::findOrFail($id);
        $products=Product::where('category_id',$id)
                            ->where('is_active',true)
                            ->orderBy('created_at','desc')
                            ->paginate(12);

        return view('user.catproduct',compact('category','products'));
    }
    
}
