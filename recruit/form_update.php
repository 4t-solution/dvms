<?php
if(isset($_GET['token'])) {
    $token_decode = base64_decode($_GET['token']);
    $data = explode('-', $token_decode);
    $title_page = $data['0'];
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
           'APIKEY: 111111111111111111111',
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
    $applicant_id = $data[1];
    $get_data = callAPI('GET', 'http://room14.ml/ahm10_dev/rt/hr/recruit/show/'.$applicant_id, false);
    $response = json_decode($get_data, true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>dvms</title>
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
</head>

<body>
    <header class="navbar" style="overflow: hidden;">
        <header class="header-top">
            <div class="header-top-wrap">
                <div class="container nav-container menu-list menu-list-fixed p-0" id="menu-list-fixed">
                    <div id="header-title" class="header-title">
                        <div class="logo"><a href="index.html"><img class="img-fluid logo-image" src="../assets/img/top/TOP0.png"></a></div>
                        <div class="page-title-header-2">
                            <p class="font-size-24 font-20-sp"><strong><?php echo $title_page;?></strong></p>
                        </div>
                    </div>
                    <div class="menu-control--btn"><button class="btn btn-primary menu-control--btn-menu" id="btn-menu" type="button"><span><span>Menu</span></span></button></div>
                </div>
            </div>
        </header>
    </header>
    <main class="main-top">        
        <div class="container container-fluid overflow-hidden">
            <div class="col col-xs-2" style="max-width: 1200px;margin: 0 auto;overflow-x: hidden;">
                <div class="row">
                    <div class="col">
                        <p>Paragraph</p>
                    </div>
                </div>
                <div class="row font-type-meiryo">
                    <div class="col-1"></div>
                    <div class="col">
                        <form id="inputForm">
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">応募者ＩＤ</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" type="text" required="" placeholder="" disabled="" name="applicant_info_id" value="<?php echo $response['applicant_info_id'];?>"></div>
                            </div>
                            <div class="row text-center d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">お名前</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="漢字姓" required="" name="family_name" value="<?php echo $response['family_name'];?>"></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="漢字名" required="" name="given_name" value="<?php echo $response['given_name'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">フリガナ</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="カナ姓　全角" required="" name="family_name_k" value="<?php echo $response['family_name_k'];?>"></div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="カナ名　全角" required="" name="given_name_k" value="<?php echo $response['given_name_k'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">性別</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-sm-flex">
                                        <div class="col-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 col-xxl-2 d-sm-flex align-self-center align-items-sm-end col-4">
                                            <div class="dropdown"><button class="btn btn-primary dropdown-toggle text-bg-light border-light" aria-expanded="false" data-bs-toggle="dropdown" id="gender_id" type="button" name="gender_id">性別</button>
                                                <div class="dropdown-menu"><a class="dropdown-item" href="#" name="gender_id">男</a><a class="dropdown-item" href="#" name="gender_id">女</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">生年月日</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input-1" type="text" required="" minlength="4" maxlength="4" pattern="\d{4}" placeholder="半角数字" name="birth_year" value="<?php echo $response['birth_year'];?>"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">年</span></label></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input-1" type="text" required="" minlength="2" maxlength="2" pattern="\d{2}" placeholder="半角数字" name="birth_month" value="<?php echo $response['birth_month'];?>"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">月</span></label></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input-1" type="text" required="" minlength="2" maxlength="2" pattern="\d{2}" placeholder="半角数字" name="birth_day" value="<?php echo $response['birth_day'];?>"></div>
                                        <div class="col-6 col-sm-1 col-lg-1 d-sm-flex align-items-sm-end" style="padding-bottom: 8px;padding-left: 0px;"><label class="col-form-label d-sm-flex align-items-sm-end col-form-label col-1 font-size-16" style="width: 100%;"><span style="color: rgb(0, 0, 0);background-color: transparent;">日</span></label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">郵便番号</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input-1" type="text" required="" minlength="4" maxlength="4" pattern="\d{4}" placeholder="半角数字" name="zip_a" value="<?php echo $response['zip_a'];?>"></div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;"><input class="form-control form-control form-input-1" type="text" required="" minlength="2" maxlength="2" pattern="\d{2}" placeholder="半角数字" name="zip_b" value="<?php echo $response['zip_b'];?>"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">住所</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 col-xxl-10 text-start align-self-center" style="padding-top: 6px;">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center col-sm-8 py-1">
                                            <div class="dropdown" id="pref_id"><button class="btn btn-primary dropdown-toggle text-bg-light border-light" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="width: 100%;" name="pref_id" value="<?php echo $response['pref_id'];?>">都道府県</button>
                                                <div class="dropdown-menu text-center" style="width: 100%;"><a class="dropdown-item" href="#">絡中</a><a class="dropdown-item" href="#">面談予定</a><a class="dropdown-item" href="#">採用</a><a class="dropdown-item" href="#">不採用</a></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="市区町村" required="" name="addr_a" value="<?php echo $response['addr_a'];?>"></div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="番地" required="" name="addr_b" value="<?php echo $response['addr_b'];?>"></div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 align-self-center margin-top-5-sp col-sm-8 py-1"><input class="form-control form-control form-input-1" type="text" placeholder="建物名" required="" name="addr_c" value="<?php echo $response['addr_c'];?>"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">TEL</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" type="tel" required="" placeholder="半角数字                                " name="tel" value="<?php echo $response['tel'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">メール</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" type="email" required="" placeholder="                          " name="mail" value="<?php echo $response['mail'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">学校・学部・学科</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" required="" placeholder="                            " name="school" value="<?php echo $response['school'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">卒業（予定）年</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" required="" placeholder="                              " type="date" name="graduation_year" value="<?php echo $response['graduation_year'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">卒業（予定）月</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" required="" placeholder="                       " type="date" name="graduation_month" value="<?php echo $response['graduation_month'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">卒業/卒業見込</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="is_graduated"><label class="form-check-label" for="is_graduated-1">卒業</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="is_graduated"><label class="form-check-label" for="is_graduated-2">卒業見込</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">資格など</span></label><label class="form-label form-label form-label-1"></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input-1" style="width: 100%;" name="qualification" value="<?php echo $response['qualification'];?>"></textarea></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">職務経歴</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input-1" style="width: 100%;" name="career"><?php echo $response['career'];?></textarea></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">応募内容</span></label><label class="form-label form-label form-label-1">(※必須)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
                                    <div class="row">
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" name="application_category"><label class="form-check-label" for="formCheck-1">就職</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" id="application_category" name="application_category"><label class="form-check-label" for="formCheck-2">見学</label></div>
                                        </div>
                                        <div class="col-6 col-sm-3 d-md-flex align-items-md-center" style="padding-bottom: 8px;padding-right: 6px;">
                                            <div class="form-check"><input class="form-check-input" type="radio" id="application_category" name="application_category"><label class="form-check-label" for="is_graduated-3">実習</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">求人区分</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" type="text" placeholder="                          " disabled="" name="recruit_category" value="<?php echo $response['recruit_category'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">勤務開始希望日</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" required="" placeholder="                       " type="date" name="working_preferred_date" value="<?php echo $response['working_preferred_date'];?>"></div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">志望動機</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input-1" style="width: 100%;" name="reasons_for_application"><?php echo $response['reasons_for_application'];?></textarea></div>
                            </div>
                            <div class="row py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">ご希望する診療科</span></label><label class="form-label form-label form-label-1">(※複数選択可)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-flex" style="margin: 0px;padding: 0px;">
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" name="desired_dept"><label class="form-check-label" for="formCheck-1">総合診療外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-11" name="desired_dept"><label class="form-check-label" for="formCheck-11">皮膚科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-10" name="desired_dept"><label class="form-check-label" for="formCheck-10">眼科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-9" name="desired_dept"><label class="form-check-label" for="formCheck-9">腫瘍科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-8" name="desired_dept"><label class="form-check-label" for="formCheck-8">整形外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-7" name="desired_dept"><label class="form-check-label" for="formCheck-7">軟部外科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-6" name="desired_dept"><label class="form-check-label" for="formCheck-6">循環器科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-5" name="desired_dept"><label class="form-check-label" for="formCheck-5">行動診療科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-4" name="desired_dept"><label class="form-check-label" for="formCheck-4">麻酔科</label></div>
                                        </div>
                                        <div class="col-10 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-3" name="desired_dept"><label class="form-check-label" for="formCheck-3">画像診断科</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">実習・見学希望日</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><input class="form-control form-control form-input-1" required="" placeholder="                       " type="date" name="tour_preferred_date" value="<?php echo $response['tour_preferred_date'];?>"></div>
                            </div>
                            <div class="row py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="form-label form-label form-label-style"><span style="color: rgb(0, 0, 0);">当院を知ったきっかけ</span></label><label class="form-label form-label form-label-1">(※複数選択可)</label></div>
                                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10">
                                    <div class="row d-flex" style="margin: 0px;padding: 0px;">
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-2" name="channel"><label class="form-check-label" for="formCheck-2">&nbsp;インターネット検索</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-27" name="channel"><label class="form-check-label" for="formCheck-27">&nbsp;合同説明会</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-26" name="channel"><label class="form-check-label" for="formCheck-26">&nbsp;パンフレットや他紙ツール</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-25" name="channel"><label class="form-check-label" for="formCheck-25">当院ホームページ</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-24" name="channel"><label class="form-check-label" for="formCheck-24">&nbsp;ハローワーク</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-23" name="channel"><label class="form-check-label" for="formCheck-23">&nbsp;雑誌広告</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-22" name="channel"><label class="form-check-label" for="formCheck-22">DVMsセミナー</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-21" name="channel"><label class="form-check-label" for="formCheck-21">&nbsp;学校の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-20" name="channel"><label class="form-check-label" for="formCheck-20">&nbsp;友人の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-19" name="channel"><label class="form-check-label" for="formCheck-19">&nbsp;家族の紹介</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-18" name="channel"><label class="form-check-label" for="formCheck-18">&nbsp;求人媒体&nbsp;</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-17" name="channel"><label class="form-check-label" for="formCheck-17">Facebook</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-16" name="channel"><label class="form-check-label" for="formCheck-16">Twitter</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-15" name="channel"><label class="form-check-label" for="formCheck-15">Instagram</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-14" name="channel"><label class="form-check-label" for="formCheck-14">LINE</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-13" name="channel"><label class="form-check-label" for="formCheck-13">YouTube</label></div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-3 d-inline-flex align-items-xl-center" style="padding-bottom: 8px;">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-12" name="channel"><label class="form-check-label" for="formCheck-12">その他SNS</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex form-row-1 py-2" style="height: 100%;">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-start align-self-center" style="padding-top: 6px;"><label class="col-form-label col-form-label form-label-style"><span style="color: rgb(0, 0, 0);background-color: transparent;">その他ご質問</span></label></div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center col-sm-8 col-md-9 col-lg-10"><textarea class="form-control form-control form-input-1" style="width: 100%;" name="applicant_question"></textarea></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Paragraph</p>
                        <div style="position: relative;">
                            <p class="font-size-16 font-type-meiryo" style="display: inline;"> 上記内容に同意する</p>
                            <div class="text-center justify-content-center align-items-center" id="checkbox" style="display: inline-block;padding-left: 16px;padding-bottom: 0;" type="checkbox"><input class="align-items-center" type="checkbox" id="chboxSend" style="width: 20px;height: 20px;" name="is_agreed"></div>
                        </div>
                    </div>
                </div>
                <div class="row d-sm-flex justify-content-sm-center">
                    <div class="col text-center col-xs-11">
                        <input type="hidden" id="applicant_id" value="<?php echo $response['applicant_info_id'];?>">
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
                    <button type="button" class="btn btn-primary">OK</button>
                  </div>
               </div>
            </div>
        </div>
    </main>
    <footer class="text-center text-center bg-footer-gray footer-menu">
        <div class="container text-muted container text-muted pt-5 pt-xl-5 overflow-hidden">
            <div class="row">
                <div class="col col-12 col-md-12 col-xl-12">
                    <p class="text-center">DVMsどうぶつ医療センター横浜</p>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-md-4 col-xl-4 col-12 col-md-4 col-xl-4 text-left m-2">
                    <p style="color: #f18b20;">CONTACT</p>
                    <p>〒221-0844</p>
                    <p>神奈川県横浜市神奈川区沢渡</p>
                    <p>2-2　第二泉ビル　2F</p>
                    <p>TEL : 045-479-6999</p>
                </div>
                <div class="col-4 col-md-4 col-xl-4 col-12 col-md-4 col-xl-4 text-left m-2">
                    <p style="color: #f18b20;">受付時間</p>
                    <p>09：00－18：00</p>
                </div>
                <div class="col-4 col-md-4 col-xl-4 col-12 col-md-3 col-xl-3 m-2"><a class="underline-hover" href="https://yokohama-dvms.com/" target="_blank">
                        <p>コーポレートサイト</p>
                    </a></div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-center fs-6">Copyright © DVMs Recruit All Rights Reserved.</p>
                </div>
            </div>
        </div><button class="btn btn-primary btn_go_to_top" id="btn_go_to_top" type="button"><img class="img-fluid" src="../assets/img/top/TOP17.jpg" width="80px" height="80px"></button>
    </footer>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery-3.6.4.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="../assets/js/additional-methods.min.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/form_submit.js"></script>
</body>

</html>