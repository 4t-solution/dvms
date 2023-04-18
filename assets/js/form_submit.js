
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
       url: 'http://room14.ml/ahm10_dev/rt/recruit/create',
       method: 'POST',
       data: data_form,
       // Ajaxリクエストが成功した時発動
       success: function(data) {
          console.log(data);
       },
       // Ajaxリクエストが失敗した時発動
       error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          console.log(err.messages.validated_fail);
       },
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