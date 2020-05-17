<?php
/*
これは公開用のdr00nnew.phpの backendである
*/

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

$english_sirname = strip_tags( trimBothEndSpace( mb_substr( $_POST[ 'search_term' ], 0, 100 ) ) ); // 前後のspaceなど削除し、文字数を100文字に制限する
$english_sirname = strtolower( mb_convert_kana( $english_sirname, 'ash' ) ); // 半角英字小文字に変換する

$stmt = $pdo->prepare( "SELECT COUNT(*) AS `count`, `dr_tbl_id`, `english_sirname`, `english_firstname`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `hp_name_japanese`, `member_kind` FROM `role_tbls` INNER JOIN `doctor_tbls` ON `role_tbls`.`dr_tbl_id` = `doctor_tbls`.`id` WHERE `role_kind` <> '0' AND `year` = '2018' GROUP BY `role_tbls`.`dr_tbl_id` ORDER BY `count` DESC;" );
$stmt->bindValue( ":english_sirname", $english_sirname . '%', PDO::PARAM_STR );
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
$search_results .= '<th class="smf">追加</th>';
$search_results .= '<th class="smf">Sirname</th>';
$search_results .= '<th class="smf">姓</th>';
$search_results .= '<th class="smf sm">所属</th>';
$search_results .= '<th class="smf">email</th>';
$search_results .= '</tr>';
$search_results .= '</thead>';
$search_results .= '<tbody>';

$i = 1;

foreach ( $rows as $row ) {
	/*
		  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
		  */
	$search_results .= '<tr><td class="small_left_align">';
	$search_results .= '<form method="post" action="chair_mod_add02.php">';
	$search_results .= '<button type="hidden" class="btn btn-success" name="id" value="' . _Q($row['id']). '">';
	$search_results .= '<input type="hidden" name="sessionNo" value="'._Q($_SESSION['sessionNo']).'" />';
	$search_results .= '<input type="hidden" name="role_kind" value="'._Q($_SESSION['role_kind']).'" />';
	$search_results .= '<span class="glyphicon glyphicon-plus-sign"></span></button></form></td>';
	$search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'english_sirname' ] ) ) . ' ' . _Q( trimBothEndSpace( $row[ 'english_firstname' ] ) ) . '</td>';
	$search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'kanji_sirname' ] ) ) . ' ' . _Q( trimBothEndSpace( $row[ 'kanji_firstname' ] ) ) . '</td>';
	$search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'hp_name_japanese' ] ) ) . '</td>';
	$search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'email' ] ) ) . '</td>';
	$search_results .= '</tr>';
	$i++;
}
if ( count( $rows ) === 0 ) {
	// この場合候補のメルアドは登録されていない
	$search_results .= '<tr><td colspan="4" class="small_left_align">この方は Facultyとして登録されていません</td></tr>';
	$search_results .= '</tbody>';
	$search_results .= '</table>';
	$search_results .= '<form method="post" action="../doctor_registration/dr01new.php">';
	$search_results .= '<button type="submit" class="btn btn-danger" name="email" value="' . _Q( $email ) . '">';
	$search_results .= '新たに Facultyとして登録します</button></form>';
} else {
	$search_results .= '</tbody>';
	$search_results .= '</table>';
	$search_results .= '<a href="../../../../index.php">';// ここで直接 BASIC認証領域に戻らせようとすると、Server Errorとなるのでトップページに戻す
	$search_results .= '<button class="btn-success">問題多いのでTop Pageに戻りリセットします</button>';
	$search_results .= '</a>';
	$search_results .= '<form method="post" action="../doctor_registration/dr01new.php">';
	$search_results .= '<button type="submit" class="btn btn-danger" name="email" value="' . _Q( $email ) . '">';
	$search_results .= 'この中には該当者が見つからないので、新たに Facultyとして新規登録します</button>';
}

echo $search_results;
exit;

?>