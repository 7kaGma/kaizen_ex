<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //Add
use App\Http\Controllers\BookController; //Add
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\KaizenProposalController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;

//mypageの表示
Route::get('/mypage', [MypageController::class, 'create'])->name('mypage');
//mypageから詳細へ
Route::get('/mypageDetail/{idKP}', [KaizenProposalController::class, 'mypageDetail'])->name('mypageDetail');

//ダッシュボードから承認作業詳細へ
Route::get('/approvalDetail/{idKP}', [KaizenProposalController::class, 'approvalDetail'])->name('approvalDetail');
//承認作業詳細からの更新用
Route::post('/approvalDetail/{idKP}', [KaizenProposalController::class, 'judgeUpdate'])->name('approvalDetail.submit');

//mypage詳細からの更新用
// Route::post('/mypageDetail/{idKP}', [KaizenProposalController::class, 'update'])->name('mypageDetail.submit');
// routes/web.php
Route::post('/mypageDetail/{idKP}', [KaizenProposalController::class, 'update'])->name('mypageDetail.submit');

// 過去一覧用
Route::get('/list', [KaizenProposalController::class, 'index'])->name('proposal.list');
// Route::get('/list', [KaizenProposalController::class, 'index'])->name('proposal.index');
Route::get('/proposalDetail/{idKP}', [KaizenProposalController::class, 'detail'])->name('proposal.detail');

// 
Route::post('post', [KaizenProposalController::class, 'store'])->name('post.store');
Route::post('/kaizen-proposals', [KaizenProposalController::class, 'store'])->name('kaizenProposals.store');

// Gemini:追加
Route::get('/create', [GeminiController::class, 'index'])->name('index');
Route::post('/create', [GeminiController::class, 'entry'])->name('entry');

//本：ダッシュボード表示(books.blade.php)
Route::get('/', [BookController::class,'index'])->middleware(['auth'])->name('book_index');
Route::get('/dashboard', [BookController::class,'index'])->middleware(['auth'])->name('dashboard');

//本：追加 
Route::post('/books',[BookController::class,"store"])->name('book_store');

//本：削除 
Route::delete('/book/{book}', [BookController::class,"destroy"])->name('book_destroy');

//本：更新画面
Route::post('/booksedit/{book}',[BookController::class,"edit"])->name('book_edit'); //通常
Route::get('/booksedit/{book}', [BookController::class,"edit"])->name('edit');      //Validationエラーありの場合

//本：更新画面
Route::post('/books/update',[BookController::class,"update"])->name('book_update');

/**
* 「ログイン機能」インストールで追加されています 
*/
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// いいねボタン
Route::post('post', [LikeController::class, 'store'])->name('like.store');
Route::delete('delete/{like}', [LikeController::class, 'destroy'])->name('like.destroy');

require __DIR__.'/auth.php';