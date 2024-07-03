<!-- resources/views/books.blade.php -->
<x-app-layout>
  <!--全エリア[START]-->
  <div class="flex flex-col bg-gray-100 min-h-screen">
    <!-- 全体の見出しと説明文 [START] -->
    <div class="bg-white py-4 sm:py-4 lg:py-6">
      <div class="mx-auto max-w-screen-2xl px-4 md:px-6">
        <div class="mb-3 md:mb-3">
          <h2 class="mb-1 text-center text-2xl font-bold text-gray-800 md:mb-4 lg:text-3xl">KaizenEx Dashboard</h2>
          <p class="mx-auto max-w-screen-md text-center text-gray-500 md:text-lg">従業員のアイデアを手軽に提案・共有できるアプリ。インセンティブ制度でやる気を引き出し、ESを高めます。会社は現場の意見を反映して、組織運営を改善し、離職率低下を図ります。</p>
        </div>
      </div>
    </div>
    <!-- 全体の見出しと説明文 [END] -->

    <!-- 自分の投稿一覧 -->
    <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-blue-600 mx-4 my-4">
      <div class="grid gap-4">

        @php
            $position = Auth::user()->position;
        @endphp

        @if ($position === '一般社員' || $position === '係長')
            <!-- usersテーブルのpositionが係長と一般社員の時の表示-->
            <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white text-gray-900 w-full">
                <h3 class="mb-2 text-lg font-semibold md:text-xl">自分の投稿一覧</h3>
                <p class="mb-4 text-gray-500">あなたの投稿した提案書一覧が確認できます</p>
            @if($mines->count())
            <table > <!-- ここでテーブルを追加 -->
              <thead>
                  <tr class="text-center">
                      <th style=" font-weight: bold;">No</th>
                      <th style=" font-weight: bold;">提案日</th>
                      <th style=" font-weight: bold;">タイトル</th>
                      <th style=" font-weight: bold;">承認状況</th>
                      <th style=" font-weight: bold;">❤️</th>
                      <th style=" font-weight: bold;">詳細</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($mines as $mine)
                  <tr class="text-center">
                      <td class="border px-4 py-2">{{ $mine->idKP }}</td>
                      <td class="border px-4 py-2">{{ $mine->updated_at->format('Y-m-d') }}</td>
                      <td class="border px-4 py-2">{{ $mine->title }}</td>
                      <td class="border px-4 py-2">{{ $mine->approvalStage }}</td>
                      <td class="border px-4 py-2">{{ $mine->goodCounts }}</td>
                      <td class="border px-4 py-2">
                          <a href="{{ route('mypageDetail', ['idKP' => $mine->idKP]) }}" class="text-blue-500 hover:underline">🔍</a>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
              </table> <!-- テーブルの終了タグ -->
                <div class="text-center mt-4">
                    <x-secondary-button :href="route('mypage')" :active="request()->routeIs('mypage')">More</x-secondary-button>
                </div>
              @else
              <p>No proposals found.</p>
              @endif

            </div>
        @elseif ($position === '課長' || $position === '部長')
            <!-- usersテーブルのpositionが課長と部長の時の表示-->
            <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white text-gray-900 w-full">
                <h3 class="mb-2 text-lg font-semibold md:text-xl">承認案件の一覧</h3>
                <p class="mb-4 text-gray-500">承認が必要な提案書一覧が確認できます</p>

                @if($approvals->count())
                <table> <!-- ここでテーブルを追加 -->
                  <thead>
                      <tr class="text-center">
                          <th style=" font-weight: bold;">No</th>
                          <th style=" font-weight: bold;">提案者</th>
                          <th style=" font-weight: bold;">提案日</th>
                          <th style=" font-weight: bold;">タイトル</th>
                          <th style=" font-weight: bold;">承認状況</th>
                          <th style=" font-weight: bold;">詳細</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($approvals as $approval)
                      <tr class="text-center">
                          <td class="border px-4 py-2">{{ $approval->idKP }}</td>
                          <td class="border px-4 py-2">{{ $approval->name }}</td>
                          <td class="border px-4 py-2">{{ $approval->updated_at->format('Y-m-d') }}</td>
                          <td class="border px-4 py-2">{{ $approval->title }}</td>
                          <td class="text-red-800 border px-4 py-2">{{ $approval->approvalStage }}</td>
                          <td class="border px-4 py-2">
                              <a href="{{ route('approvalDetail', ['idKP' => $approval->idKP]) }}" class="hover:underline">🔍</a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
                  </table> <!-- テーブルの終了タグ -->
                  <div class="mt-4 flex justify-center">
                    {{ $approvals->links()}}
                  </div>
                  @else
                  <p>No proposals found.</p>
                  @endif
                <div class="text-center mt-4">
                    {{-- <x-secondary-button :href="route('approvalList')" :active="request()->routeIs('approvalList')">More</x-secondary-button> --}}
                </div>
            </div>

        @endif
      </div>

    </div>

    <!-- バリデーションエラーの表示に使用-->
    <x-errors id="errors" class="bg-blue-500 rounded-lg mx-auto my-4">{{$errors}}</x-errors>
    <!-- バリデーションエラーの表示に使用-->

    <!-- コンテンツエリア [START] -->
    <div class="flex flex-1 mx-4 mb-4 space-x-4">
      <!--左エリア[START]-->
      <div class="flex flex-col w-1/2 space-y-4">
        <!-- 最新一覧Top10 -->
        <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white">
          <h3 class="mb-2 text-lg font-semibold md:text-xl">最新投稿Top5</h3>
          <p class="mb-4 text-gray-500">最近提案された改善提案書の上位5件を表示しています</p>
          <!-- テーブル表示エリア -->
          <div class="overflow-x-auto">
            <table id="latestProposalsTable" class="text-center min-w-full border-collapse" >
              <thead>
                <tr>
                  <th class="px-4 py-2">提案日</th>
                  <th class="px-4 py-2">提案者</th>
                  <th class="px-4 py-2">タイトル</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="text-center mt-4">
            <x-secondary-button :href="route('proposal.list')" :active="request()->routeIs('proposal.list')">More</x-secondary-button>
          </div>
        </div>

        <!-- 個人別提案数一覧 -->
        <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white">
          <h3 class="mb-2 text-lg font-semibold md:text-xl">個人別提案数一覧</h3>
          <p class="mb-4 text-gray-500">あなたのアイデアが会社を変えます！！</p>
        </div>
      </div>
      <!--左エリア[END]-->

      <!--右エリア[START]-->
      <div class="flex flex-col w-1/2 space-y-4">
        <!-- 部署別提案数一覧 -->
        <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white">
          <h3 class="mb-2 text-lg font-semibold md:text-xl">部署別提案数一覧</h3>
          <p class="mb-4 text-gray-500">チームそれぞれ個性豊なアイデア、読むのが楽しい！</p>
        </div>

        <!-- イイネ👍 -->
        <div class="flex flex-col rounded-lg border p-4 md:p-6 bg-white">
          <h3 class="mb-2 text-lg font-semibold md:text-xl">直近３ヶ月のGood❤️Top5</h3>
          <p class="mb-4 text-gray-500">共感した！そのアイデアイイネと思ったら❤️ボタンで清き1票を！</p>
                          @if($goodCounts->count())
                <table> <!-- ここでテーブルを追加 -->
                  <thead>
                      <tr class="text-center">
                          <th style=" font-weight: bold;">No</th>
                          <th style=" font-weight: bold;">提案者</th>
                          <th style=" font-weight: bold;">タイトル</th>
                          <th style=" font-weight: bold;">承認状況</th>
                          <th style=" font-weight: bold;">❤️</th>
                          <th style=" font-weight: bold;">詳細</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($goodCounts as $goodCount)
                      <tr class="text-center">
                          <td class="border px-4 py-2">{{ $goodCount->idKP }}</td>
                          <td class="border px-4 py-2">{{ $goodCount->name }}</td>
                          <td class="border px-4 py-2">{{ $goodCount->title }}</td>
                          <td class="border px-4 py-2">{{ $goodCount->approvalStage }}</td>
                          <td class="text-red-800 border px-4 py-2">{{ $goodCount->goodCounts }}</td>
                          <td class="border px-4 py-2">
                              <a href="{{ route('proposal.detail', ['idKP' => $goodCount->idKP]) }}" class="hover:underline">🔍</a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
                  </table> <!-- テーブルの終了タグ -->

                  @else
                  <p>No proposals found.</p>
                  @endif




        </div>
      </div>
      <!--右エリア[END]-->
    </div>
    <!-- コンテンツエリア [END] -->
  </div>
  <!--全エリア[END]-->

  <!-- データをJavaScriptに渡す -->
  <script>
    var chartData = @json($chartData);
  </script>
  <!-- main.js の読み込み -->
   @vite(['resources/js/main.js'])
</x-app-layout>