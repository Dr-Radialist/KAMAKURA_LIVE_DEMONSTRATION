<?php
/*
これは公開用のdoctor role findingである
まずフロントエンドとして alphabetical nameにより候補を検索する
これにより候補doctorのリスト表示すれるので　それを選択すれば
role一覧出力する
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
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
//$latest = mb_substr( $latest, 0, 10 );

// Kiemenij先生の doctor_tbl_id = 46
// role_tbl_id = 400, 438, 456, 415, 428, 443, 562
// session_tbls_id = 

$sql = "SELECT DISTINCT `doctor_tbls`.`email`, `doctor_tbls`.`id` AS `dr_tbl_id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind` FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `doctor_tbls`.`on2018` = '1' ORDER BY `doctor_tbls`.`member_kind` ASC, `doctor_tbls`.`english_sirname` ASC;";

//$sql = "SELECT DISTINCT `dr_tbl_id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind`, COUNT(`dr_tbl_id`) AS `count` FROM `role_tbls` INNER JOIN `doctor_tbls` ON `role_tbls`.`dr_tbl_id` = `doctor_tbls`.`id` WHERE `on2018` = '1' GROUP BY `role_tbls`.`dr_tbl_id` ORDER BY `count` DESC;";

$stmt = $pdo->prepare( $sql );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

$stmt = $pdo->prepare( "SELECT * FROM `doctor_tbls` WHERE `id` = :id" );
$stmt->bindValue( ":id", $_POST[ 'dr_id' ], PDO::PARAM_INT );
$stmt->execute();
$row_dr = $stmt->fetch( PDO::FETCH_ASSOC );

$search_results = '';
$search_results .= '<table class="table table-striped">';
$search_results .= '<thead>';
$search_results .= '<tr>';
$search_results .= '<th class="smf sm">お役</th>';
//$search_results .= '<th class="smf sm">回数</th>';
$search_results .= '<th class="smf">NAME</th>';
$search_results .= '<th class="smf">なまえ</th>';
$search_results .= '<th class="smf">名前</th>';
$search_results .= '<th class="smf">所属</th>';
$search_results .= '<th class="smf">種別</th>';
$search_results .= '</tr>';
$search_results .= '</thead>';
$search_results .= '<tbody>';

$i = 1;
foreach ( $rows as $row ) {
	/*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */
	$search_results .= '<tr><td class="smf">';
	$search_results .= '<form method="post" action="../each_dr_roles_list.php"><button type="submit" class="btn btn-sm btn-success">';
	$search_results .= $i . '</button>';
	$search_results .= '<input type="hidden" name="dr_tbl_id" value="' . _Q( $row[ 'dr_tbl_id' ] ) . '">';
	$search_results .= '</form></td>';
	$search_results .= '<td class="small_left_align red">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'english_sirname' ] ) . ' ' . trimBothEndSpace( $row[ 'english_firstname' ] ) );
	$search_results .= '</td><td class="small_left_align">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'kana_sirname' ] ) . ' ' . trimBothEndSpace( $row[ 'kana_firstname' ] ) );
	$search_results .= '</td><td class="small_left_align red">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'kanji_sirname' ] ) . ' ' . trimBothEndSpace( $row[ 'kanji_firstname' ] ) );
	$search_results .= '</td><td class="small_left_align">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'hp_name_japanese' ] ) );
	$search_results .= '</td><td class="small_left_align">' . _Q( $member_kind[ $row[ 'member_kind' ] ] ) . '</td></tr>';

	$i++;
}

$search_results .= ' </tbody>';
$search_results .= '</table>';

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
	<title>KAMAKURA LIVE Faculty List</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="tri_session_table.css">
	<style>
		/* この指定 borderをすることにより select が大きな文字となる */
		
		select {
			border: 1px solid #eee;
			font-size: 1.0em;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row col-sm-12 text-center">
			<h1 class="text-center text-danger">Faculty List</h1>
			<form action="faculty_list_backend.php" method="post" class="form-inline">
				<h3 class="text-center text-danger">Sort by:&nbsp;

			<select id="sort_items"> 
				<option value='english'>Lastname</option>
				<option value='kana'>かな姓</option>
				<option value='kanji'>漢字姓</option>
				<option value='kind'>Type of Faculty</option>
			</select>
					</form>&nbsp;&nbsp;
			<span class="text-info">Last Updated:&nbsp;<?= $latest; ?></span>
								</h3>

				<div class="row">
					<div class="col-lg-11">
						<div class="small">
							<div id="dataarea">
								<?= $search_results ?>
							</div>
						</div>
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
		<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
		<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
		<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
		<script src="../index2016.js"></script>
		<script>
			// JavaScript Document

			$( document ).ready( function () {
				"use strict";
				$( "#sort_items" ).change( function () {
					$.post( "faculty_list_backend.php", {
						'sort-by-item': $( this ).val()
					}, function ( data ) {
						$( "#dataarea" ).html( data );
					} );
				} );

			} );
		</script>
	</div>
</body>

</html>