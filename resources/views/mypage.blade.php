<x-app-layout>
<x-content-frame>
    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h1 class="text-xl" style="text-align: left; margin-bottom: 20px;">{{Auth::user()->name}}さんの投稿一覧</h1>
        <div style="overflow-x: auto;">
                    <!-- 検索フォームの追加 -->
        <form method="GET" action="{{ route('mypage') }}" class="mb-4">
            <input type="text" name="search" placeholder="タイトルに対して検索 (複数ワード検索可能)" value="{{ request('search') }}" class="px-4 py-2 border rounded w-1/2" />
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded mt-2 active:scale-95 active:shadow-lg transition-transform duration-100">検索</button>
            @if(request('search'))
                <a href="{{ route('mypage') }}" class="rounded bg-gray-500 py-2 px-3 mt-2 text-white hover:bg-gray-600 active:scale-95 active:shadow-lg transition-transform duration-100">
                    絞込解除
                </a>
            @endif
        </form>
        @if($posts->count())
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr class="text-center">
                        <th style=" font-weight: bold;">No</th>
                        <th style=" font-weight: bold;">提案日時</th>
                        <th style=" font-weight: bold;">タイトル</th>
                        <th style=" font-weight: bold;">承認状況</th>
                        <th style=" font-weight: bold;">❤️</th>
                        <th style=" font-weight: bold;">詳細確認</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $post->idKP }}</td>
                        <td class="border px-4 py-2">{{ $post->updated_at->format('Y-m-d H:i')}}</td>
                        <td class="border px-4 py-2">{{ $post->title }}</td>
                        <td class="border px-4 py-2">{{ $post->approvalStage }}</td>
                        <td class="border px-4 py-2">{{ $post->goodCounts }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('mypageDetail', ['idKP' => $post->idKP]) }}" class="text-blue-500 hover:underline">🔍</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-center">
            {{ $posts->appends(request()->query())->links()}}
            
            </div>
        </div>
        @else
        <p>No proposals found.</p>
        @endif
    </div>
</x-content-frame>
</x-app-layout>
