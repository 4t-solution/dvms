const chboxSend = $('#chboxSend');
const btnSend = $('#btnSend');;
btnSend.attr('disabled', true);

chboxSend.on('change', function () {
   if (this.checked) {
      btnSend.attr('disabled', false);
   } else {
      btnSend.attr('disabled', true);
   }
});

$(document).ready(function () {
   $('#btnSend').click(function () {
      submitForm();
   })

});

/**
 * 送信処理
 */
function submitForm() {
   let data_form = $('#inputForm').serializeArray();
   data_form = parseJson(data_form);
   console.log(data_form);
   $.ajax({
      url: 'http://localhost/rt/recruit/create',
      type: 'POST',
      data: data_form
   })
   // Ajaxリクエストが成功した時発動
   .done((data) => {
      $('.result').html(data);
      console.log(data);
   })
   // Ajaxリクエストが失敗した時発動
   .fail((data) => {
      $('.result').html(data);
      console.log(data);
   })
}

// ②変換関数：json to 欲しい形
function parseJson(data) {
   var returnJson = {};
   for (idx = 0; idx < data.length; idx++) {
     returnJson[data[idx].name] = data[idx].value
   }
   return returnJson;
 }