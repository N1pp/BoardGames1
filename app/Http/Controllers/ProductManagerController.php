<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Favourites;
use App\Notifications\PaymentNotification;
use App\Product;
use App\Rate;
use App\Sale;
use App\User;
use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductManagerController extends Controller
{
    public function createComment(Request $request)
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
        // TODO Добавить возможность покупать много товаров
        $product = Product::find($request->product_id);
        $count = $product->amount;
        $product->amount = $count - 1;
        $product->save();
        $sale = new Sale();
        $sale->user_id = Auth::id();
        $sale->product_id = $product->id;
        $sale->price = $product->price;
        $sale->save();
        User::find(Auth::id())->notify(new PaymentNotification($product));
        return redirect()->back();
    }
}
