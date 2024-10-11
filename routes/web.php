<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //Add
use App\Http\Controllers\BookController; //Add
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\KaizenProposalController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;

/*==========
MypageController
==========*/
Route::get('/mypage', [MypageController::class, 'create'])->name('mypage');//mypageのindex


/*==========
KaizenProposalController ※要整理
==========*/
//下記Routingに関する処理[mypageDetail,approvalDetail,list,proposalDetail]
Route::get('/mypageDetail/{idKP}', [KaizenProposalController::class, 'mypageDetail'])->name('mypageDetail');
Route::get('/approvalDetail/{idKP}', [KaizenProposalController::class, 'approvalDetail'])->name('approvalDetail');
Route::get('/list', [KaizenProposalController::class, 'index'])->name('proposal.list');
Route::get('/proposalDetail/{idKP}', [KaizenProposalController::class, 'detail'])->name('proposal.detail');
//approvalDetailの更新
Route::post('/approvalDetail/{idKP}', [KaizenProposalController::class, 'judgeUpdate'])->name('approvalDetail.submit');
//mypageDetailの更新
Route::post('/mypageDetail/{idKP}', [KaizenProposalController::class, 'update'])->name('mypageDetail.submit');
// 
Route::post('post', [KaizenProposalController::class, 'store'])->name('post.store');
Route::post('/kaizen-proposals', [KaizenProposalController::class, 'store'])->name('kaizenProposals.store');


/*==========
GeminiController
==========*/
Route::get('/create', [GeminiController::class, 'index'])->name('index');
Route::post('/create', [GeminiController::class, 'entry'])->name('entry');


/*==========
BookController※要整理
==========*/
Route::get('/', [BookController::class,'index'])->middleware(['auth'])->name('book_index');
Route::get('/dashboard', [BookController::class,'index'])->middleware(['auth'])->name('dashboard');


/*==========
ProfilrController
==========*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*=========
LikeController
==========*/
Route::post('post', [LikeController::class, 'store'])->name('like.store');
Route::delete('delete/{like}', [LikeController::class, 'destroy'])->name('like.destroy');

require __DIR__.'/auth.php';