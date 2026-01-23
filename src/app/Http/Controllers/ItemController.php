<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $query = Item::query()->latest();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        $items = $query->get();

        return view('items.index', compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view('items.show', compact('item'));
    }
}
