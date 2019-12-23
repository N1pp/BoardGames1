<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Favourites;
use App\Http\Requests\CommentRequest;
use App\Notifications\PaymentNotification;
use App\Product;
use App\ProductSales;
use App\Rate;
use App\Sale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductManagerController extends Controller
{

    public function addToCart(Request $request)
    {
        $cart = [];
        if (session()->get('cart'))
            $cart = session()->get('cart');
        $cart[] = $request->product;
        session()->forget('cart');
        session()->put('cart', $cart);
        session()->save();
        return redirect()->back();
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart');
        $newCart = [];
        $f = 0;
        foreach ($cart as $product) {
            if ($product == $request->id && $f == 0) {
                $f = 1;
            } else {
                $newCart[] = $product;
            }
        }
        session()->forget('cart');
        session()->put('cart', $newCart);
        session()->save();
        return redirect()->back();
    }

    public function createComment(CommentRequest $request)
    {
        $com = new Comment();
        $com->value = $request->value;
        $com->user_id = Auth::id();
        $com->product_id = $request->product_id;
        $com->save();
        $product = Product::find($com->product_id);
        Product::find($com->product_id)->update(['comment' => Comment::where('product_id', $product->id)->count()]);
        return redirect()->route('product', [$com->product_id]);
    }

    public function createRate(Request $request)
    {
        if (!Rate::where('product_id', $request->product_id)->where('user_id', Auth::id())->get()->first()) {
            $rate = new Rate();
            $rate->user_id = Auth::id();
            $rate->value = $request->value;
            $rate->product_id = $request->product_id;
            $rate->save();
        } elseif (!Rate::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->where('value', $request->value)
            ->get()->first()) {
            $rate = Rate::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->get()->first();
            $rate->value = $request->value;
            $rate->save();
        }
        $product = Product::find($request->product_id);
        $product->rate = Rate::where('product_id', $request->product_id)->sum('value');
        $product->save();
        return redirect()->back();
    }

    public function manageFavourites(Request $request)
    {
        if ($request->value == -1) {
            Favourites::where('product_id', $request->product_id)->where('user_id', Auth::id())->first()->delete();
        } else {
            $fav = new Favourites();
            $fav->user_id = Auth::id();
            $fav->product_id = $request->product_id;
            $fav->save();
        }
        return redirect()->back();
    }

    public function buy(Request $request)
    {
        $toBuy = session()->get('cart');
        $product = [];
        foreach ($toBuy as $id)
            $product[$id] = null;
        foreach ($toBuy as $id)
            $product[$id]++;
        $sale = new Sale();
        $sale->user_id = Auth::id();
        $sale->save();
        $keys = collect($product)->keys()->toArray();
        $values = collect($product)->toArray();
        foreach ($keys as $key){
            $ps = new ProductSales();
            $ps->product_id = $key;
            $ps->sales_id = $sale->id;
            $ps->save();
        }
        foreach ($values as $value){
            $ps = ProductSales::all()->where('sales_id',$sale->id)->where('product_id',key($values))->first();
            $ps->amount = $value;
            $ps->save();
        }
        $price = 0;
        foreach(ProductSales::all()->where('sales_id',$sale->id) as $ps){
            $price+= $ps->amount * Product::find($ps->product_id)->price;
            $pr = Product::find($ps->product_id);
            $pr->amount = $pr->amount - $ps->amount;
            $pr->save();
        }
        $sale->price = $price;
        $sale->save();
        session()->forget('cart');
        session()->save();
        User::find(Auth::id())->notify(new PaymentNotification($sale));
        return redirect()->home();
    }
}
