<!-- resources/views/proposalDetail.blade.php -->

<x-app-layout>
    <x-content-frame>
    <div>
        <div class="flex justify-between">
            <div class="text-xl ">提案書詳細</div>
        </div>
        {{-- 提案書全体 --}}
        <div class="flex w-full h-scleen">
            
            {{-- 左側 提案書No、提案書名、現状、提案内容、メリット 予算  --}}
            
            <div class="flex-1 flex flex-col jutify-start items-start gap-4 rounded-l-xl h-scleen p-4">
                <div>
                    <h2 class="font-bold">No</h2>
                    <div class=" px-1  rounded-md text-black mb-2 w-full">{!! $post->idKP !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">タイトル</h2>
                    <div class="px-1  rounded-md text-black mb-2 w-full">{!! $post->title !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">現状とその問題点</h2>
                    <div class="px-1  rounded-md text-black mb-2 w-full">{!! $post->currentSituation !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">提案内容</h2>
                    <div class="px-1  rounded-md text-black mb-2 w-full"> {!! $post->proposal !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">メリット</h2>
                    <div class="px-1  rounded-md text-black mb-2 w-full">{!! $post->benefit !!}</div>
                </div>
                <div>
                    <h2 class="font-bold">予算</h2>
                    <div class="px-1  rounded-md text-black mb-2 w-full">{!! $post->budget !!}</div>
                </div>
            </div>

            {{-- 右側 提案者、提案日、部署名、チーム、上司コメント、ステージ、イイね --}}
            <div class="flex-1 rounded-r-xl h-scleen border-l-2 p-4">
                <div class="mx-2">
                    <div class="flex">
                        <div class="w-1/2">
                            <h2 class="font-bold">提案者</h2>
                            <div class="text-center w-5/6 px-1 py-1 border text-black mb-2 w-full">{!! $post->name !!}</div>
                        </div>
                        <div class="w-1/2">
                            <h2 class="font-bold">提案日時</h2>
                            <div class="text-center w-5/6 px-1 py-1 border text-black mb-2 w-full">{!! $post->updated_at->format('Y-m-d H:i') !!}</div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/3">
                            <h2 class="font-bold">役職</h2>
                            <div class="text-center w-5/6 px-1 py-1 border text-black mb-2 w-full"> {!! $post->position !!}</div>
                        </div>
                        <div class="w-1/3">
                            <h2 class="font-bold">部署名</h2>
                            <div class="text-center w-5/6 px-1 py-1 border text-black mb-2 w-full"> {!! $post->department !!}</div>
                        </div>
                        <div class="w-1/3">
                            <h2 class="font-bold">チーム</h2>
                            <div class="text-center w-5/6 px-1 py-1 border text-black mb-2 w-full">{!! $post->team !!}</div>
                        </div>
    
    
    
                    </div>
                    <div class="h-80">
                        <h2 class="font-bold">上司コメント</h2>
                        <div class="px-1 border rounded-md text-black mb-2 w-full">{!! $post->bossComment !!}</div>
                    </div>

                    
                    <div class="flex justify-around">
                        <div class="w-1/3">
                            <h2 class="font-bold text-red-500">承認状態</h2>
                            <div class="text-center w-3/5 px-1 py-5 border rounded-md text-black mb-2 w-full">{!! $post->approvalStage !!}</div>
                        </div>
                        <div class="w-1/3">
                                <h2 class="font-bold text-red-500">❤️</h2>
                            <div class="flex justify-end">
                                <div class="text-center w-3/5 px-1 py-5 border rounded-md text-black mb-2 w-full">{!! $post->goodCounts !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>

    </div>
  
</x-content-frame>
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
                <x-like-button>
                    {!! $post->goodCounts !!}
                </x-like-button>
            </form>    
        @else
            <form method="POST" action="{{ route('like.destroy',$like)}}">
                @csrf
                @method('delete')
                <x-like-button coreClass="bg-red-500">
                    {!! $post->goodCounts !!}
                </x-like-button>
            </form>  
        @endif
    @endif
    </div>
</x-app-layout>
