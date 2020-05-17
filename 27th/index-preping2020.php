<?php
session_start();
session_regenerate_id( true );
require_once( '../utilities/config.php' );
require_once( '../utilities/lib.php' );
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
<link rel="shortcut icon" href="../favicon.ico">
<title>鎌倉ライブ2020</title>
<link rel="stylesheet" type="text/css" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="2020top_main.css">
<script src="https://kit.fontawesome.com/ea004a8b19.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container" id="j-introduction">
  <h6 class="title">2020年12月19/20日開催</h6>
  <h6 class="title">The 27<sup>th</sup> Kamakura Live Demonstration Course 2020</h6>
 
  <div class="row"> 
    
    <div class="container-fluid">
      <div class="container-fluid back-classic-blue border-danger rounded-lg">
        <h4 class="text-light" style="line-height: 1.6;"> 鎌倉ライブは年々進化していますが、2020年も大きく進化すべく、実行委員会の皆で力を併せて新しい構想を練っています。このホームページで随時具体化していきますので、ご注目を!</h3>
      </div>
    </div>
  </div>
     <a class="btn btn-danger btn-lg" role="button" href="../index.php">Top Pageに戻る</a>
  <footer>
    <p>&copy; 2013 - 2020 by NPO International TRI Network & KAMAKURA LIVE</p>
  </footer>
</div>

<script src="../bootstrap-4.3.1-dist/js/jquery-3.4.1.min.js"></script> 
<script src="../bootstrap-4.3.1-dist/js/popper.min.js"></script> 
<script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> 
<script src="../bootstrap/docs-assets/javascript/extension.js"></script> 
<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script> 
<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script> 
<script src="index2019.js"></script>
</body>
</html>