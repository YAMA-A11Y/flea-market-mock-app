<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $items = collect();
        $orders = collect();

        if ($page === 'sell') {
            $items = Item::query()
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        if ($page === 'buy') {
            $orders = Order::query()
                ->where('user_id', $user->id)
                ->with('item')
                ->latest()
                ->get();
        }

        return view('mypage.index', compact('user', 'items', 'orders', 'page'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }    
}
