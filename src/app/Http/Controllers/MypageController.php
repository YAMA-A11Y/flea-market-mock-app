<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        if ($page === 'sell') {
            $items = Item::query()
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $items = collect();
        }

        return view('mypage.index', compact('user', 'items', 'page'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }    
}
