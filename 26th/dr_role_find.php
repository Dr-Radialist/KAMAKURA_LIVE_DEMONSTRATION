<?php
/*
これは公開用のdoctor role findingである
まずフロントエンドとして alphabetical nameにより候補を検索する
これにより候補doctorのリスト表示すれるので　それを選択すれば
role一覧出力する
*/

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
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//$latest = mb_substr( $latest, 0, 10 );


?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../favicon.ico">
	<title>KAMAKURA LIVE Faculty Registration</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="2019top.css">
	<link rel="stylesheet" type="text/css" href="db_read/tri_session_table.css">
</head>

<body>
	<div class="container">
		<div class="row col-md-12 text-center">
			<h3 class="text-center text-danger">Role Finding for Active Participants</h3>
			<span class="red_bold_sm">Last Updated:&nbsp;<?= $latest; ?></span>
			<div class="row col-md-12">
				<div class="form-group">
					<form id="searchform" method="post">
						<label for="search_term">Your Sirname in Alphabets</label>
						(アルファベット姓)
						<input type="text" class="form-control" id="search_term" name="search_term" placeholder="You put your sirname in alphabets to find your roles! (検索姓をアルファベット入力)"/>
						<button></button>
						<!-- <input type="submit" value="Search You" id="search_button" name="search_button" class="btn btn-primary"/> -->
					</form>
				</div>
				<div class="small">
					<div id="search_results"></div>
				</div>
			</div>
			<div class="col-sm-12">
				<!-- <p><a class="btn btn-danger" id="return" href="../index.php">Return</a></p> -->
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="index2016.js"></script>
	<script>
		$( document ).ready( function () {
			$( "#search_results" ).slideUp();
			$( "#search_term" ).keyup( function ( e ) {
				e.preventDefault();
				ajax_search();
			} );

			function ajax_search() {
				$( "#search_results" ).show();
				var search_val = $( "#search_term" ).val();
				$.post( "dr_role_find_backend.php", {
					search_term: search_val
				}, function ( data ) {
					if ( data.length > 0 ) {
						$( "#search_results" ).html( data );
					}
				} );
			}
		} );
	</script>
</body>

</html>