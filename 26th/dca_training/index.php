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
<link rel="stylesheet" type="text/css" href="../../bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="dca.css">
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
      <div class="top_head"><img src="nipro_logo.png" id="nipro_logo" height="60em" alt="Nipro" style="padding-top: 1em; padding-bottom: 1em; padding-left: 2em;"><span class="top_line">&nbsp;DCA Training Course</span></div>
      <div class="second_head">
        <ul style="padding:1em;">
          <ol>
            <li class="second_line">共催：ニプロ株式会社</li>
            <li class="second_line">定員 : 各コース定員 20名 事前申込制 登録料無料</li>
            <li class="second_line-red">ご参加には、鎌倉ライブHome Pageでの事前登録必要!</li>
            <li class="second_line">鎌倉ライブ事前登録により追加登録料不要</li>
          </ol>
        </ul>
      </div>
      <div class="oct-description">
        <p style="color:#888; line-height: 1.3;">方向性冠動脈粥腫切除術（Directional Coronary Atherectomy：DCA）は、ニプロDCA（ATHEROCUT<sup>Ⓡ</sup>）を用いたPCI治療戦略のひとつです。血管内部にできた粥腫（プラーク）を直接削り、体外に取り出すことで、分岐部におけるプラークシフトやカリーナシフトの防止や、良好なステント拡張及び正確なアポジションを導く等のメリットが挙げられます。またコンプレックスステンティングの回避につながるなど、若年者への治療や抗血小板薬二剤併用療法（DAPT）の期間短縮など PCI予後をも考慮した応用がなされています。その反面、DCA治療には、切除する方向を明確化するための画像解釈やデバイス操作を習熟していただく必要があります。そこで、この『鎌倉ライブ2019』会期中に『DCA基礎コース』を開催いたします。<br>
          DCA治療の適応病変、切除するプラークの分布を同定する IVUS Guide、治療成績などの基礎知識の講習と、ハンズオンにてDCA操作を体感いただきます。 </p>
        <div style="border:solid #07FA47 3px; padding-top: 4px; padding-left:3px; padding-right:3px; border-radius: 10px;">
          <p></p>
          <p style="color:darkgreen;font-size: 1.3em;line-height: 1.6em;"> 対象：メディカル/コメディカル </p>
          <ol style="color:dodgerblue;">
            <li>DCAオペレーターによる座学(30分）</li>
            <ul>
              <li>DCA適応病変や適応部位の解説 </li>
              <li>切削対象のプラーク分布の同定法の解説　</li>
              <ul>
                <li>Branch-Guide法</li>
                <li>IVUS-Guide法</li>
                <li>Lumen-Bias法</li>
              </ul>
            </ul>
            <li>ハンズオン(30分)
              <ul>
                <li>DCAカテーテル操作の基礎</li>
                <li>DCAカテーテル操作のTips</li>
              </ul>
          </ol>
          <div class="m-3"><a class="btn btn-success btn-sm ml-2" role="button" href="mailto: kamakura.nipro@gmail.com?subject=鎌倉ライブDCA Training Course午前の部申し込み&amp;body=** 鎌倉ライブDCA Training Course申し込み午前の部 **%0D%0A%0D%0Aご施設名:%0D%0A診療科名:%0D%0Aお名前:%0D%0Aメルアド:%0D%0A第26回鎌倉ライブ事前登録番号:%0D%0A">「DCA Training Course-A」<br>
            12/15（日）　10:00～11:00　お申し込み<br>
            講師：加藤 隆一 先生（東大和病院)</a> <a class="btn btn-danger btn-sm ml-2" role="button" href="mailto: kamakura.nipro@gmail.com?subject=鎌倉ライブDCA Training Course午後の部申し込み&amp;body=** 鎌倉ライブDCA Training Course申し込み午後の部 **%0D%0A%0D%0Aご施設名:%0D%0A診療科名:%0D%0Aお名前:%0D%0Aメルアド:%0D%0A第26回鎌倉ライブ事前登録番号:%0D%0A">「DCA Training Course-B」<br>
            12/15（日）　13:30～14:30　お申し込み<br>
            講師：小林 範弘 先生（済生会横浜市東部病院） </a></div>
        </div>
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
        <footer>
          <p class="text-secondary">&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
        </footer>
      </div>
    </div>
  </div>
</div>
<script src="../bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js"></script> 
<script src="../bootstrap-4.3.1-dist/js/popper.min.js"></script> 
<script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>
</html>