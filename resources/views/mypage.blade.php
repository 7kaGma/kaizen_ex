<x-app-layout>
<x-content-frame>
    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h1 class="text-xl" style="text-align: left; margin-bottom: 20px;">{{Auth::user()->name}}さんの投稿一覧</h1>
        <div style="overflow-x: auto;">
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
                {{ $posts->links()}}
            </div>
        </div>
    </div>
</x-content-frame>
</x-app-layout>
