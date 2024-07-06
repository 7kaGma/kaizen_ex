/*----------
詳細ページの設定
----------*/
// UpdateボタンのクリックでFormを送信させる
"use strict";{
const update = document.getElementById('update');
update.addEventListener('click',()=>{
  document.getElementById('edit').submit();
});
}