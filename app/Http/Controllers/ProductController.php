<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class ProductController extends Controller
{
    public function index(){
        // Fix the pagination logic
        $products = Product::orderBy('created_at', 'desc')->paginate(12);
        return view('user.user', compact('products'));
    }

    public function show(Product $product){
        // Fix: Pass the single product, not all products
        return view('user.show', compact('product'));
    }

    // public function addToCart(Request $request,Product $product){
    //     //add to cart logic here

    //     //success msg
    //     return response()->json([
    //         'success'=>true,
    //         'message'=>'Product added to cart successfully!'
    //     ]);
    // }

    public function buyNow(){
        //rdirect to order confirmation page
        return redirect90->route('checkout',['product'=>$product->id]);
    }


    //from the admin dashboard
    public function addproduct(Request $request){
        $validate_data=$request->validate([
            'product_name'=>'unique:products|max:50',
            'image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
            'description'=>'max:300|min:30',
            'category_id'=> 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'material' => 'nullable|string|max:100',    
            'colour' => 'nullable|string|max:50',       
            'stock' => 'required|integer|min:0',
            'is_active'=>'boolean'

        ]);

        // Set default values if not provided
        $validate_data['discount'] = $validate_data['discount'] ?? 0;
        $validate_data['is_active'] = $validate_data['is_active'] ?? true;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validate_data['image'] = $imageName;
        }

        Product::create($validate_data);
        $categories = Category::all();
        return redirect()->back()->with('added','Product Added Successfully!');
    }

    public function showproduct($id){
        $product_info=Product::find($id);
        $categories = Category::all();

        return view('admin.editproduct',compact('product_info','categories'));
    }

    public function updateproduct(Request $request, $id){
        $product=Product::findOrFail($id);
        $categories = Category::all();
        $validate_data=$request->validate([
            'product_name'=>'required|max:50|unique:products,product_name,'.$id,
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'=>'max:300|min:50',
            'category_id'=> 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'material' => 'nullable|string|max:100',    
            'colour' => 'nullable|string|max:50',       
            'stock' => 'required|integer|min:0',

        ]);

        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            
            // Delete old image if it exists
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validate_data['image'] = $imageName;
        }else{
            // Keep the existing image if no new image is uploaded
            unset($validate_data['image']); // Remove image from update data
        }

        $product->update($validate_data);

        return redirect()->back()->with('updated','Product Updated Successfully!');
    }

    public function deleteproduct($id){
        try{
            $product=Product::findOrFail($id)->delete();

            // Store image path before deletion
            $imagePath = $product->image;

            $product->delete();

            // Delete associated image file
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
       
        return redirect()->back()->with('deleted','Product Deleted Successfully!');
        }
        catch(\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}