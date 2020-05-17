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

if ( isset( $_POST[ 'sort-by-item' ] ) && ( $_POST[ 'sort-by-item' ] === 'english' ) ) {
	$sql = "SELECT DISTINCT `doctor_tbls`.`id`, `doctor_tbls`.`email`, `doctor_tbls`.`english_sirname`, 
`doctor_tbls`.`english_firstname`, `doctor_tbls`.`kana_sirname`, `doctor_tbls`.`kana_firstname`, 
`doctor_tbls`.`kanji_sirname`, `doctor_tbls`.`kanji_firstname`, `doctor_tbls`.`member_kind`,
`doctor_tbls`.`hp_name_japanese` FROM `doctor_tbls` INNER JOIN `role_tbls` on `doctor_tbls`.`id` = 
`role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`year` = '2019' ORDER BY `english_sirname` ASC, `member_kind` ASC;";
} 

if ( isset( $_POST[ 'sort-by-item' ] ) && ( $_POST[ 'sort-by-item' ] === 'kana' ) ) {
	$sql = "SELECT DISTINCT `doctor_tbls`.`id`, `doctor_tbls`.`email`, `doctor_tbls`.`english_sirname`, 
`doctor_tbls`.`english_firstname`, `doctor_tbls`.`kana_sirname`, `doctor_tbls`.`kana_firstname`, 
`doctor_tbls`.`kanji_sirname`, `doctor_tbls`.`kanji_firstname`, `doctor_tbls`.`member_kind`,
`doctor_tbls`.`hp_name_japanese` FROM `doctor_tbls` INNER JOIN `role_tbls` on `doctor_tbls`.`id` = 
`role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`year` = '2019' ORDER BY `kana_sirname` ASC, `member_kind` ASC;";
} 

if ( isset( $_POST[ 'sort-by-item' ] ) && ( $_POST[ 'sort-by-item' ] === 'kanji' ) ) {
	$sql = "SELECT DISTINCT `doctor_tbls`.`id`, `doctor_tbls`.`email`, `doctor_tbls`.`english_sirname`, 
`doctor_tbls`.`english_firstname`, `doctor_tbls`.`kana_sirname`, `doctor_tbls`.`kana_firstname`, 
`doctor_tbls`.`kanji_sirname`, `doctor_tbls`.`kanji_firstname`, `doctor_tbls`.`member_kind`,
`doctor_tbls`.`hp_name_japanese` FROM `doctor_tbls` INNER JOIN `role_tbls` on `doctor_tbls`.`id` = 
`role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`year` = '2019' ORDER BY `kanji_sirname` ASC, `member_kind` ASC;";
} 

if ( isset( $_POST[ 'sort-by-item' ] ) && ( $_POST[ 'sort-by-item' ] === 'kind' ) ) {
	$sql = "SELECT DISTINCT `doctor_tbls`.`id`, `doctor_tbls`.`email`, `doctor_tbls`.`english_sirname`, 
`doctor_tbls`.`english_firstname`, `doctor_tbls`.`kana_sirname`, `doctor_tbls`.`kana_firstname`, 
`doctor_tbls`.`kanji_sirname`, `doctor_tbls`.`kanji_firstname`, `doctor_tbls`.`member_kind`,
`doctor_tbls`.`hp_name_japanese` FROM `doctor_tbls` INNER JOIN `role_tbls` on `doctor_tbls`.`id` = 
`role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`year` = '2019' ORDER BY `member_kind` ASC, `english_sirname` ASC;";
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
$search_results .= '<th class="smf sm">お役</th>';
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
	$search_results .= $i.'</button>';
	$search_results .= '<input type="hidden" name="dr_tbl_id" value="'._Q($row['id']).'">';
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

$search_results .= '</tbody>';
$search_results .= '</table>';
echo $search_results;
exit;