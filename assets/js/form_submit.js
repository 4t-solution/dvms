const chboxSend = $('#chboxSend');
const btnSend = $('#btnSend');
$(document).ready(function () {  
   // count view page
   tracking_view(true);

   btnSend.attr('disabled', true);
   chboxSend.attr('disabled', true);

   $('#inputForm .form-control, .form-check-input').on('keyup', function () {
      validate_form();
   })

   $('#inputForm .form-check-input').on('click', function () {
      validate_form();
   })

   /**
    * change checkbox
    */
   chboxSend.on('change', function() {
      if (this.checked) {
         let check_form = parseJson();
         if(check_form[1].length == 0) {
            btnSend.attr('disabled', false);
         }
      } else {
         btnSend.attr('disabled', true);
      }
   });
   // validate
   $("#inputForm").validate({
      // in 'rules' user have to specify all the constraints for respective fields
      rules: {
         family_name: "required",
         given_name: "required",
         family_name_k: "required",
         given_name_k: "required",
         birth_year: {
            required: true,
         },
         birth_month: {
            required: true,
         },
         birth_day: {
            required: true,
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
         },
         birth_month: {
              required: "必須",
         },
         birth_day: {
              required: "必須",
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
            required: "その他ご質問は必須です。",
         },
      }
   });

    $('#btnSend').click(function () {
      // disable button
      $(this).prop("disabled", true);
      // add spinner to button
      $(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 送信中...`
      );
      var validate = $('#inputForm').validate();
      var errors = validate?.errorList; 
      if(errors.length == 0) {
         submitForm();
      } else {
         validate.showErrors();
      }
    })

    $('.menu-control--btn-entry').click(function() {
      tracking_view(false, true);
    })
 });

   function autoFormatPostCode() {
      this.formUpdateMember.pref_id = $(".p-region").val();
      this.formUpdateMember.addr_a = $(".p-locality").val();
   }

 function tracking_view(is_load = false, click_entry = false) {
   let api_url = 'http://room14.ml/ahm10_dev/rt/hr/recruit/tracking_view';
   $.ajax({
     url: api_url,
     method: 'POST',
     data: {
      is_load: is_load,
      click_entry: click_entry,
     },
     // Ajaxリクエストが成功した時発動
     success: function(data) {
     },
     // Ajaxリクエストが失敗した時発動
     error: function(xhr, status, error) {
        console.log('tracking api error');
     },
  })  
 }

 function validate_form() {
   let check_form = parseJson();
   if(check_form[1].length == 0) {
      chboxSend.attr('disabled', false);
   } else {
      chboxSend.attr('disabled', true);
      btnSend.attr('disabled', true);
   }
 }
 
 /**
  * 送信処理
  */
 function submitForm() {
    let applicant_id = $('#applicant_id').val();
    let api_url = 'http://room14.ml/ahm10_dev/rt/hr/recruit/create';
    let data_form = parseJson();
    if(applicant_id) {
      api_url = 'http://room14.ml/ahm10_dev/rt/hr/recruit/update/' + applicant_id;
    }
    $.ajax({
      url: api_url,
      method: applicant_id ? 'PUT' : 'POST',
      data: data_form[0],
      // Ajaxリクエストが成功した時発動
      success: function(data) {
         $('#btnSend').html(
            `送送信する`
          );
         var html = `<p>登録に成功しました。</p>
         <p>ご入力いただいたメールアドレス宛に受付確認メールをお送りしましたのでご確認ください。</p>`;
         $('#confirm_modal #content_confirm').html(html);
         $('#confirm_modal').modal('show');
      },
      // Ajaxリクエストが失敗した時発動
      error: function(xhr, status, error) {
         $('#chboxSend').attr('checked', false);
         $('#chboxSend').attr('disabled', true);
         $('#btnSend').attr('disabled', true);
         $('#btnSend').html('送送信する');
         console.log('error submit form');
      },
   })  
 }
 
 // ②変換関数：json to 欲しい形
 function parseJson() {  
   let data = $('#inputForm').serializeArray();
   var error = [];
    var returnJson = {};
    for (idx = 0; idx < data.length; idx++) {
      if(returnJson[data[idx].name]) {
         returnJson[data[idx].name] += ','+data[idx].value;
      } else {
         returnJson[data[idx].name] = data[idx].value;
      }
      if(!data[idx].value) {
         error.push(data[idx].name);
      }
    }
    return [returnJson, error];
  }