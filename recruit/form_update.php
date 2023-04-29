<?php
if(isset($_GET['token'])) {
    $token_decode = $_GET['token'];
    // $token_decode = base64_encode('76-hoank-08072705862');
    $token_decode = base64_decode($token_decode);
    $data = explode('-', $token_decode);
    function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }
    $applicant_id = $data[0];
    $get_data = callAPI('GET', 'http://room14.ml/ahm10_dev/rt/hr/recruit/show/'.$applicant_id, false);
    $response = json_decode($get_data, true);
    $get_prefs_api = callAPI('GET', 'http://room14.ml/ahm10_dev/rt/api/v1/combobox-data/show/prefecture_id', false);
    $prefs_api = json_decode($get_prefs_api, true);
    $prefs = $prefs_api['items'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DVMsどうぶつ医療センター横浜　求人エントリーフォーム</title>
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="../assets/img/cropped-dvms_logo-1-180x180.png">
    <link rel="icon" type="image/png" sizes="180x180" href="../assets/img/cropped-dvms_logo-1-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/img/cropped-dvms_logo-1-192x192.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-size.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/Features-Large-Icons-icons.css">
    <link rel="stylesheet" href="../assets/css/menu_new.css">
    <link rel="stylesheet" href="../assets/css/styles_menu.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/Testimonials-images.css">
    <link rel="stylesheet" href="../assets/css/top.css">    
    <style>
        @media (min-width: 750px)  {
            .update-form {
                left: 300px !important;
                top: 30px !important;
            }
        }

        .alert-danger {
            /* text-align: center; */
            height: 40px;
            padding: 5px 15px;
        }

        .alert-danger p {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <header class="navbar" style="overflow: hidden;">
        <header class="header-top">
            <div class="header-top-wrap">
                <div class="container nav-container menu-list menu-list-fixed p-0" id="menu-list-fixed">
                    <div id="header-title" class="header-title">
                        <div class="logo"><a href="index.html"><img class="img-fluid logo-image" src="../assets/img/top/TOP0.png"></a></div>
                        <div class="page-title-header-2 update-form">
                            <p class="font-size-24 font-20-sp"><strong>DVMsどうぶつ医療センター横浜　求人エントリーフォーム</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </header>
    <main class="main-top">        
        <div class="container container-fluid overflow-hidden">
            <div class="col col-xs-2" style="max-width: 1200px;margin: 0 auto;overflow-x: hidden;">
                <div class="row font-type-meiryo">
                    <div class="col-1"></div>
                    <div class="col">
                        <form id="inputForm" class="wrap12 h-adr">
                            <span class="p-country-name" style="display:none;">Japan</span>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">応募者ＩＤ</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" type="text" required="" placeholder="" disabled="" name="applicant_info_id"></div>
                            </div>
                            <div class="row text-center d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">お名前</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="漢字姓" required="" name="family_name"></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="漢字名" required="" name="given_name"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">フリガナ</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="カナ姓　全角" required="" name="family_name_k"></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="カナ名　全角" required="" name="given_name_k"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;">
                                    <label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">性別</span></label>
                                    <label class="form-label form-label form-label-1">(※必須)</label>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-sm-flex">
                                        <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 col-xxl-2 d-sm-flex align-self-center align-items-sm-end col-4">
                                        <select name="gender_id" class="form-select" aria-label="Default select example">
                                            <option value="男">男</option>
                                            <option value="女">女</option>
                                            <option value="無回答">無回答</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">生年月日</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input" type="text" required="" minlength="4" maxlength="4" pattern="\d{4}" placeholder="1990" name="birth_year"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">年</span></label></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input" type="text" required="" minlength="2" maxlength="2" pattern="\d{2}" placeholder="01" name="birth_month"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">月</span></label></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input" type="text" required="" minlength="2" maxlength="2" pattern="\d{2}" placeholder="01" name="birth_day"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">日</span></label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">郵便番号</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center " style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input p-postal-code" type="text" required="" minlength="3" maxlength="3" pattern="\d{3}" placeholder="半角数字" name="zip_a"></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input p-postal-code" type="text" required="" minlength="4" maxlength="4" pattern="\d{4}" placeholder="半角数字" name="zip_b"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">住所</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 col-xxl-10 text-start align-self-center" style="padding-top: 6px;">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center col-sm-8 py-1">
                                            <select name="pref_id" id="pref_id" class="p-region form-select" aria-label="Default select example">
                                                <?php foreach($prefs as $key => $pref) {?>
                                                    <option><?php echo $pref['text'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input p-locality" type="text" placeholder="市区町村" required="" name="addr_a" ></div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="番地" required="" name="addr_b"></div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input" type="text" placeholder="建物名" required="" name="addr_c"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">TEL</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" type="tel" required="" placeholder="半角数字" name="tel"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">メール</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" type="email" required="" placeholder="" name="mail" ></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">学校・学部・学科</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" required="" placeholder="" name="school"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">卒業（予定）年</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" required="" placeholder="" type="month" name="graduation_year"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">卒業/卒業見込</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="is_graduated"  value="卒業"><label class="form-check-label" for="is_graduated-1">卒業</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="is_graduated"  value="見込"><label class="form-check-label" for="is_graduated-2">卒業見込</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">資格など</span></label><label class="form-label form-label form-label-1"></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input" style="width: 100%;" name="qualification"></textarea></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">職務経歴</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input" style="width: 100%;" name="career"></textarea></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">応募内容</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="application_category" id="application_category-1" value="就職"><label class="form-check-label" for="application_category-1">就職</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" id="application_category" name="application_category" id="application_category-2" value="見学"><label class="form-check-label" for="application_category-2">見学</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" id="application_category" name="application_category" value="実習" id="application_category-3" ><label class="form-check-label" for="application_category-2">実習</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">求人区分</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" type="text" placeholder="                          " disabled="" name="recruit_category"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">勤務開始希望日</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" required="" placeholder="                       " type="date" name="working_preferred_date"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">志望動機</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input" style="width: 100%;" name="reasons_for_application"></textarea></div>
                            </div>
                            <div class="row py-2" id="desired_dept" style="display: none; height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">ご希望する診療科</span></label><label class="form-label form-label form-label-1">(※複数選択可)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-flex" style="margin: 0px;padding: 0px;">
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" name="desired_dept" value="総合"><label class="form-check-label" for="formCheck-1">総合診療外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-11" name="desired_dept" value="皮膚"><label class="form-check-label" for="formCheck-11">皮膚科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-10" name="desired_dept" value="眼"><label class="form-check-label" for="formCheck-10">眼科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-9" name="desired_dept" value="腫瘍"><label class="form-check-label" for="formCheck-9">腫瘍科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-8" name="desired_dept" value="整形外"><label class="form-check-label" for="formCheck-8">整形外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-7" name="desired_dept" value="軟外"><label class="form-check-label" for="formCheck-7">軟部外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-6" name="desired_dept" value="循環器"><label class="form-check-label" for="formCheck-6">循環器科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-5" name="desired_dept" value="行動"><label class="form-check-label" for="formCheck-5">行動診療科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-4" name="desired_dept" value="麻酔"><label class="form-check-label" for="formCheck-4">麻酔科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-3" name="desired_dept" value="画像"><label class="form-check-label" for="formCheck-3">画像診断科</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">実習・見学希望日</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input" required="" placeholder="                       " type="date" name="tour_preferred_date" ></div>
                            </div>
                            <div class="row py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">当院を知ったきっかけ</span></label><label class="form-label form-label form-label-1">(※複数選択可)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-flex" style="margin: 0px;padding: 0px;">
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-2" name="channel" value="ネット"><label class="form-check-label" for="formCheck-2">&nbsp;インターネット検索</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-27" name="channel" value="説明会"><label class="form-check-label" for="formCheck-27">&nbsp;合同説明会</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-26" name="channel" value="パンフ"><label class="form-check-label" for="formCheck-26">&nbsp;パンフレットや他紙ツール</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-25" name="channel" value="当院HP"><label class="form-check-label" for="formCheck-25">当院ホームページ</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-24" name="channel" value="ハローワーク"><label class="form-check-label" for="formCheck-24">&nbsp;ハローワーク</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-23" name="channel" value="雑誌"><label class="form-check-label" for="formCheck-23">&nbsp;雑誌広告</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-22" name="channel" value="セミナー"><label class="form-check-label" for="formCheck-22">DVMsセミナー</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-21" name="channel" value="学校"><label class="form-check-label" for="formCheck-21">&nbsp;学校の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-20" name="channel" value="友人"><label class="form-check-label" for="formCheck-20">&nbsp;友人の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-19" name="channel" value="家族"><label class="form-check-label" for="formCheck-19">&nbsp;家族の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-18" name="channel" value="求人"><label class="form-check-label" for="formCheck-18">&nbsp;求人媒体&nbsp;</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-17" name="channel" value="Facebook"><label class="form-check-label" for="formCheck-17">Facebook</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-16" name="channel" value="Twitter"><label class="form-check-label" for="formCheck-16">Twitter</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-15" name="channel" value="Instagram"><label class="form-check-label" for="formCheck-15">Instagram</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-14" name="channel" value="LINE"><label class="form-check-label" for="formCheck-14">LINE</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-13" name="channel" value="YouTube"><label class="form-check-label" for="formCheck-13">YouTube</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-12" name="channel" value="その他SNS"><label class="form-check-label" for="formCheck-12">その他SNS</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label col-form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">その他ご質問</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input" style="width: 100%;" name="applicant_question"></textarea></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row">
                    <div class="space-2x"></div>
                    <div>
                        <p class="font-size-16 font-type-meiryo">個人情報のお取り扱いについての同意</p>
                        <p class="font-size-16 font-type-meiryo">本フォームからお客様が記入・登録された個人情報は、内容確認・電子メール送信・電話連絡などの目的で利用・保管します。</p>
                    </div>
                    <div class="col">
                        <div style="position: relative;">
                            <p class="font-size-16 font-type-meiryo" style="display: inline;">個人情報の取扱いに同意の上、送信してください</p>
                            <div class="text-center justify-content-center align-items-center" id="checkbox" style="display: inline-block;padding-left: 16px;padding-bottom: 0;" type="checkbox"><input class="align-items-center" type="checkbox" id="chboxSend" style="width: 20px;height: 20px;" name="is_agreed"></div>
                        </div>
                    </div>
                </div>
                <div class="row d-sm-flex justify-content-sm-center">
                    <div class="col text-center col-xs-11">
                        <input type="hidden" id="applicant_id" name="applicant_info_id">
                        <div class="space-2x"></div><button class="btn btn-primary btn btn-outline-primary active font-size-24" id="btnSend" type="button" style="width: 300px;height: 80px;" form="inputForm">送信する</button>
                        <div class="space-2x"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="confirm_modal" tabindex="-1">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">登録確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div id="content_confirm">

                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                  </div>
               </div>
            </div>
        </div>
    </main>
    <footer class="text-center bg-footer-gray footer-menu">
        <div class="container text-muted pt-5 pt-xl-5 overflow-hidden">
            <div class="row">
                <div class="col-12 col-md-12 col-xl-12">
                    <p class="text-center">DVMsどうぶつ医療センター横浜</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4 text-left m-2">
                    <p style="color: #f18b20;">CONTACT</p>
                    <p>〒221-0844</p>
                    <p>神奈川県横浜市神奈川区沢渡</p>
                    <p>2-2　第二泉ビル　2F</p>
                    <p>TEL : 045-479-6999</p>
                </div>
                <div class="col-12 col-md-4 col-xl-4 text-left m-2">
                    <p style="color: #f18b20;">受付時間</p>
                    <p>09：00－18：00</p>
                </div>
                <div class="col-12 col-md-3 col-xl-3 m-2"><a class="underline-hover" href="https://yokohama-dvms.com/" target="_blank"><p style="margin-top: 30px;">コーポレートサイト</p></a></div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="fs-6 text-center">Copyright © DVMs Recruit All Rights Reserved.</p>
                </div>
            </div>
        </div><button class="btn btn-primary btn_go_to_top" id="btn_go_to_top" type="button"><img class="img-fluid" src="../assets/img/top/svg/TOP17.svg" width="80px" height="80px"></button>
    </footer>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery-3.6.4.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="../assets/js/additional-methods.min.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/form_submit_update.js"></script>
    <script>
        $(document).ready(function () {
            const form_data = <?php echo json_encode($response);?>;
            let input_arr = Object.keys(form_data);
            $(input_arr).each((k,obj_name) => {
                $('input, select, textarea').each(function() {
                    let input_name = $(this).attr('name');
                    if(obj_name == input_name) {
                        // checkbox, radio
                        switch(input_name) {
                            case 'desired_dept':
                            case 'channel':
                            case 'is_graduated':
                            case 'application_category':
                                if(form_data[obj_name]) {
                                    if(typeof form_data[obj_name] == 'string' && form_data[obj_name].split(',').length > 0) {
                                    if($.inArray($(this).val(), form_data[obj_name].split(',')) > -1) {
                                        $(this).prop('checked', true);
                                    }
                                }           
                                }           
                                break;
                            case 'graduation_year':
                                if(input_name == obj_name) {
                                    $(this).val(form_data['graduation_year'] + '-'+form_data['graduation_month']);
                                }
                                break;
                            default:
                                if(form_data['recruit_category'] == "獣医 キャリア 専科研修 アルバイト") {
                                    $('#desired_dept').show();
                                } else {
                                    $('#desired_dept').hide();
                                }
                                if(input_name == obj_name) {
                                    $(this).val(form_data[obj_name]);
                                }
                                break;
                        }
                    }                    
                    
                })
            })
        })
    </script>
</body>

</html>