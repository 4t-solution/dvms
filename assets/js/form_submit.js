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

   
   $('input[type="date"], input[type="month"]').on('change', function () {
      validate_form();
   })

   /**
    * change checkbox
    */
   chboxSend.on('change', function () {
      let check_form = parseJson();
      if (this.checked) {
         var numberRegex = /^\d+$/;
         if(!numberRegex.test(check_form[0]['tel'])) {
            check_form[1].push('tel');
         };

         if (check_form[1].length == 0) {
            btnSend.attr('disabled', false);            
         } else {
            var html = '<div class="alert alert-danger" role="alert">';
            html += '<p class="text-center">'+ getNameLabelInput(check_form[1][0]) +'は必須です。</p>';
            html += '</div>';
            $(html).insertBefore(btnSend);
            btnSend.attr('disabled', true);
         }
      } else {
         btnSend.attr('disabled', true);
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
      if (errors.length == 0) {
       submitForm();
      } else {
         validate.showErrors();
      }
    })
 
   $('.menu-control--btn-entry').click(function () {
      tracking_view(false, true);
   })
 });

 function getNameLabelInput(id) {
   const arr = {
      'family_name': '漢字姓',
      'given_name': '漢字名',
      'family_name_k': 'カナ姓',
      'given_name_k': 'カナ姓名',
      'birth_year': '生年月日',
      'birth_month': '生年月日',
      'birth_day': '生年月日',
      'gender_id': '性別',
      'tel': '電話番号',
      'mail': 'E-mail',
      'mail_confirm': 'E-mail確認用',
   };

   return arr[id];
 }
 
function reset_btn_submit() {
   chboxSend.attr('disabled', true);
   btnSend.attr('disabled', true);
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
      success: function (data) {
      },
      // Ajaxリクエストが失敗した時発動
      error: function (xhr, status, error) {
         console.log('tracking api error');
      },
   })
}

function validate_form() {
   this.reset_btn_submit();
   let check_form = parseJson();
   if (check_form[1].length == 0) {
      chboxSend.attr('disabled', false);
      if($('#chboxSend').is(':checked')) {
         btnSend.attr('disabled', false);
      }      
   } else {
      chboxSend.attr('disabled', true);
      btnSend.attr('disabled', true);
   }
}

 /**
  * 送信処理
  */
 function submitForm() {
   // set page title
   let url_path = location.href;
   let page_title = url_path.split('/');
   page_title = page_title[page_title.length - 1];
   const ARRAY_TITLE = {
      'page2.html': "獣医 キャリア 総合診療 正社員",
      'page3.html': "獣医 新卒 総合診療 正社員",
      'page4.html': "看護士 新卒 総合診療 正社員",
      'page5.html': "獣医 キャリア 夜間診療 正社員",
      'page6.html': "獣医 キャリア 専科研修 アルバイト",
      'page7.html': "獣医 キャリア 麻酔科 正社員",
      'page8.html': "獣医 キャリア 画像診断科 正社員",
   };

   let applicant_id = $('#applicant_id').val();
   let api_url = 'http://room14.ml/ahm10_dev/rt/hr/recruit/create';
   let data_form = parseJson();
   if (applicant_id) {
      api_url = 'http://room14.ml/ahm10_dev/rt/hr/recruit/update/' + applicant_id;
   }
   data_form[0]['recruit_category'] = ARRAY_TITLE[page_title];
   if(data_form[0]['graduation_year']) {
      data_form[0]['graduation_month'] = data_form[0]['graduation_year'].split('-')[1];
      data_form[0]['graduation_year'] = data_form[0]['graduation_year'].split('-')[0];
   }
    $.ajax({
      url: api_url,
      method: applicant_id ? 'PUT' : 'POST',
      data: data_form[0],
       // Ajaxリクエストが成功した時発動
      success: function (data) {
         $('#btnSend').html(
            `送信する`
         );
         var html = `<p>ご登録ありがとうございました。後日、担当よりご連絡いたします。</p>`;
         $('#confirm_modal #content_confirm').html(html);
         $('#confirm_modal').modal('show');
       },
       // Ajaxリクエストが失敗した時発動
      error: function (xhr, status, error) {
         $('#chboxSend').attr('checked', false);
         $('#chboxSend').attr('disabled', true);
         $('#btnSend').attr('disabled', true);
         $('#btnSend').html('送信する');
         console.log('error submit form');
       },
    })
 }
 
 // ②変換関数：json to 欲しい形
function parseJson() {
   var arr_validate_not_required = [
      "qualification", 
      "career", 
      "recruit_category",
      "working_preferred_date", 
      "reasons_for_application", 
      "desired_dept", 
      "tour_preferred_date", 
      "applicant_question",
   ];
   let data = $('#inputForm').serializeArray();
   var error = [];
   var returnJson = {};
   for (idx = 0; idx < data.length; idx++) {
      if (returnJson[data[idx].name]) {
         returnJson[data[idx].name] += ',' + data[idx].value;
      } else {
         returnJson[data[idx].name] = data[idx].value;
      }
      
      if (!data[idx].value) {
         if($.inArray(data[idx].name, arr_validate_not_required) == -1 &&
          $.inArray(data[idx].name, error) == -1) {
            error.push(data[idx].name);
         }
      }
   }
   return [returnJson, error];
  }