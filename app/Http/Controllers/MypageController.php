<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kaizenProposal;

class MypageController extends Controller
{
    public function create(Request $request)
    {
        $query = kaizenProposal::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $keywords = preg_split('/[ \x{3000}]+/u', $search, -1, PREG_SPLIT_NO_EMPTY);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->where(function ($subQuery) use ($keyword) {
                        $subQuery->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('approvalStage', 'like', '%' . $keyword . '%');
                    });
                }
            });
        }


        $posts = $query->where('user_id',auth()->id())->orderBy('idKP','desc')->paginate(5);
        return view('mypage',compact('posts'));
    }
}
