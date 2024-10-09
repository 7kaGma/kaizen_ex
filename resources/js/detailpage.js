/*----------
詳細ページの設定
----------*/
// UpdateボタンのクリックでFormを送信させる
"use strict";

document.addEventListener('DOMContentLoaded', () => {
    const update = document.getElementById('update');
    if (update) {
        update.addEventListener('click', () => {
            // 確認ダイアログを表示して、OKの場合のみフォームを送信
            if (confirm('内容に間違いはありませんか?')) {
                document.getElementById('edit').submit();
            } else {
                // キャンセルされた場合、何もしない
                return false;
            }
        });
    }
});


