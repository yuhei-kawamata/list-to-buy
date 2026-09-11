<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Topページ(/)にアクセスしたときに、/itemsにリダイレクトさせるための設定
// デプロイした際のアクセス先が'/'であり、直接'/items'にはアクセスできない
Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::patch('/items/{id}/complete', [ItemController::class, 'complete'])->name('items.complete');
    Route::delete('/items/{id}/delete', [ItemController::class, 'destroy'])->name('items.destroy');

    Route::get('/items/purchase_history', [ItemController::class, 'purchaseHistoryShow'])->name('items.purchaseHistoryShow');
    Route::get('/items/purchase_history/search', [ItemController::class, 'search'])->name('items.search');
    Route::patch('/items/purchase_history/{id}/repurchase', [ItemController::class, 'repurchase'])->name('items.repurchase');

});
