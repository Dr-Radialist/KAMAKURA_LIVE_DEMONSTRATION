<?php
session_start();
session_regenerate_id( true );
require_once( 'utilities/config.php' );
require_once( 'utilities/lib.php' );
charSetUTF8();

//接続
try {
  // MySQLサーバへ接続
  $pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
  // 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
  die( $e->getMessage() );
}

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2019`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//if ( $latest < '2019-12-17 07:00:00' )$latest = '2020-01-26 07:12:35';
//$latest = mb_substr( $latest, 0, 10 );

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="favicon.ico">
<title>鎌倉ライブ2019</title>
<link rel="stylesheet" type="text/css" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="26th/2019top_main.css">
<script src="https://kit.fontawesome.com/ea004a8b19.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container" id="j-introduction">
  <h6 class="title">2019年12月14/15日開催&nbsp;<span class="red_bold_sm"> Data更新:
    <?=$latest ?>
    </span> </h6>
  <h6 class="title">&nbsp;鎌倉ライブ <a class="btn btn-primary btn-sm" id="eng" role="button" style="color:white;fornt-weight:bold;">English</a> CVIT専門医認定医更新点数2点 </h6>
  <ul class="nav nav-pills">
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle btn-sm mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-question-circle"></i>&nbsp;鎌倉ライブ</button>
      <div class="dropdown-menu"> <a class="dropdown-item" href="26th/db_read/zagaku_all_read.php"><span style="background-color:blue;color:white;">&nbsp;KODOCU（蠱毒)インタベ座学&nbsp;</span></a> <a class="dropdown-item" href="26th/db_read/tri_session_all_readJ.php#day1"><span style="background-color:rgb(0, 171, 52);color:white;">&nbsp;TRIライブ一日目&nbsp;</span></a> <a class="dropdown-item" href="26th/2019pamphlets/2019Welcome_Party_Web.pdf"><span style="color:red;">Welcome Party</span></a> <a class="dropdown-item" href="26th/db_read/com_session_all_read_renewed.php"><span style="background-color:rgb(0, 165, 187);color:white;">&nbsp;コメディカル・セッション&nbsp;</span></a> <a class="dropdown-item" href="26th/db_read/tri_session_all_readJ.php#day2"><span style="background-color:rgb(255, 191, 0);color:whiter;">&nbsp;TRIライブ二日目&nbsp;</span></a> </div>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle btn-sm mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i></button>
      <div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item" href="26th/2019planning/introduction2019.html">Introduction</a> <a class="dropdown-item" href="26th/home_sub/index_programming.php">Programming</a><a class="dropdown-item" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a><a class="dropdown-item" href="http://www.yokohama-viamare.or.jp/access.html">はまぎんホール</a> <a class="dropdown-item" href="http://www.nybldg.jp/access/index.html">日石ホール</a> </div>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-danger dropdown-toggle btn-sm mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">探す</button>
      <div class="dropdown-menu dropdown-menu-right"> <!-- <a class="dropdown-item" href="https://conv.toptour.co.jp/shop/evt/kamakuralive2019/">前登録</a> --><a class="dropdown-item" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> <a class="dropdown-item" href="26th/comecome2019/KomeKome_general2019_09_04.pdf">コメコメ演題募集</a><a class="dropdown-item" href="TRC/Xian.html">City Wall in Xi'an</a> </div>
    </div>
    <div class="btn-group"> <a class="btn btn-success btn-sm mt-1 mr-1" role="button" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> </div>
  </ul>
  <div class="row">
    <div class="container-fluid">
      <div class="container-fluid back-coral-orange border-danger rounded-lg" style="background-color:#E97963">
        <p class="text-light"> 今年も毎年恒例の鎌倉ライブが開催され、成功裏に終了しました。ご参加ありがとうございました。医薬品等適正広告基準の解説及び留意事項等につきましては、鎌倉ライブデモンストレーション運営委員会では適正に遵守しながら本会を実施をしています。 <a href="planner_only/index-mod.php"><img src="26th/logo2019/white_left_transparent.png" width="40px" height="40px" style="padding-top:1px; float:right;"/></p>
        <ul style="list-style-type: none;">
          <li class="text-white mt-2"><a class="btn btn-success btn-sm" role="button" href="26th/db_read/tri_session_all_readJ.php#day1">TRI Live (14th - DEC)</a> &nbsp;<a class="btn btn-danger btn-sm" role="button" href="26th/2019pamphlets/2019Mini-LecturesV.pdf">Mini-Lectures</a>&nbsp; <a class="btn btn-warning btn-sm" role="button" href="26th/db_read/tri_session_all_readJ.php#day2">TRI Live (15th - DEC)</a> </li>
          <li class="text-light mt-2"><a class="btn btn-light btn-sm" role="button" href="26th/db_read/zagaku_all_read.php">KODOCU（蠱毒）(14日)</a> &nbsp;&nbsp; <a class="btn btn-danger btn-sm" role="button" href="26th/2019pamphlets/2019_12_04FinalProgram.pdf">最終プログラム</a> </li>
          <li class="text-light mt-2"><a class="btn btn-info btn-sm" role="button" href="26th/db_read/com_session_all_read_renewed.php">コメディカル・セッション (15日)</a>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" role="button" href="26th/db_read/faculty_list.php">登場人物一覧</a> <img src="26th/logo2019/left_brown.png" width="80px" height="80px" style="padding-top:1px; float:right;"/></li>
          </ul>
          <p class="text-light">Hands-on Seminar は当日参加も受付いたしまた！ Hands-on受付にてLiveの参加証をご提示ください。</p>
          <ul style="list-style-type: none;">
          <li class="text-light mt-2"><a class="btn btn-danger btn-sm" role="button" href="26th/oct_training/index.php">OCT/FFR hands-on (14日)</a>&nbsp;&nbsp;<a class="btn btn-danger btn-sm" role="button" href="26th/dca_training/index.php">DCA hands-on (15日)</a></li>
          <li class="text-light mt-2"><a class="btn btn-primary btn-sm" role="button" href="26th/comecome2019/2019ComeCome_Survey(ICT-SNS).pdf">コメコメSurvey</a>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" role="button" href="26th/2019pamphlets/2019_11_29comecome.pdf">コメコメpdf</a>
            <a class="btn btn-light btn-sm" role="button" href="http://www.yokohama-viamare.or.jp/access.html">会場1</a> <a class="btn btn-light btn-sm" role="button" href="http://www.nybldg.jp/access/index.html">会場2</a></li>
          <p><!--<img src="26th/logo2019/right_brown.jpg" width="36px" height="36px" class="right_float"/>--> </p>
          
        </ul>
        <p class="text-light">2019年の鎌倉ライブも、クリスマス・イルミネーションのとても美しい横浜ベイエリアで開催されました。奮ってのご参加ありがとうございました! </p>
      </div>
      <!-- <a class="btn btn-sm pay" role="button" href="https://conv.toptour.co.jp/shop/evt/kamakuralive2019/">前登録</a> --> <a class="btn btn-primary btn-sm" role="button" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> <a class="btn btn-success  btn-sm openMidokoro" role="button">今年の見どころ　見てね! &raquo;</a> <a class="btn btn-warning btn-sm" role="button" href="26th/2019pamphlets/2019Luncheons-V.pdf">Luncheon Sessions</a><a class="btn btn-danger btn-sm" role="button" href="26th/2019pamphlets/2019Welcome_Party_Web.pdf">Welcome Party</a> </div>
  </div>
  <footer>
    <p>&copy; 2013 - 2020 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
</div>
<div class="container" id="e-introduction">
  <h6 class="title">December 14<sup>th</sup> and 15<sup>th</sup>, 2019&nbsp;<span class="red_bold_sm">Updated on&nbsp;
    <?=$latest ?>
    </span> </h6>
  <h6 class="title">KAMAKURA Live 2019 <a class="btn btn-danger btn-sm" id="jp" role="button" style="color:white;fornt-weight:bold;">日本語</a></h6>
  <ul class="nav nav-pills">
    <div class="btn-group">
      <button type="button" class="btn btn-primary dropdown-toggle btn-sm mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-question-circle"></i>&nbsp;LIVE 2019</button>
      <div class="dropdown-menu"> <a class="dropdown-item" href="26th/db_read/zagaku_all_read.php"><span style="background-color:blue;color:white;">&nbsp;KODOCU（蠱毒) EVT&nbsp;</span></a> <a class="dropdown-item" href="26th/db_read/tri_session_all_readJ.php#day1"><span style="background-color:rgb(0, 171, 52);color:white;">&nbsp;TRI Live #1&nbsp;</span></a> <a class="dropdown-item" href="#"><span style="color:red;">Welcome Party</span></a> <a class="dropdown-item" href="26th/db_read/com_session_all_read_renewed.php"><span style="background-color:rgb(0, 165, 187);color:white;">&nbsp;Co-Medical&nbsp;</span></a> <a class="dropdown-item" href="26th/db_read/tri_session_all_readJ.php#day2"><span style="background-color:rgb(255, 191, 0);color:whiter;">&nbsp;TRI Live #2&nbsp;</span></a> </div>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle btn-sm mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i></button>
      <div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item" href="26th/2019planning/introduction2019.html">Introduction</a> <a class="dropdown-item" href="26th/home_sub/index_programming.php">Programming</a><a class="dropdown-item" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a><a class="dropdown-item" href="http://www.yokohama-viamare.or.jp/access.html">Hamagin Hall</a> <a class="dropdown-item" href="http://www.nybldg.jp/access/index.html">Nisseki Hall</a> </div>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-info dropdown-toggle btn-sm mt-1 mr-1 pay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pre-Reg</button>
      <div class="dropdown-menu dropdown-menu-right"> <a class="dropdown-item" href="https://conv.toptour.co.jp/shop/evt/kamakuralive2019/">Pre-Registration</a> <a class="dropdown-item" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> <a class="dropdown-item" href="26th/comecome2019/KomeKome_general2019_09_04.pdf">Application Form</a><a class="dropdown-item" href="TRC/Xian.html">City Wall in Xi'an</a> </div>
    </div>
    <div class="btn-group"> <a class="btn btn-success btn-sm mt-1 mr-1" role="button" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> </div>
  </ul>
  <div class="row">
    <div class="container-fluid">
      <div class="container-fluid back-coral-orange rounded-lg" style="background-color:#E97963">
        <p class="text-light"> We announce that we will have the 26<sup>th</sup> KAMAKURA Live. <a href="planner_only/index-mod.php"><img src="26th/logo2019/white_left_transparent.png" width="40px" height="40px" style="padding-top:1px; float:right;"/></p>
        <ul style="list-style-type: none;">
          <li class="text-white mt-2"><a class="btn btn-success btn-sm" role="button" href="26th/db_read/tri_session_all_readJ.php#day1">TRI Live (14<sup>th</sup>)</a> &nbsp;<a class="btn btn-danger btn-sm" role="button" href="#">Mini-Lectures</a>&nbsp; <a class="btn btn-warning btn-sm" role="button" href="26th/db_read/tri_session_all_readJ.php#day2">TRI Live (15<sup>th</sup>)</a> </li>
          <li class="text-light mt-2"><a class="btn btn-light btn-sm" role="button" href="26th/db_read/zagaku_all_read.php">KODOCU（蠱毒）(14<sup>th</sup>)</a> &nbsp;&nbsp; <a class="btn btn-danger btn-sm" role="button" href="26th/2019pamphlets/2019_12_04FinalProgram.pdf">Final Program</a> </li>
          <li class="text-light mt-2"><a class="btn btn-info btn-sm" role="button" href="26th/db_read/com_session_all_read_renewed.php">Co-Medical (15<sup>th</sup>)</a>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" role="button" href="26th/db_read/faculty_list.php">Who's who?</a><img src="26th/logo2019/left_brown.png" width="80px" height="80px" style="padding-top:1px; float:right;"/> </li>
          <li class="text-light mt-2"><a class="btn btn-danger btn-sm" role="button" href="26th/oct_training/index.php">OCT/FFR hands-on (14<sup>th</sup>)</a>
          <a class="btn btn-danger btn-sm" role="button" href="26th/dca_training/index.php">DCA hands-on (15<sup>th</sup>)</a></li>
          <!-- <p><img src="26th/logo2019/right_brown.jpg" width="36px" height="36px" class="right_float"/> </p>-->
    
        </ul>
        <p class="text-light">We have KAMAKURA Live in Yokohama Bay Area, which is beatifully illuminated around Christmas.</p>
      </div>
      <a class="btn btn-sm pay" role="button" href="https://conv.toptour.co.jp/shop/evt/kamakuralive2019/">Pre-Reg</a> <a class="btn btn-primary btn-sm" role="button" href="26th/dr_role_find.php"><i class="fas fa-search"></i>&nbsp;My Role</a> <a class="btn btn-success  btn-sm openMidokoro" role="button">What's Interesting?&raquo;</a> <a class="btn btn-warning btn-sm" role="button" href="26th/2019pamphlets/2019Luncheons-V.pdf">Luncheon Sessions</a><a class="btn btn-danger btn-sm" role="button" href="#">Welcome Party</a> </div>
  </div>
  <footer>
    <p>&copy; 2013 - 2020 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
</div>
<script src="bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js"></script> 
<script src="bootstrap-4.3.1-dist/js/popper.min.js"></script> 
<script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> 
<script src="bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="26th/index2019.js"></script>
</body>
</html>