document.getElementById('add-memo').addEventListener('click', function() {
  var input = document.getElementById('memo-input');
  var memo = input.value;
  if (memo) {
    var li = document.createElement('li');
    li.textContent = memo;
    document.getElementById('memo-list').appendChild(li);
    input.value = ''; // 入力フィールドをクリア
  }
});