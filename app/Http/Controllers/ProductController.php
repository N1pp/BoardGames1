<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id){
        $product = Product::where('id',$id)->first();
        return view('show', compact('product'));
    }
    public function getAll(){
        $products = Product::all()->sortByDesc('created_at');
        return view('products', compact('products'));
    }
}
