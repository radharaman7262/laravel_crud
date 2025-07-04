<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\support\Facades\Validator;

class ProductController extends Controller
{   

    
    //This method will show products page
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->get();

        return view('products.list', [
            'products' => $products
        ]);
    }
    //This method will show create product page
    public function create(){
     return view('products.create');
    }

    //This method will store a product in db
    public function store(Request $request){
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric'
        ];
        if ($request ->image != ""){
            $rules['image']='image';
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
        // return view('products.create');
        {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        
        //here we will insert product in db
        $product = new Product();
        $product -> name = $request->name;
        $product -> sku = $request->sku;
        $product -> price = $request->price;
        $product ->description = $request->description;
        $product->save();
        
        if ($request->image != ""){
            
        // here we will store image
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext; //unique iamge name

        //save iamge to products directory
        $image -> move(public_path('uploads/products'),$imageName);
        
        //save iamge name in database
        $product ->image = $imageName;
        $product->save();

        }
        
        return redirect()->route('products.index')->with('success','Product added successfully');
    }
    //This method will show edit product page
    public function edit($id){
         $product = Product::findOrFail($id);
         return view('products.edit',[
            'product' => $product
         ]);
    }

    //This method will update a product
    public function update($id, Request $request){
        $product = Product::findOrFail($id);
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric'
        ];
        if ($request ->image != ""){
            $rules['image']='image';
        }

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
        // return view('products.create');
        {
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }
        
        //here we will update product
        $product -> name = $request->name;
        $product -> sku = $request->sku;
        $product -> price = $request->price;
        $product ->description = $request->description;
        $product->save();
        
        if ($request->image != ""){
        //delete old images
        File::delete(public_path('uploads/products/'.$product->image));

        // here we will store image
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext; //unique iamge name

        //save iamge to products directory
        $image -> move(public_path('uploads/products'),$imageName);
        
        //save iamge name in database
        $product ->image = $imageName;
        $product->save();

        }
        
        
        return redirect()->route('products.index')->with('success','Product updated successfully');
    } 

    //This method will delte a product
    public function destroy($id){
      $product = Product::findOrFail($id);
      //deletd image
      File::delete(public_path('uploads/products/'.$product->image));
      //delete product from database
      $product->delete();
      return redirect()->route('products.index')->with('success','product deleted successfully');
    }
}   
