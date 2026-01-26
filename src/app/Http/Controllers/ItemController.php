<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreitemCommentRequest;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
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

    public function storeComment(StoreitemCommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        Comment::create([
            'item_id' => $item->id,
            'user_id' => $Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('items.show', $item->id);
    }
}
