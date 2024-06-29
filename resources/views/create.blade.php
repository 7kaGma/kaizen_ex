<x-app-layout>
    <body>
        {{-- <h1>{{config('app.name')}}</h1> --}}
        <div class="text-red-400 text-end">{{Auth::user()->department}}部署、{{Auth::user()->name}}さんの提案です（usersテーブルから流用の確認用,データの受け渡しが確認できたら消す）</div>
        
        <h1 class="text-gray-200 m-2">課題・導入したい事例を記入して、最後に『作成してください』添えると⭕️。</h1>
        <form action="{{route('entry')}}" method="post">
            @csrf
            <textarea class="w-1/2 mx-2 rounded-md" name="toGeminiText" >@isset($result['task']){{$result['task']}}@endisset </textarea>
            <button class="text-gray-100 border p-1 rounded-md" type="submit">AIに作成依頼/再依頼</button>
        </form>

        <hr>

        @isset($result)
        <div class="flex w-full h-scleen">
            <div class="bg-blue-200 w-1/2">
                <h1 class="text-2xl mx-2">AIの提案内容</h1>
                <div class="mx-2">
                    <h2 class="font-bold">提案書名</h2>
                    <div class="bg-blue-300 rounded-md text-black mb-2">{!! $result['title_html'] !!}</div>
                    
                    <h2 class="font-bold">現状とその問題点</h2>
                    <div class="bg-blue-300 rounded-md text-black mb-2">{!! $result['currentSituation_html'] !!}</div>
            
                    <h2 class="font-bold">提案内容</h2>
                    <div class="bg-blue-300 rounded-md text-black mb-2">{!! $result['proposal_html'] !!}</div>
            
                    <h2 class="font-bold">メリット</h2>
                    <div class="bg-blue-300 rounded-md text-black mb-2">{!! $result['benefit_html'] !!}</div>

                    <h2 class="font-bold">予算</h2>
                    <div class="bg-blue-300 rounded-md text-black mb-2">{!! $result['budget_html'] !!}</div>
                </div>
    
            </div>
            <div class="bg-indigo-200 w-1/2 h-scleen">
                <form  method="POST" action="" class="mx-2">
                    <h1 class="text-2xl">最終提案書の作成</h1>
                    @csrf
                    <h2 class="font-bold">提案書名</h2>
                    <input class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="title" value="{{ $result['title']}}" required></input>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />

                    <h2 class="font-bold">現状とその問題点</h2>
                    <textarea class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="currentSituation" rows="3" cols="" required>{{ $result['currentSituation']}}</textarea>
                    <x-input-error :messages="$errors->get('currentSituation')" class="mt-2" />

                    <h2 class="font-bold">提案内容</h2>
                    <textarea class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="proposal" rows="7" cols="" required>{{ $result['proposal'] }}</textarea>
                    <x-input-error :messages="$errors->get('proposal')" class="mt-2" />

                    <h2 class="font-bold">メリット</h2>
                    <textarea class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="benefit" rows="7" cols="" required>{{ $result['benefit'] }}</textarea>
                    <x-input-error :messages="$errors->get('benefit')" class="mt-2" />
                    
                    <h2 class="font-bold">予算</h2>
                    <input class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="budget" value="{{ $result['budget']}}" required></input>
                    <x-input-error :messages="$errors->get('budget')" class="mt-2" />

                    <input type="hidden" name="id" value="{{Auth::user()->id}}"> 
                    {{-- IDの登録 --}}
                    <input type="hidden" name="position" value="{{Auth::user()->position}}"> 
                    {{-- 役職の登録 --}}
                    <input type="hidden" name="department" value="{{Auth::user()->department}}"> 
                    {{-- 部署の登録 --}}
                    <input type="hidden" name="team" value="{{Auth::user()->team}}"> 
                    {{-- teamの登録 --}}
                    <input type="hidden" name="appovalStage" value="0"> 
                    {{-- 承認段階の登録 0:検討中、1:承認、2:否認、3:差し戻し --}}
                    <div class="flex justify-end"><input class="px-2 bg-pink-300 hover:bg-pink-500 rounded cursor-pointer"  type="submit" value="Update!"></div>
                </form>
            </div>

        </div>

        @endisset
    </body>
    </x-app-layout>