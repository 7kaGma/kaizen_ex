<?php

namespace App\Http\Controllers;

use App\Models\kaizenProposal;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KaizenProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 検索条件用にモディファイ
        $query = kaizenProposal::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $keywords = preg_split('/[ \x{3000}]+/u', $search, -1, PREG_SPLIT_NO_EMPTY);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->where(function ($subQuery) use ($keyword) {
                        $subQuery->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('name', 'like', '%' . $keyword . '%')
                            ->orWhere('approvalStage', 'like', '%' . $keyword . '%');
                    });
                }
            });
        }
        // 検索条件を加えた
        $posts = $query->orderBy('idKP', 'desc')->paginate(5)->withQueryString();
        // 下記は通常の検索用
        // $posts = kaizenProposal::orderBy('idKP','desc')->paginate(5);
        return view('list', compact('posts'));
        

        
    }

    public function detail($idKP)
    {   
        $like=Like::where('kp_id',$idKP)->where('user_id',auth()->id())->first();
        $post = kaizenProposal::where('idKP', $idKP)->firstOrFail();
        $post->currentSituation = Str::markdown($post->currentSituation);
        $post->proposal = Str::markdown($post->proposal);
        $post->benefit = Str::markdown($post->benefit);
        $post->budget = Str::markdown($post->budget);
        return view('proposalDetail', compact('post','like'));
    }

    public function mypageDetail($idKP)
    {
        $post = kaizenProposal::where('idKP', $idKP)->firstOrFail();
        // $post->currentSituation = Str::markdown($post->currentSituation);
        // $post->proposal = Str::markdown($post->proposal);
        // $post->benefit = Str::markdown($post->benefit);
        // $post->budget = Str::markdown($post->budget);
        return view('mypageDetail', compact('post'));
    }

    public function approvalDetail($idKP)
    {
        $post = kaizenProposal::where('idKP', $idKP)->firstOrFail();
        // $post->currentSituation = Str::markdown($post->currentSituation);
        // $post->proposal = Str::markdown($post->proposal);
        // $post->benefit = Str::markdown($post->benefit);
        // $post->budget = Str::markdown($post->budget);
        return view('approvalDetail', compact('post'));
    }


    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'currentSituation' => 'required|string',
            'proposal' => 'required|string',
            'benefit' => 'required|string',
            'budget' => 'required|string',
        ]);

        // タイトル、現状、提案、効果、予算の入力内容に対して、**が含まれていた場合、**を削除
        $cleanTitle = str_replace('**','',$request->input('title')); 
        $cleanCurrentSituation = str_replace('**','',$request->input('currentSituation'));
        $cleanProposal = str_replace('**','',$request->input('proposal'));
        $cleanBenefit = str_replace('**','',$request->input('benefit'));
        $cleanBudget = str_replace('**','',$request->input('budget'));

        // データを保存
        KaizenProposal::create([
            'title' => $cleanTitle,
            'currentSituation' => $cleanCurrentSituation,
            'proposal' => $cleanProposal,
            'benefit' => $cleanBenefit,
            'budget' => $cleanBudget,
            'user_id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'position' => Auth::user()->position,
            'department' => Auth::user()->department,
            'team' => Auth::user()->team,
            'approvalStage' => $request->input('appovalStage'),
            'bossComment' => '', // 空のコメント
            'goodCounts' => 0, // 初期値
        ]);
        return redirect()->back()->with('success', '提案書が作成されました！');
    }


    public function judgeUpdate(Request $request, kaizenProposal $kaizenProposal)
    {
        $request->validate([
            'bossComment' => 'required|string',
            'approvalStage' => 'required|string',
        ]);

        $kaizenProposal = kaizenProposal::find($request->idKP);
        $kaizenProposal->bossComment   = $request->bossComment;
        $kaizenProposal->approvalStage  = $request->approvalStage;
        
        $kaizenProposal->save();
        return redirect('/');
    }

  
    // 書き方１種類目
    public function update(Request $request, kaizenProposal $kaizenProposal)
    {
        $request->validate([
            'currentSituation' => 'required|string',
            'proposal' => 'required|string',
            'benefit' => 'required|string',
            'budget' => 'required|string',
        ]);

        $kaizenProposal = kaizenProposal::find($request->idKP);
        $kaizenProposal->currentSituation   = $request->currentSituation;
        $kaizenProposal->proposal = $request->proposal;
        $kaizenProposal->benefit = $request->benefit;
        $kaizenProposal->budget   = $request->budget;
        $kaizenProposal->approvalStage  = "再提出";
        
        $kaizenProposal->save();
        return redirect('/mypage');
        // return redirect()->back()->with('success', '提案書が更新されました！');
        
    }
}
