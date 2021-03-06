﻿<?php
session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );
charSetUTF8();

//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}
$_SESSION[ 'sessionNo' ] = $_POST[ 'sessionNo' ];
$_SESSION[ 'role_kind' ] = $_POST[ 'role_kind' ];

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

$npo_syain = FALSE;
if ( isset( $_POST[ 'sort_item' ] ) && ( $_POST[ 'sort_item' ] === 'role-ascen' ) ) {
	$sql = "SELECT COUNT(*) AS `count`, `dr_tbl_id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind` FROM `role_tbls` INNER JOIN `doctor_tbls` ON `role_tbls`.`dr_tbl_id` = `doctor_tbls`.`id` WHERE `role_kind` <> '0' AND `year` = '2018' GROUP BY `role_tbls`.`dr_tbl_id` ORDER BY `member_kind` ASC, `count` ASC;";
} 

if ( isset( $_POST[ 'sort_item' ] ) && ( $_POST[ 'sort_item' ] === 'role-descend' ) ) {
	$sql = "SELECT COUNT(*) AS `count`, `dr_tbl_id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind` FROM `role_tbls` INNER JOIN `doctor_tbls` ON `role_tbls`.`dr_tbl_id` = `doctor_tbls`.`id` WHERE `role_kind` <> '0' AND `year` = '2018' GROUP BY `role_tbls`.`dr_tbl_id` ORDER BY `member_kind` ASC, `count` DESC;";
} 

if ( isset( $_POST[ 'sort_item' ] ) && ( $_POST[ 'sort_item' ] === 'role-nothing' ) ) {
	$sql = "SELECT `doctor_tbls`.`id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind` FROM `doctor_tbls` WHERE `member_kind` = '1' AND `doctor_tbls`.`id` NOT IN (SELECT DISTINCT `role_tbls`.`dr_tbl_id` FROM `role_tbls` WHERE `role_kind` <> '0' AND `year` = '2018') ORDER BY `english_sirname` ASC;";
	$npo_syain = TRUE;
} 

$stmt = $pdo->prepare( $sql );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$search_results = '';
$search_results .= '<table class="table table-striped">';
$search_results .= '<thead>';
$search_results .= '<tr>';
$search_results .= '<th class="smf sm">回数</th>';
$search_results .= '<th class="smf">NAME</th>';
$search_results .= '<th class="smf">名前</th>';
$search_results .= '<th class="smf">所属</th>';
$search_results .= '<th class="smf">種別</th>';
$search_results .= '</tr>';
$search_results .= '</thead>';
$search_results .= '<tbody>';

foreach ( $rows as $row ) {
	/*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */
	$search_results .= '<tr><td class="smf">';
	$search_results .= '<form method="post" action="chair_mod_add02-role.php"><button type="submit" class="btn btn-sm btn-success">';
	if ($npo_syain) {
		$search_results .= '0';
	} else {
		$search_results .= $row['count'];
	}
	$search_results .= '</button>';
	$search_results .= '<input type="hidden" name="dr_tbl_id" value="' . _Q( $row[ 'dr_tbl_id' ] ) . '">';
	$search_results .= '<input type="hidden" name="sessionNo" value="' . _Q( $_SESSION[ 'sessionNo' ] ) . '" />';
	$search_results .= '<input type="hidden" name="role_kind" value="' . _Q( $_SESSION[ 'role_kind' ] ) . '" />';
	$search_results .= '</form></td>';
	$search_results .= '<td class="small_left_align red">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'english_sirname' ] ) . ' ' . trimBothEndSpace( $row[ 'english_firstname' ] ) );
	$search_results .= '</td><td class="small_left_align red">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'kanji_sirname' ] ) . ' ' . trimBothEndSpace( $row[ 'kanji_firstname' ] ) );
	$search_results .= '</td><td class="small_left_align">';
	$search_results .= _Q( trimBothEndSpace( $row[ 'hp_name_japanese' ] ) );
	$search_results .= '</td><td class="small_left_align">' . _Q( $member_kind[ $row[ 'member_kind' ] ] ) . '</td></tr>';
}

$search_results .= '</tbody>';
$search_results .= '</table>';
echo $search_results;
exit;