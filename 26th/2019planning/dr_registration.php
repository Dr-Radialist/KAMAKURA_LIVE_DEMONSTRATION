<?php
/*
これは非公開用Faculty Listデータベース維持プログラムである
*/

session_start();
session_regenerate_id( true );
require_once( '../../utilities/config.php' );
require_once( '../../utilities/lib.php' );
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
//$latest = mb_substr( $latest, 0, 10 );

$stmt = $pdo->prepare( "SELECT * FROM `doctor_tbls` WHERE '1' = '1' ORDER BY `english_sirname` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
  $infor = $stmt->errorInfo();
  exit( $infor[ 2 ] );
}
$data = '';
$i = 1;
foreach ( $rows as $row ) {
  $data .= '<tr><td class="small_left_align">';
  $data .= '<form method="post" action="db_entry/doctor_registration/dr01.php">';
  $data .= '<input type="hidden" value=' . _Q( $row[ 'id' ] ) . ' name="id" />';
  $data .= '<input type="hidden" name="new_old" value="old" />';
  $data .= '<button class="btn-sm btn btn-success" type="submit">' . '修正' . $i . '</button>';
  $data .= '</form></td>';
  $data .= '<td class="small_left_align">' . _Q( $row[ 'english_sirname' ] ) . ' ' . _Q( $row[ 'english_firstname' ] ) . '</td>';
  $data .= '<td class="small_left_align">' . _Q( mb_convert_kana( $row[ 'kana_sirname' ], 'KC' ) ) . ' ' . _Q( mb_convert_kana( $row[ 'kana_firstname' ], 'KC' ) ) . '</td>';
  $data .= '<td class="small_left_align">' . _Q( $row[ 'kanji_sirname' ] ) . ' ' . _Q( $row[ 'kanji_firstname' ] ) . '</td>';
  $data .= '<td class="small_left_align">' . _Q( $row[ 'hp_name_japanese' ] ) . '</td>';
  $data .= '<td class="small_left_align">';;
  if ( $row[ 'member_kind' ] == 1 )$data .= "NPO社員";
  if ( $row[ 'member_kind' ] == 2 )$data .= "NPO年次社員";
  if ( $row[ 'member_kind' ] == 3 )$data .= "海外招聘";
  if ( $row[ 'member_kind' ] == 4 )$data .= "国内招聘";
  if ( $row[ 'member_kind' ] == 5 )$data .= "親善参加";
  if ( $row[ 'member_kind' ] == 6 )$data .= "Sd Faculty";
  $data .= '<td class="small_left_align">' . _Q( $row[ 'nation' ] ) . '</td>';
  $data .= '</td>';
  $data .= '<td class="small_left_align">' . _Q( $row[ 'email' ] ) . '</td>';
  $data .= '</tr>';
  $i++;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../favicon.ico">
<title>KAMAKURA LIVE Participants' Registration</title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="../../bootstrap-4.3.1-dist/css/bootstrap.css">
<!-- Custom styles for this template --> 

<!--<link rel="stylesheet" type="text/css" href="../2016top.css">-->
<link rel="stylesheet" type="text/css" href="../db_read/tri_session_table.css">
<script src="https://kit.fontawesome.com/ea004a8b19.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
  <h3 class="text-center text-danger">Faculty新規登録/修正/確認/削除画面<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
    <?= $latest ?>
    </span></h3>
  <br>
  <div class="row">
    <div class="small">
      <div><a class="btn btn-danger btn-lg" href="../../planner_only/index-mod.php"><i class="fas fa-undo"></i>&nbsp;Top Pageに戻る</a> <a class="btn btn-success btn-lg" href="../2019planning/db_entry/doctor_registration/dr00new_name.php"><i class="fas fa-search"></i><i class="fas fa-search-plus"></i>&nbsp;医師/コメディカル検索・修正</a><a class="btn btn-primary btn-lg" href="../2019planning/db_entry/doctor_registration/dr00new.php"><i class="fas fa-male"></i><i class="fas fa-female"></i>&nbsp;医師/コメディカル新規登録・修正</a> </div>
      <br>
      <table class="table table-striped">
        <thead>
          <tr>
            <th class="smf">修正</th>
            <th class="text-center" colspan="3">氏名</th>
            <th class="text-center">病院名</th>
            <th class="smf"><button type="button" class="red_back" name="member_kind" id="member_kind" value="ASC" style="width:20px;text-align: center;"><span class="glyphicon glyphicon-resize-vertical"></span></button>
            </th>
            <th class="smf"><button type="button" class="red_back" name="nation" id="nation" value="ASC" style="width:20px;text-align: center;"><span class="glyphicon glyphicon-resize-vertical"></span></button>
            </th>
            <th class="smf">email</th>
          </tr>
        </thead>
        <tbody id="dataarea">
          <?= $data ?>
        </tbody>
      </table>
      <div><a class="btn btn-danger btn-lg" href="../../planner_only/index-mod.php"><i class="fas fa-undo"></i>&nbsp;Top Pageに戻る</a> <a class="btn btn-success btn-lg" href="../2019planning/db_entry/doctor_registration/dr00new_name.php"><i class="fas fa-search"></i><i class="fas fa-search-plus"></i>&nbsp;医師/コメディカル検索・修正</a><a class="btn btn-primary btn-lg" href="../2019planning/db_entry/doctor_registration/dr00new.php"><i class="fas fa-male"></i><i class="fas fa-female"></i>&nbsp;医師/コメディカル新規登録・修正</a> </div>
    </div>
  </div>
  <footer>
    <p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
</div>
<script src="../../bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js"></script> 
<script src="../../bootstrap-4.3.1-dist/js/popper.min.js"></script> 
<script src="../../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> 
<script src="../index2019.js"></script> 
<script src="dr_registration.js"></script>
</body>
</html>