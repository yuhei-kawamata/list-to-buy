<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('user')
            ->where('complete_flag', 0)
            ->orderBy('hurry_flag', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('items.index', compact('items'));
    }

    public function store(ItemRequest $request)
    {
        Item::create($request->validated());

        return redirect()->route('items.index')->with('success', '登録しました');
    }

    public function complete(string $id)
    {
        $item = Item::findOrFail($id);

        $item->complete_flag = 1;
        $item->save();

        return redirect()->route('items.index')->with('success', '買い物完了！');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', '削除しました');
    }

    public function purchaseHistoryShow()
    {
        $items = Item::with('user')
            ->where('complete_flag', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('items.purchaseHistory', compact('items'));
    }

    public function search(Request $request)
    {
        $keywordName = $request->input('keyword_name');
        $keywordStoreName = $request->input('keyword_store_name');

        $items = Item::query()
            ->when($keywordName, function ($query, $keywordName) {
                return $query->where('name', 'like', "%{$keywordName}%");
            })
            ->when($keywordStoreName, function ($query, $keywordStoreName) {
                return $query->where('store_name', 'like', "%{$keywordStoreName}%");
            })
            ->where('complete_flag', 1) // 記載しない場合、complete_flagが0のものも検索されてしまう
            ->paginate(5)
            ->appends($request->all()); // ページネーションをした際にも検索条件を保持できるようにする

        return view('items.purchaseHistory', compact('items', 'keywordName', 'keywordStoreName'));
    }

    public function repurchase(string $id)
    {
        $item = Item::findOrFail($id);

        Item::create([
            'name' => $item->name,
            'store_name' => $item->store_name,
            'quantity' => 1,
            'user_id' => Auth::id(),
            'hurry_flag' => 0,
            'complete_flag' => 0,
        ]);

        return redirect()->route('items.purchaseHistoryShow')->with('success', '買い物リストに登録しました！');
    }
}
