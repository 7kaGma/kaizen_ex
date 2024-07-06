<!-- resources/views/proposalDetail.blade.php -->

<x-app-layout>
    <x-content-frame>
    <div>
        <div class="flex justify-between">
            <div class="text-xl">提案書詳細</div>
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
                            <h2 class="font-bold">提案者</h2>
                            <div class="text-center w-5/6 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->name !!}</div>
                        </div>
                        <div class="w-1/2">
                            <h2 class="font-bold">提案日時</h2>
                            <div class="text-center w-5/6 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->updated_at->format('Y-m-d H:i') !!}</div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/3">
                            <h2 class="font-bold">役職</h2>
                            <div class="text-center w-5/6 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full"> {!! $post->position !!}</div>
                        </div>
                        <div class="w-1/3">
                            <h2 class="font-bold">部署名</h2>
                            <div class="text-center w-5/6 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full"> {!! $post->department !!}</div>
                        </div>
                        <div class="w-1/3">
                            <h2 class="font-bold">チーム</h2>
                            <div class="text-center w-5/6 px-1 py-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->team !!}</div>
                        </div>
    
    
    
                    </div>
                    <div class="h-80">
                        <h2 class="font-bold">上司コメント</h2>
                        <div class="px-1 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->bossComment !!}</div>
                    </div>

                    
                    <div class="flex justify-around">
                        <div class="w-1/3">
                            <h2 class="font-bold text-red-500">承認状態</h2>
                            <div class="text-center w-3/5 px-1 py-5 bg-blue-300 rounded-md text-black mb-2 w-full">{!! $post->approvalStage !!}</div>
                        </div>
                        <div class="w-1/3">
                                <h2 class="font-bold text-red-500">❤️</h2>
                            <div class="flex justify-end">
                                <div class="text-center w-3/5 px-1 py-5 bg-pink-300 rounded-md text-black mb-2 w-full">{!! $post->goodCounts !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>



        {{-- <div>
            <h2>Current Situation:</h2>
            <p>{{ $post->currentSituation }}</p>
            
            <h2>Proposal:</h2>
            <p>{{ $post->proposal }}</p>
            
            <h2>Benefit:</h2>
            <p>{{ $post->benefit }}</p>
            
            <h2>Budget:</h2>
            <p>{{ $post->budget }}</p>
            
            <h2>Department:</h2>
            <p>{{ $post->department }}</p>

            <h2>team:</h2>
            <p>{{ $post->team }}</p>
            
            <!-- 他の必要なフィールドも追加できます -->
        </div> --}}
    </div>
    <div class="flex justify-center item-center py-8 gap-12">
    <x-cancel-button :href="route('proposal.list')" :active="request()->routeIs('proposal.list')">
        戻る
    </x-cancel-button>
    <div>
    @if($post->user_id !== auth()->id())
        @if(is_null($like))
            <form method="POST" action="{{ route('like.store') }}">
                @csrf
                <input type="hidden" name="kp_id" value="{{$post->idKP}}">
                <button type='submit' class='btn-secondary'>
                    Like
                </button>
            </form>    
        @else
            <form method="POST" action="{{ route('like.destroy',$like)}}">
                @csrf
                @method('delete')
                <button type='submit' class='pushed'>
                    Dislike
                </button>
            </form>  
        @endif
    @endif
    </div>
</x-content-frame>
</x-app-layout>
