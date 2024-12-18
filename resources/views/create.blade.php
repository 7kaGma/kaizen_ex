<x-app-layout>
    <body>
        {{-- <h1>{{config('app.name')}}</h1> --}}
        <div class="text-red-400 text-end"></div>
        
        <x-content-frame class="mb-8">
        <h1 class="text-gray-600 m-2">課題・導入したい事例を記入し、最後に『作成してください』と入力してください。</h1>
        <form action="{{route('entry')}}" method="post">
            @csrf
            <textarea class="w-1/2 mx-2 rounded-md" name="toGeminiText" required>@isset($result['task']){{$result['task']}}@endisset</textarea>
            <x-primary-button id="requestToAi" type="submit">AIに作成依頼</x-prmary-button>
        </form> 
        </x-content-frame>

        

        @isset($result)
        <div class="flex w-full h-scleen gap-6"> 
            <x-content-frame class="flex-1 flex gap-4 flex-col items-start justify-start text-blue-500">
                <h1 class="text-2xl mx-2">AIの提案内容</h1>
                <div>
                    <h2 class="font-bold ">タイトル</h2>
                    <div class="rounded-md  mb-2">{!! $result['title_html'] !!}</div>
                </div> 
                <div>
                    <h2 class="font-bold">現状とその問題点</h2>
                    <div class="rounded-md  mb-2">{!! $result['currentSituation_html'] !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">提案内容</h2>
                    <div class="rounded-md  mb-2">{!! $result['proposal_html'] !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">メリット</h2>
                    <div class="rounded-md  mb-2">{!! $result['benefit_html'] !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">予算</h2>
                    <div class="rounded-md  mb-2">{!! $result['budget_html'] !!}</div>
                </div>
    
            </x-content-frame>
            <x-content-frame class="flex-1">
                <form  method="POST" action="{{ route('kaizenProposals.store') }}" class="mx-2 flex-1 flex-1 flex gap-4 flex-col items-start justify-start">
                    <h1 class="text-2xl">最終提案書の作成</h1>
                    @csrf
                    <div class="w-full">
                    <h2 class="font-bold">タイトル</h2>
                    <input class="bg-gray-100 mb-2 px-1 rounded-md w-full block box-border" type="text" name="title" value="{{ $result['title']}}" required></input>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="w-full">
                    <h2 class="font-bold">現状とその問題点</h2>
                    <textarea class="bg-gray-100 mb-2 px-1 rounded-md w-full" type="text" name="currentSituation" rows="3" cols="" required>{{ $result['currentSituation']}}</textarea>
                    <x-input-error :messages="$errors->get('currentSituation')" class="mt-2" />
                    </div>
                    <div class="w-full">
                    <h2 class="font-bold">提案内容</h2>
                    <textarea class="bg-gray-100 mb-2 px-1 rounded-md w-full" type="text" name="proposal" rows="7" cols="" required>{{ $result['proposal'] }}</textarea>
                    <x-input-error :messages="$errors->get('proposal')" class="mt-2" />
                    </div>
                    <div class="w-full">
                    <h2 class="font-bold">メリット</h2>
                    <textarea class="bg-gray-100 mb-2 px-1 rounded-md w-full" type="text" name="benefit" rows="7" cols="" required>{{ $result['benefit'] }}</textarea>
                    <x-input-error :messages="$errors->get('benefit')" class="mt-2" />
                    </div>
                    <div class="w-full">
                    <h2 class="font-bold">予算</h2>
                    <input class="bg-gray-100 mb-2 px-1 rounded-md w-full" type="text" name="budget" value="{{ $result['budget']}}" required></input>
                    <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                    </div>
                    {{-- teamの登録 --}}
                    <input type="hidden" name="appovalStage" value="検討中"> 
                    {{-- 承認段階の登録 検討中、差戻し、採用、不採用、再提出 --}}
                    <div class="w-full">
                        <div class="flex justify-end"><input class="btn-secondary"  type="submit" value="Update!"></div>
                    </div>
                </form>
            </x-content-frame>
        </div>

        @endisset


        <!-- 操作を無効化するオーバーレイ -->
        


    </body>
    @vite(['resources/js/createpage.js'])
 
    </x-app-layout>