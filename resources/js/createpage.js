/*----------
詳細ページの設定
----------*/
// UpdateボタンのクリックでFormを送信させる
"use strict";

// フォーム送信時にボタンを無効化
document.getElementById('requestToAi').addEventListener('click', function() {
    event.preventDefault();
    // フォームのバリデーションチェックを実行
    if (this.form.checkValidity()) {
        this.disabled = true;  // ボタンを無効化
        document.querySelectorAll('a, button').forEach(function(element) {
            element.setAttribute('disabled', 'true');  // ボタンやリンクを無効化
            element.style.pointerEvents = 'none';      // クリックを無効化
        });
        this.form.submit();  // フォーム送信
    } else {
        // バリデーションに失敗した場合、フォームのデフォルトの動作をさせる
        this.form.reportValidity();  // 必要な場合はバリデーションメッセージを表示
    }
});


