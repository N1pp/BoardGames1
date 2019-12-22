<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\NewsTags;
use App\Product;
use App\ProductTag;
use App\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('show', compact('product'));
    }

    public function get()
    {
        $products = Product::all()->sortByDesc('created_at');
        return view('products', compact('products'));
    }

    public function createShow()
    {
        return view('create');
    }

    public function create(CreateProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $str) {
                if (Tag::where('value', trim($str))->get()->first()) {
                    $pt = new ProductTag;
                    $pt->product_id = $product->id;
                    $pt->tag_id = Tag::where('value', trim($str))->get()->first()->id;
                    $pt->save();
                } else {
                    $tag = new Tag;
                    $tag->value = trim($str);
                    $tag->save();
                    $pt = new ProductTag;
                    $pt->product_id = $product->id;
                    $pt->tag_id = Tag::where('value', trim($str))->get()->first()->id;
                    $pt->save();
                }
            }
        }
        return redirect()->route('product', [$product->id]);
    }

    public function filter(Request $request)
    {
        $str = $request->name;
        $products = Product::query()->where('name', 'LIKE', "%{$str}%")->get();
        if ($request->price_top)
            $products = $products->where('price', '<', $request->price_top);
        if ($request->price_low)
            $products = $products->where('price', '>', $request->price_low);
        if ($request->tag !== 0) {
            $products = $products->filter(function ($item) use ($request) {
                $tags = $item->tags;
                foreach ($tags as $tag) {
                    if ($tag->value == $request->tag) {
                        return true;
                    }
                }
                return false;
            });
        }
        return view('products', compact($products));
    }

}
