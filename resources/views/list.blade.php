<!-- resources/views/list.blade.php -->

<x-app-layout>
    <x-content-frame>
    <div>
        <div class="text-xl">投稿一覧</div>
        <!-- 検索フォームの追加 -->
        <form method="GET" action="{{ route('proposal.list') }}" class="mb-4">
            <input type="text" name="search" placeholder="提案者・タイトル・承認段階に対して検索可能（一語のみ）" value="{{ request('search') }}" class="px-4 py-2 border rounded w-1/2" />
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded mt-2">検索</button>
        </form>


        @if($posts->count())
        <table class="table-auto w-full">
            <thead>
                <tr class="text-center">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">提案者</th>
                    <th class="px-4 py-2">部署</th>
                    <th class="px-4 py-2">チーム</th>
                    <th class="px-4 py-2">タイトル</th>
                    <th class="px-4 py-2">承認状況</th>
                    <th class="px-4 py-2">❤️</th>
                    <th class="px-4 py-2">詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr class="text-center">
                    <td class="border px-4 py-2">{{ $post->idKP }}</td>
                    <td class="border px-4 py-2">{{ $post->name}}</td>
                    <td class="border px-4 py-2">{{ $post->department}}</td>
                    <td class="border px-4 py-2">{{ $post->team}}</td>
                    <td class="border px-4 py-2">{{ $post->title }}</td>
                    <td class="border px-4 py-2">{{ $post->approvalStage }}</td>
                    <td class="border px-4 py-2">{{ $post->goodCounts }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('proposal.detail', ['idKP' => $post->idKP]) }}" class="text-blue-500 hover:underline">🔍</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 flex justify-center">
            {{ $posts->appends(request()->query())->links()}}
        </div>
        @else
        <p>No proposals found.</p>
        @endif
    </div>
</x-content-frame>
</x-app-layout>