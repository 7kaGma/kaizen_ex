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
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('approvalStage', 'like', '%' . $search . '%');
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // データを保存
        KaizenProposal::create([
            'title' => $request->input('title'),
            'currentSituation' => $request->input('currentSituation'),
            'proposal' => $request->input('proposal'),
            'benefit' => $request->input('benefit'),
            'budget' => $request->input('budget'),
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

    /**
     * Display the specified resource.
     */
    public function show(kaizenProposal $kaizenProposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kaizenProposal $kaizenProposal)
    {
        //
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
        // return redirect()->back()->with('success', '提案書が更新されました！');
        
    }

    /**
     * Update the specified resource in storage.
     */
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


    // 書き方２種類目
    // public function update(Request $request, $idKP)
    // {
    //     $request->validate([
    //         'currentSituation' => 'required|string',
    //         'proposal' => 'required|string',
    //         'benefit' => 'required|string',
    //         'budget' => 'required|string',
    //     ]);

    //     $kaizenProposal = kaizenProposal::find($idKP);
    //     $kaizenProposal->currentSituation = $request->currentSituation;
    //     $kaizenProposal->proposal = $request->proposal;
    //     $kaizenProposal->benefit = $request->benefit;
    //     $kaizenProposal->budget = $request->budget;
    //     $kaizenProposal->save();

    //     return redirect()->back()->with('success', '提案書が更新されました！');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kaizenProposal $kaizenProposal)
    {
        //
    }
}
