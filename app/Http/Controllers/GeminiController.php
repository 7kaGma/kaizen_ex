<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class GeminiController extends Controller
{
    public function index()
    {

        return view('create');
    }

    

    public function entry(Request $request)
    {
        $toGeminiCommand = "# やって欲しいこと\n次のテキストを基に改善提案書を作成してください。\n# 提案書には、次の内容を含めてください。
                            \n- 1.20文字以内の改善提案書の題名\n- 2.こちらから提示した内容から40文字以内で簡潔に「現状とその問題点」を作成・記載する。\n- 3.改善案を150字以内で箇条書き\n- 4.改善内容に対するメリットをポジティブな内容で文章200字以内でにして書いてください。改行も入れてください。\n- 5.改善内容を実施した場合のおおよその費用の概算（万単位）を日本円で書いてください。費用の予測がつかない場合は、uninvestigatedとしてください。ただし、凄いアバウトでも金額提示をしてくれた方が助かります。
                            \n- 題名は'提案書名:'というラベルの後に続けて書いてください。現状とその問題点は'現状:'というラベルの後に続けて書いてください。改善案は'提案内容:'というラベルの後に続けて書いてください。メリットは'メリット:'というラベルの後に続けて書いてください。予算概算は'予算:'というラベルの後に続けて書いてください。\n```\n" 
                            . $request->toGeminiText . "\n```";
        // Gemini APIのレスポンスを取得
        $response = Gemini::geminiPro()->generateContent($toGeminiCommand)->text();
        // レスポンスを解析して提案内容とメリットを抽出する
        list($title, $currentSituation, $proposal, $benefit, $budget) = $this->parseResponse($response);

        $result = [
            'task' => $request->toGeminiText,
            'title_html' => Str::markdown($title),
            'title' => strip_tags($title),
            'currentSituation_html' => Str::markdown($currentSituation),
            'currentSituation' => strip_tags($currentSituation),
            'proposal_html' => Str::markdown($proposal),
            'proposal' => strip_tags($proposal),
            'benefit_html' => Str::markdown($benefit),
            'benefit' => strip_tags($benefit),
            'budget_html' => Str::markdown($budget),
            'budget' => strip_tags($budget),
        ];
        return view('create', compact('result'));
        // dd($request);
    }

        // レスポンスを解析して提案内容とメリットを抽出するメソッド
        private function parseResponse($response)
        {
            // 提案内容とメリットをラベルで分割する
            $title = '';
            $proposal = '';
            $benefit = '';
            $budget = '';
            $currentSituation = '';
            // 正規表現で前方と後方一致する箇所の中身を取得させている
            if (preg_match('/提案書名:\s*(.*?)\s*現状:/s', $response, $matches)) {
                $title = $matches[1];
            }

            if (preg_match('/現状:\s*(.*?)\s*提案内容:/s', $response, $matches)) {
                $currentSituation = $matches[1];
            }
            
            if (preg_match('/提案内容:\s*(.*?)\s*メリット:/s', $response, $matches)) {
                $proposal = $matches[1];
            }
    
            if (preg_match('/メリット:\s*(.*?)\s*予算:/s', $response, $matches)) {
                $benefit = $matches[1];
            }

            if (preg_match('/予算:\s*(.*)/s', $response, $matches)) {
                $budget = $matches[1];
            }
    
            return [$title, $currentSituation, $proposal, $benefit, $budget];
        }
}
