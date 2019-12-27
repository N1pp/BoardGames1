<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use App\ProductSales;
use App\User;
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

    public function giveAdminForm(Request $request)
    {
        $users = User::all()->sortByDesc('role');

        return view('giveAdmin', compact('users'));
    }

    public function filterUsers(Request $request)
    {
        $str = $request->name;
        $users = User::query()->where('name', 'LIKE', "%{$str}%")->get()->sortByDesc('role');

        return view('giveAdmin', compact('users'));
    }

    public function giveAdmin(Request $request)
    {
        $user = User::find($request->id);
        $user->role = 'admin';
        $user->save();
        return redirect()->back();
    }

    public function removeAdmin(Request $request)
    {
        $user = User::find($request->id);
        $user->role = 'user';
        $user->save();

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
        return view('statistics.product', compact(['maxSalesProduct', 'maxSales', 'maxRated', 'totalSales']));
    }

}
