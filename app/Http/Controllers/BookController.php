<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //この2行を追加！
use Illuminate\Support\Facades\Auth;      //この2行を追加！
use App\Models\kaizenProposal;
use App\Models\User;
// 下記は何ヶ月以内などの時に使用
use Carbon\Carbon;



class BookController extends Controller
{

    // DashBoardのグラフ表示のためのData取得に関する処理？
    public function index(Request $request)
    {
        $posts = kaizenProposal::orderBy('idKP', 'desc')->take(5)->get();
        // miniMypage用
        $mines = kaizenProposal::where('user_id', Auth::id())->orderBy('idKP', 'desc')->limit(5)->get();
        // approvalPage用
        $currentUserDepartment = Auth::user()->department;
        // 検索条件に合致する提案書を取得
        $approvals = kaizenProposal::where('department', $currentUserDepartment);
        if ($request->filled('searchWord')) {
            $searchWord = $request->input('searchWord');

            $keywords = preg_split('/[ \x{3000}]+/u', $searchWord, -1, PREG_SPLIT_NO_EMPTY);

            $approvals->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->where(function ($subQuery) use ($keyword) {
                        $subQuery->where('title', 'like', "%{$keyword}%")
                            ->orWhere('name', 'like', "%{$keyword}%");
                    });
                }
            });
        }
        $approvals = $approvals
                                    ->where(function ($query) {
                                        $query->where('approvalStage', '検討中')
                                              ->orWhere('approvalStage', '再提出');
                                    })
                                    ->orderBy('idKP', 'desc')
                                    ->paginate(5);
        // Chart.js 用のデータを整形
        $chartData = $posts->map(function ($post) {
            return [
                'id' => $post->idKP,
                'name' => $post->name,
                'title' => $post->title, // titleフィールドが存在する場合
                'date' => $post->created_at->format('Y-m-d'), // created_atフィールドが存在する場合
            ];
        });
        //下記で今から３ヶ月前(sub)の日時を$threeMonthsAgoに与えている
        // 一週間後(add)の時は、$nextWeek = Carbon::now()->addWeek(); 
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        $goodCounts = kaizenProposal::where('updated_at', '>=', $threeMonthsAgo)
                                    ->orderBy('goodCounts', 'desc')
                                    ->take(5)->get();
    

        // 個別提案書グラフ用のデータ取得
        $array =[];
        $UserAll= User::pluck('id'); 
       
        $startOfmonth = Carbon::now()->startOfmonth();
        $endOfmonth = Carbon::now()->endOfmonth();
        foreach ($UserAll as $value){
             $postCount = KaizenProposal::whereBetween('updated_at', [$startOfmonth, $endOfmonth])->where('user_id', $value)->count();
             $userdata = User::where('id', $value)->first();
             $userdata['postCount']=$postCount;
             array_push($array,$userdata);
        }
        usort($array, function ($a, $b) {
            return $b['postCount'] <=> $a['postCount'];
        });

        if(count($array)<5){
            $mvp=$array;
            while(count($mvp)<5){
                $addData=['name'=>"",'postCount'=>0];
                 array_push($mvp,$addData);
            }

        }elseif(count($array)==5){
            $mvp=$array;
        }else {
            $mvp=array_slice($array,0,5);
        }

        // 各部署の提案件数を集計
        $departments = ['生産技術部', '研究開発部', '経理部', '営業部'];
        $dpt = [];

        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();
        foreach ($departments as $department) {
            $count = KaizenProposal::whereBetween('updated_at', [$startOfYear, $endOfYear])->where('department', $department)->count();
            $dpt[] = [
                'name' => $department,
                'proposalCount' => $count
            ];
        }
        return view('books', compact('posts','mines','approvals','goodCounts','mvp','dpt'))->with('chartData', $chartData);
      //         return view('books',compact('mines','approvals'));
    }
}
