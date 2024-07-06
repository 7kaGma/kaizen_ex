<!-- resources/views/proposalDetail.blade.php -->

<x-app-layout>
    <x-content-frame>
        <div>
            <div class="flex justify-between">
                <div class="text-xl">提案書詳細 <span class="text-sm text-gray-600">採用の可否をお願いします</span></div>
            </div>
            {{-- 提案書全体 --}}
            <div class="flex w-full h-scleen">
                
                {{-- 左側 提案書No、提案書名、現状、提案内容、メリット 予算  --}}
                <div class="bg-blue-200 w-1/2 rounded-l-xl h-scleen">
                    <div class="mx-2">
                        <h2 class="font-bold">No</h2>
                        <div class=" px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->idKP !!}</div>

                        <h2 class="font-bold">タイトル</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->title !!}</div>

                        <h2 class="font-bold">現状とその問題点</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->currentSituation !!}</div>
    
                        <h2 class="font-bold">提案内容</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full"> {!! $post->proposal !!}</div>

                        <h2 class="font-bold">メリット</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->benefit !!}</div>

                        <h2 class="font-bold">予算</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->budget !!}</div>
                    </div>
                </div>

                {{-- 右側 提案者、提案日、部署名、チーム、上司コメント、ステージ、イイね --}}
                <div class="bg-blue-200 w-1/2 rounded-r-xl h-scleen">
                    <div class="mx-2">
                        <div class="flex">
                            <div class="w-1/2">
                                <h2 class="font-bold mx-auto">提案者</h2>
                                <div class="text-center mx-auto w-4/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->name !!}</div>
                            </div>
                            <div class="w-1/2">
                                <h2 class="font-bold mx-auto">提案日時</h2>
                                <div class="text-center mx-auto w-4/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->updated_at->format('Y-m-d H:i') !!}</div>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-1/3">
                                <h2 class="font-bold">役職</h2>
                                <div class="text-center mx-auto w-4/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full"> {!! $post->position !!}</div>
                            </div>
                            <div class="w-1/3">
                                <h2 class="font-bold">部署名</h2>
                                <div class="text-center mx-auto w-4/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full"> {!! $post->department !!}</div>
                            </div>
                            <div class="w-1/3">
                                <h2 class="font-bold">チーム</h2>
                                <div class="text-center mx-auto w-4/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->team !!}</div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="w-1/3">
                                <div class="flex justify-start border-m-black">
                                    <h2 class="font-bold text-red-500">❤️</h2>
                                </div>
                                <div class=" w-4/5 ">
                                    <div class="text-center w-3/5 px-1 py-3 bg-pink-300 rounded-md text-black mb-2 w-full">{!! $post->goodCounts !!}</div>
                                </div>
                            </div>
                        </div>
                        <form id="edit" action="{{ route('approvalDetail.submit', ['idKP' => $post->idKP]) }}" method="post">
                            {{-- {{ route('mypageDetail.submit', ['idKP' => $post->idKP]) }} --}}
                            @csrf
                        <div class="bg-pink-100 rounded-lg mx-1 my-1">  
                            <div class="">
                                <h2 class="font-bold">上司コメント</h2>
                                <textarea class="bg-slate-300 mb-2 px-1 rounded-md w-full" type="text" name="bossComment" rows="7" cols="" required >{{ $post->bossComment }}</textarea>
                            </div>
                            <div class="flex">
                                <div class="w-1/4 mx-auto">
                                    <h2 class="font-bold text-red-500">現在の承認状態</h2>
                                    <div class="text-center w-3/5 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->approvalStage !!}</div>
                                </div>
                                <div class="w-3/5 mx-auto">
                                    <div class="font-bold text-blue-600">判断をお願いします</div>
                                    <div class="flex justify-evenly rounded-lg bg-slate-300 border border-black my-1 py-1 ">  
                                        <div><input class="" type="radio" id="approvalStage1" name="approvalStage" value="差戻し"><label class="text-black font-bold" for="">差戻し</label></div>
                                        <div><input class="" type="radio" id="approvalStage2" name="approvalStage" value="採用" checked><label class="text-blue-600 font-bold" for="">採用</label></div>
                                        <div><input class="" type="radio" id="approvalStage3" name="approvalStage" value="不採用"><label  class="text-red-600 font-bold"  for="">不採用</label></div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center item-center py-8 gap-12">
            <x-cancel-button  :href="route('book_index')" :active="request()->routeIs('book_index')">戻る</x-cancel-button>
            <button id="update" class="btn-primary" >Update!</button>
        </div>
    </x-content-frame>
    @vite(['resources/js/detailpage.js'])
</x-app-layout>
