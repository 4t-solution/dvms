const chboxSend = $('#chboxSend');
const btnSend = $('#btnSend');
$(document).ready(function () {
   chboxSend.attr('disabled', false);
   // count view page
   tracking_view(true);

   btnSend.attr('disabled', true);

   $('#inputForm .form-control, .form-check-input').on('keyup', function () {
      reset_btn_submit();
   })

   $('#inputForm .form-check-input').on('click', function () {
      reset_btn_submit();
   })

   
   $('input[type="date"], input[type="month"]').on('change', function () {
      reset_btn_submit();
   })

   /**
    * change checkbox
    */
   chboxSend.on('change', function () {
      if (this.checked) {
         $('.alert-danger').remove();
         let message = validate_input();
         if(message) {
            var html = '<div class="alert alert-danger" role="alert">';
            html += '<p class="text-center">'+message+'</p>';
            html += '</div>';
            $(html).insertBefore(btnSend.parent());
         } else {            
            btnSend.attr('disabled', false);
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
      submitForm();
    })
 
   $('.menu-control--btn-entry').click(function () {
      tracking_view(false, true);
   })
 });

 

function check_data(data, type_check, label_name) {
   let message = '';
   switch (type_check) {
      case 'regex_zen_kaku':
         // 番地、名称は全角のみ
         const regex_zen_kaku = /^[^\x01-\x7E\uFF61-\uFF9F]+$/;
         if(!data.match(regex_zen_kaku)) {
            message = label_name + 'は全角のみ入力してください。';
         };
         break;
      case 'regex_katakana':
         // バリデーションを入れてください。
         const regex_katakana = /^[ァ-ヶー　、。]*$/;
         if(!data.match(regex_katakana)) {
            message = label_name + 'は全角カナのみ入力してください。';
         };
         break;
      case 'regex_only_number':
         // TELは半角数値のみ
         const regex_only_number = /^[0-9]*$/;
         if(!data.match(regex_only_number)) {
            message = label_name + 'は半角数値のみ入力してください。';
         };
         break;
      case 'regex_post_code':
         // バリデーション入れる　xxx-xxxxのままでは警告を表示
         const regex_post_code = /^[0-9]{3}-?[0-9]{4}$/;
         if(!data.match(regexregex_post_code_zen_kaku)) {
            message = label_name + 'は半角数値のみ入力してください。';
         };
         break;
      case 'regex_mail':
         // メールはメールフォーマットのみ
         const regex_mail = /^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
         if(!data.match(regex_mail)) {
            message = label_name + 'はメールフォーマットのみ入力してください。';
         };
         break;
      case 'required':
         if(!data) {
            message = label_name + 'は必須です。';
         };
         break;
      default:
         break;
   }
   return message;
}
 
 function getNameLabelInput(id) {
   const arr = {
      'family_name': '漢字姓',
      'given_name': '漢字名',
      'family_name_k': 'カナ姓',
      'given_name_k': 'カナ姓名',
      'birth_year': '生年',
      'birth_month': '生月',
      'birth_day': '生日',
      'gender_id': '性別',
      'tel': '電話番号',
      'mail': 'E-mail',
      'mail_confirm': 'E-mail確認用',
      'desired_dept': 'ご希望する診療科',
   };

   return arr[id] ? arr[id] : false;
 }
 
function reset_btn_submit() {
   chboxSend.prop('checked', false);
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
      
      // check data
      if (!data[idx].value) {
         if($.inArray(data[idx].name, arr_validate_not_required) == -1 &&
            $.inArray(data[idx].name, error) == -1) {
            let input_val = data[idx].value;
            let label_name = getNameLabelInput(data[idx].name);
            let type_check = 'required';
            let message = check_data(input_val, type_check, label_name);
            if(message) {
               error.push(message);
            }
            type_check = getTypeCheckByName(data[idx].name);
            message = check_data(input_val, type_check, label_name);
            if(message) {
               error.push(message);
            }
         }
      }
   }
   return [returnJson, error];
  }

  function validate_input() {
   $('.border-error-input').removeClass('border-error-input');
   let data_form = parseJson()[0];
   let input_val = data_form['family_name'];
   let type_check = 'required';
   let label_name = getNameLabelInput('family_name');

   
   let url_path = location.href;
   if(url_path.includes('page6')) {
      input_val = data_form['desired_dept'];
      type_check = 'required';
      label_name = getNameLabelInput('desired_dept');
      if(check_data(input_val, type_check, label_name)) {
         let elm = $('input[name="desired_dept"]');
         elm.addClass('border-error-input');
         return check_data(input_val, type_check, label_name);
      }
   }

   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="family_name"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['family_name'];
   type_check = 'regex_zen_kaku';
   label_name = getNameLabelInput('family_name');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="family_name"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['given_name'];
   type_check = 'required';
   label_name = getNameLabelInput('given_name');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="given_name"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['given_name'];
   type_check = 'regex_zen_kaku';
   label_name = getNameLabelInput('given_name');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="given_name"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['family_name_k'];
   type_check = 'required';
   label_name = getNameLabelInput('family_name_k');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="family_name_k"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['family_name_k'];
   type_check = 'regex_katakana';
   label_name = getNameLabelInput('family_name_k');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="family_name_k"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['given_name_k'];
   type_check = 'required';
   label_name = getNameLabelInput('given_name_k');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="given_name_k"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['given_name_k'];
   type_check = 'regex_katakana';
   label_name = getNameLabelInput('given_name_k');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="given_name_k"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }   

   input_val = data_form['birth_year'];
   type_check = 'required';
   label_name = getNameLabelInput('birth_year');
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['birth_year'];
   type_check = 'regex_only_number';
   label_name = getNameLabelInput('birth_year');
   console.log(check_data(input_val, type_check, label_name));
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['birth_month'];
   type_check = 'required';
   label_name = getNameLabelInput('birth_month');
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['birth_month'];
   type_check = 'regex_only_number';
   label_name = getNameLabelInput('birth_month');
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['birth_day'];
   type_check = 'required';
   label_name = getNameLabelInput('birth_day');
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['birth_day'];
   type_check = 'regex_only_number';
   label_name = getNameLabelInput('birth_day');
   if(check_data(input_val, type_check, label_name)) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['gender_id'];
   type_check = 'required';
   label_name = getNameLabelInput('gender_id');
   if(!$('input[name="gender_id"]').is(':checked')) {
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['tel'];
   type_check = 'required';
   label_name = getNameLabelInput('tel');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="tel"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['tel'];
   type_check = 'regex_only_number';
   label_name = getNameLabelInput('tel');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="tel"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['mail'];
   type_check = 'required';
   label_name = getNameLabelInput('mail');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="mail"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['mail'];
   type_check = 'regex_mail';
   label_name = getNameLabelInput('mail');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="mail"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['mail_confirm'];
   type_check = 'required';
   label_name = getNameLabelInput('mail_confirm');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="mail_confirm"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   input_val = data_form['mail_confirm'];
   type_check = 'regex_mail';
   label_name = getNameLabelInput('mail_confirm');
   if(check_data(input_val, type_check, label_name)) {
      let elm = $('input[name="mail_confirm"]');
      elm.addClass('border-error-input');
      return check_data(input_val, type_check, label_name);
   }

   if(data_form['mail_confirm'] != data_form['mail']) {
      let elm = $('input[name="mail_confirm"]');
      elm.addClass('border-error-input');
      return 'E-mail確認用とE-mailが一致しません。';
   };

   return '';

  }

  /**
   * 
   * @param {*} name 
   */
  function getTypeCheckByName(name) {
   let type = '';
   switch (name) {
      case 'mail':
      case 'mail_confirm':
         type = 'regex_mail';
         break;

      case 'birth_year':
      case 'birth_month':
      case 'birth_day':
      case 'tel':
         type = 'regex_only_number';
         break;

      case 'post_code':
         type = 'regex_post_code';
         break; 

      case 'family_name':
      case 'given_name':
         type = 'regex_zen_kaku';
         break;

      case 'family_name_k':
      case 'given_name_k':
         type = 'regex_han_kana';
         break;

      case 'mail':
         type = 'required';
         break;
   
      default:
         break;
   }
   return type;
  }