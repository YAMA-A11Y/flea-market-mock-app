<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemCommentRequest;
use App\Http\Requests\PurchaseStoreRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab' , 'recommend');

        $likedItemIds = [];
        if (Auth::check()) {
            $likedItemIds = Auth::user()->likes()->pluck('item_id')->all();
        }

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
            } else {
                $query = Item::query()
                ->whereHas('likes', function ($q) {
                    $q->where('user_id', Auth::id());
                });

                if ($request->filled('keyword')) {
                    $query->where('name', 'like', '%' . $request->keyword . '%');
                }

                $items = $query->latest()->get();
            }

        } else {
            $query = Item::query()->latest();

            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }

            if ($request->filled('keyword')) {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }

            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab', 'likedItemIds'));
    }

    public function show($item_id)
    {
        $item = Item::with('categories')->findOrFail($item_id);

        $likeCount = $item->likes()->count();
        $commentCount = $item->comments()->count();

        $isLiked = Auth::check()
            ? $item->likes()->where('user_id', Auth::id())->exists()
            : false;
        
        $comments = $item->comments()->with('user')->latest()->get();

        return view('items.show', compact(
            'item',
            'likeCount',
            'commentCount',
            'isLiked',
            'comments'
        ));
    }

    public function toggleLike($item_id)
    {
        $item = Item::findOrFail($item_id);
        $userId = Auth::id();

        $like = Like::where('item_id', $item->id)
            ->where('user_id', $userId)
            ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'item_id' => $item->id,
                'user_id' => $userId,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $item->likes()->count(),
        ]);
    }

    public function storeComment(StoreItemCommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('items.show', $item->id);
    }

    public function purchase($item_id)
    {
        $item = Item::with('categories')->findOrFail($item_id);

        if ($item->sold) {
            return redirect()->route('items.index');
        }

        return view('items.purchase', compact('item'));
    }

    public function purchaseStore(PurchaseStoreRequest $request, $item_id)
    {
        DB::transaction(function () use ($item_id) {
            $item = Item::where('id', $item_id)->lockForUpdate()->firstOrFail();

            if ($item->is_sold) {
                abort(409, 'Sold out');
            }

           $item->update(['is_sold' => true]);
        });

        return redirect()->route('items.index');
    }
}
