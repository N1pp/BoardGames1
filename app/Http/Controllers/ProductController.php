<?php

namespace App\Http\Controllers;

use App\Favourites;
use App\Http\Requests\CreateProductRequest;
use App\NewsTags;
use App\Notifications\NewProductsNotification;
use App\Product;
use App\ProductTag;
use App\Tag;
use App\User;
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

    public function editShow(Request $request)
    {
        $product = Product::find($request->id);
        return view('editProduct', compact('product'));
    }

    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        if ($product->name != $request->name)
            $product->update(['name' => $request->name]);
        if ($product->description != $request->description)
            $product->update(['description' => $request->description]);
        if ($product->description != $request->descriptionSmall)
            $product->update(['descriptionSmall' => $request->descriptionSmall]);
        if ($product->price != $request->price)
            $product->update(['price' => $request->price]);
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $str) {
                if (Tag::where('value', trim($str))->get()->first()) {
                    $tag = Tag::where('value', trim($str))->get()->first();
                    if (!$product->tags->contains($tag)) {
                        $pt = new ProductTag;
                        $pt->product_id = $product->id;
                        $pt->tag_id = $tag->id;
                        $pt->save();
                    }
                } else {
                    $tag = new Tag;
                    $tag->value = trim($str);
                    $tag->save();
                    if (!$product->tags->contains($tag)) {
                        $pt = new ProductTag;
                        $pt->product_id = $product->id;
                        $pt->tag_id = $tag->id;
                        $pt->save();
                    }
                }
            }
        }
        return redirect()->route('admin');
    }

    public function create(CreateProductRequest $request)
    {
        $path = $request->file('img')->store('uploads', 'public');
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->descriptionSmall = $request->descriptionSmall;
        $product->price = $request->price;
        $product->img = $path;
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

    public function add(Request $request)
    {
        $product = Product::find($request->id);
        $product->amount = $product->amount + $request->amount;
        $product->save();
        foreach (Favourites::where('product_id', $request->id) as $fav) {
            User::find($fav->user_id)->notify(new NewProductsNotification($product));
        }
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        Product::find($request->id)->delete();
        return redirect()->back();
    }

    public function filter(Request $request)
    {
        $str = $request->name;
        $products = Product::query()->where('name', 'LIKE', "%{$str}%")->get()->sortByDesc('rate');
        if ($request->price_top)
            $products = $products->where('price', '<', $request->price_top);
        if ($request->price_low)
            $products = $products->where('price', '>', $request->price_low);
        if ($request->tag) {
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
        return view('products', compact('products'));
    }
}
