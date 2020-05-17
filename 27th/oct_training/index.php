<?php
session_start();
session_regenerate_id( true );
require_once( '../../utilities/config.php' );
require_once( '../../utilities/lib.php' );
charSetUTF8();
//接続
try {
  // MySQLサーバへ接続
  $pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
  //$pdo = new PDO( "mysql:host=localhost;dbname=kamakuralive_sessions;charset=utf8", "root", "root" );
  // 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
  die( $e->getMessage() );
}

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
$latest = mb_substr( $latest, 0, 10 );

$stmt_oct = $pdo->prepare( "SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`class` = 'oct' AND `role_tbls`.`year` = '2019' ORDER BY `role_tbls`.`sessionNo`;" );
$stmt_oct->execute();
$oct_rows = $stmt_oct->fetchAll( PDO::FETCH_ASSOC );

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../favicon.ico">
<title>鎌倉ライブ2019</title>
<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="oct.css">
<style>
.flex {
    display: flex;
    flex-wrap: wrap;
}
</style>
<style>
li span {
    font-weight: bold;
    color: red;
}
</style>
<style>
.inline-form {
    display: inline;
}
.btn-name {
    border: 0.1em dashed white;
    color: blue;
    background-color: white;
    border-radius: 0.5em;
    margin-right: 0.2em;
}
.btn-name:hover {
    background-color: red;
    font-weight: bold;
    color: yellow;
    border: 0.1cm solid black;
}
</style>
</head>

<body>
<!-- このページは Safariのバグのため崩れる -->
<div class="container">
  <div class="row">
    <div class="col-sm-12"> <br>
      <div class="top_head"> <img src="abbott_logo.png" id="abbott_logo" height="100em" alt="Abbott"><span class="top_line">&nbsp;OCT &amp; FFR Basic Training Courses</span></div>
      <div class="second_head">
        <p style="padding:1em;"> <span class="second_line">&nbsp;&nbsp;&nbsp;共催：アボット バスキュラー ジャパン株式会社<br>
          &nbsp;&nbsp;&nbsp;定員 : 各コース定員 18 - 20名 事前申込制 登録料無料</span><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="second_line" style="color:darkblue;">(鎌倉ライブに事前登録必要)<br>
          </span> </p>
      </div>
      <div class="oct-description">
        <p style="color:#888; line-height: 1.3;">冠動脈イメージングはPCIの予後を改善することが明らかとなっています。これまでイメージングと言えば、IVUSが主体でしたが、より解像度に優れ、石灰化病変検出にも優れた OCTが広く用いられています。また、FFRにより虚血をきちんと評価することによりPCIの予後を改善することが証明されており、本邦ではFFRを用いた虚血証明がPCIに先立って広く行われるようになっています。<br>
          鎌倉ライブ 2019会期中に、実践的で体験的な OCTおよび FFRのトレーニングコースを開催させて頂きます。対象はこれから OCT/FFRを開始しようとされでおられる、あるいはもっと深く OCT/FFRについて勉強しようと考えておられる医師・コメディカルの方々です。ご参加頂くためには、鎌倉ライブHome Pageより事前登録して頂く必要があります。事前登録は、通常の参加費よりもお得ですし、OCT/FFRトレーニングコースに参加するための追加費用はございません。2つ全てのコースにご参加頂く必要はありません。皆様方のご都合に併せ選択して頂けますが、参加可能定員は少人数ですので、お早めにご登録下さい。 </p>
        <div style="border:solid #07FA47 3px; padding-top: 4px; padding-left:3px; padding-right:3px; border-radius: 10px;">
          <div style="display: inline-flex;"> <a class="btn btn-success" role="button" href="https://jp.surveymonkey.com/r/TS5GPZD">OCT Basic Training Course<br>
              12/14（土）10:00-11:30 お申込み</a>
            <div>　　　</div>
            <?php
            $dr = $oct_rows[ 0 ];
            $dr_btn = "";
            $dr_btn .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
            $dr_btn .= '<input type="hidden" name="dr_tbl_id" value="' . $dr[ 'id' ] . '">';
            $dr_btn .= '<button type="submit" class="btn-name">';
            $dr_btn .= _Q( $dr[ 'kanji_sirname' ] . ' ' . $dr[ 'kanji_firstname' ] );
            if ( $dr[ 'hp_name_japanese' ] != "" ) {
              $dr_btn .= ' (' . _Q( $dr[ 'hp_name_japanese' ] ) . ')';
            }
            $dr_btn .= '</button>';
            $dr_btn .= '</form>';
            ?>
            <?= $dr_btn; ?>
          </div>
          <p></p>
          <p></p>
          <p style="color:darkgreen;font-size: 1.3em;line-height: 1.6em;">講師 : 若林 公平 先生（昭和大学江東豊洲病院）<br>
            対象：メディカル/コメディカル </p>
          <p style="color:dodgerblue;">(A) Hands-On(40分間)では、実際にOCT機器を操作しながら撮像時の機器設定や、Tips & Tricksについて座学で学びます。そして、(B) 症例提示(50分間)では、Simulatorを用いて症例を用いながら i.OCT計測手順、ii.OCT画像所見に基づいた治療戦略立案とStent Expansion評価、iii.各ソフトウェア機能の紹介(AptView機能の解説)、iv. 講師による症例解説が行われます。　</p>
        </div>
        <p></p>
        <div style="border:solid red 3px; padding-top: 4px; padding-left:3px; padding-right:3px; border-radius: 10px;">
          <div style="display: inline-flex;"> <a class="btn btn-danger" role="button" href="https://jp.surveymonkey.com/r/TSGJ5BR">FFR Basic Training Course <br>12/14（土）13:30-15:00 お申込み</a>
            <div>　　　</div>
            <?php
            $dr = $oct_rows[ 1 ];
            $dr_btn = "";
            $dr_btn .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
            $dr_btn .= '<input type="hidden" name="dr_tbl_id" value="' . $dr[ 'id' ] . '">';
            $dr_btn .= '<button type="submit" class="btn-name">';
            $dr_btn .= _Q( $dr[ 'kanji_sirname' ] . ' ' . $dr[ 'kanji_firstname' ] );
            if ( $dr[ 'hp_name_japanese' ] != "" ) {
              $dr_btn .= ' (' . _Q( $dr[ 'hp_name_japanese' ] ) . ')';
            }
            $dr_btn .= '</button>';
            $dr_btn .= '</form>';
            ?>
            <?= $dr_btn; ?>
          </div>
          <p style="color:red;font-size: 1.3em;line-height: 1.6em;">講師 : 荻田 学 先生（順天堂大学医学部附属静岡病院）<br>
            対象：メディカル/コメディカル </p>
          <p style="color: dodgerblue;">(A) 座学(50分間)では、i.FFRの歴史、ii.FFRの概念とPressure-Flow関係、iii.最大充血の重要性、iv.安静時指標RFR、v.症例提示とFR-RFR乖離症例などについて学びます。そして、(B) Hands-On(40分間)では、i.拍動モデSimulatorを用いFFR計測、ii.Tandem Lesionに対する考え方と治療方針、iii.RFR pullbackとその評価について学ぶことができます。　 </p>
        </div>
      </div>
      <footer>
        <p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
      </footer>
    </div>
  </div>
</div>
<script src="../../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script> 

<!--<script src="../../js/jquery-2.2.4.min.js"></script>--> 
<!--  jqueryは二度呼びしないとdropdown menuが作動しない!! --> 
<script src="../../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
</body>
</html>