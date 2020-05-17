<?php
/*
この utility routineは　時々走らせることにより、登録されている faculty membersより
何らかの rolesかせ割り振られている者のみ選び出し TABLE doctor_tblsの中の
on2019フラグを1にセットするものである
*/
session_start();
session_regenerate_id( true );
require_once( '../utilities/config.php' );
require_once( '../utilities/lib.php' );
charSetUTF8();
//header('Location: ../25th/index_basic.php');	//何故かこれでコピーページに飛ばさないと javascriptや cssが働かない
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt = $pdo->prepare( "UPDATE `doctor_tbls` SET `on2019` = '0' WHERE `1` = `1`;" );
$stmt->execute(); // まず全てのマーカーをクリアする

$stmt = $pdo->prepare( "SELECT * FROM `role_tbls` WHERE `year` = :year;" );
$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
$stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

?>



<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="file:///Macintosh HD/Users/transradial/サイト/favicon.ico">
	<title>鎌倉ライブ2019</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap-3.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../25th/2018top_main.css">

</head>

<body>
	<div class="container">
		<div class="row col-md-10 text-center">
			<div style="font: 12px bold; padding: 1px; color: red;">
				<?php
				foreach ( $rows as $row ) {
					echo "doctor ID:" . $row[ 'dr_tbl_id' ] . "処理済み　";
					$stmt = $pdo->prepare( "UPDATE `doctor_tbls` SET `on2010` = '1' WHERE `id` = :id;" );
					$stmt->bindValue( ":id", $row[ 'dr_tbl_id' ], PDO::PARAM_INT );
					$stmt->execute();
				}

				echo "  Done!";
				?>
			</div><br>
			<button class="btn btn-lg btn-primary" onClick="location.href='index-mod.php'">戻る</button>

			<footer>
				<p>&copy; 2013 - 2019 by NPO International TRI Network & KAMAKURA LIVE</p>
			</footer>
		</div>
	</div>

	<script src="../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script>

	<script src="../js/jquery-2.2.4.min.js"></script>
	<!--  jqueryは二度呼びしないとdropdown menuが作動しない!! -->
	<script src="../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
	<script src="../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../25th/index2018.js"></script>
</body>

</html>