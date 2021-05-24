<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request){
        
        $rules = [
            'product_name'  => 'required',
            'size'          => 'required|numeric',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
        ];

        $validate = Validator::make($request->all(), $rules);
        
        if($validate->fails()){
            return response()->json([
                'status'    => 'error',
                'message'   => 'Invalid request',
                'errors'    => $validate->errors(),
            ], 400);
        }
        $product = new Product();
        $product->product_name  = $request->product_name;
        $product->size          = $request->size;
        $product->price         = $request->price;
        $product->quantity      = $request->quantity;
        $product->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Product has been stored',
        ], 200);
    }

    public function View(){

        $product = Product::orderBy('product_name')
        ->get();

        return response()->json($product);
    }
}
