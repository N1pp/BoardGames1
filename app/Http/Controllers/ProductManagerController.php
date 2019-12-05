<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
//        dd($request);
        if (Rate::where('user_id', Auth::id())->where('product_id', $request->product_id)->get()) {
            Log::info('Я');
            if (!Rate::where('user_id', Auth::id())->where('product_id', $request->product_id)->where('value', $request->value)->get()) {
                Log::info("Я ТУТ БЫЛ НО ИЗМЕЛСЯ");
                $rate = Rate::where('user_id', Auth::id())->where('product_id', $request->product_id)->get();
                $rate->value = $request->value;
                $rate->save();
            }
//        } else {
//            Log::info("Я РОДИЛСЯ");
//            $rate = new Rate();
//            $rate->user_id = Auth::id();
//            $rate->product_id = $request->product_id;
//            $rate->value = $request->value;
//            $rate->save();
//            $product = Product::find($rate->product_id);
//            $product->update(['rate', Rate::where('product_id',$product->id)->sum()]);
        }
        return redirect()->back();

    }
}
