<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use App\ProductSales;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin', compact('products'));
    }

    public function showComments()
    {
        $comments = Comment::all();
        return view('comments', compact('comments'));
    }

    public function deleteComment(Request $request)
    {
        $comments = Comment::find($request->id);
        $comments->delete();
        return redirect()->back();
    }

    public function showProductStatistics()
    {
        $product = Product::all();
        $maxSales = 0;
        $maxSalesId = null;
        foreach ($product as $item) {
            if ($maxSales < ProductSales::where('product_id', $item->id)->get()->filter(function ($item) {
                    return $item->created_at->addMonth() > now();
                })->count()) {
                $maxSales = ProductSales::where('product_id', $item->id)->count();
                $maxSalesId = $item->id;
            }
        }
        $maxSalesProduct = Product::find($maxSalesId);
        $maxRated = Product::all()->sortByDesc('rate')->take(10);
        $totalSales = ProductSales::all()->filter(function ($item) {
            return $item->created_at->addMonth() > now();
        })->count();
        return view('statistics.product',compact(['maxSalesProduct','maxSales','maxRated','totalSales']));
    }

}
