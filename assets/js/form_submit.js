
$(document).ready(function () {
   $("#inputForm").validate({
      // in 'rules' user have to specify all the constraints for respective fields
      rules: {
         family_name: "required",
         given_name: "required",
         family_name_k: "required",
         given_name_k: "required",
         birth_year: {
            required: true,
            minlength: 4, //for length of lastname
            maxlength: 4 //for length of lastname
         },
         birth_month: {
            required: true,
            minlength: 2, //for length of lastname
            maxlength: 2 //for length of lastname
         },
         birth_day: {
            required: true,
            minlength: 2, //for length of lastname
            maxlength: 2 //for length of lastname
         },
         gender_id: {
            required: true,
         },
         tel: {
            required: true,
            maxlength: 14
         },
         mail_confirm: {
            required: true,
            equalTo: "#mail"
         },
         mail: {
            required: true,
            email: true
         },
         applicant_question: {
            required: true,
         }
      },
      // in 'messages' user have to specify message as per rules
      messages: {
         family_name: "漢字姓は必須です。",
         given_name: "漢字名は必須です。",
         family_name_k: "カナ姓は必須です。",
         given_name_k: "カナ名は必須です。",
         birth_year: {
              required: "必須",
              minlength: "誕生年は4文字以内で入力してください",
              maxlength: "誕生年は4文字以内で入力してください",
         },
         birth_month: {
              required: "必須",
              minlength: "誕生月は2文字以内で入力してください",
              maxlength: "誕生月は2文字以内で入力してください",
         },
         birth_day: {
              required: "必須",
              minlength: "誕生日は2文字以内で入力してください",
              maxlength: "誕生日は2文字以内で入力してください",
         },
         gender_id: {
            required: "性別は必須です。",
         },
         tel: {
            required: "電話番号は必須です。",
         },
         mail: {
            required: "E-mailは必須です。",
         },
         mail_confirm: {
            required: "E-mail確認用は必須です。",
            equalTo: "上記と同じE-mailを入力してください"
         },
         applicant_question: {
            required: "Eその他ご質問は必須です。",
         },
      }
   });

    $('#btnSend').click(function () {
      var validate = $('#inputForm').validate();
      var errors = validate.errorList; 
      if(errors.length == 0) {
         submitForm();
      } else {
         validate.showErrors();
      }
    })
 });
 
 /**
  * 送信処理
  */
 function submitForm() {
    let data_form = $('#inputForm').serializeArray();
    data_form = parseJson(data_form);
    $.ajax({
      url: 'http://room14.ml/ahm10_dev/rt/hr/recruit/create',
      method: 'POST',
      data: data_form,
      // Ajaxリクエストが成功した時発動
      success: function(data) {
         var html = `<p>登録に成功しました。</p>
         <p>ご入力いただいたメールアドレス宛に受付確認メールをお送りしましたのでご確認ください。</p>`;
         $('#confirm_modal #content_confirm').html(html);
         $('#confirm_modal').modal('show');
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
   var error = [];
    var returnJson = {};
    for (idx = 0; idx < data.length; idx++) {
      returnJson[data[idx].name] = data[idx].value;
    }
    return returnJson;
  }