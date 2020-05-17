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

$email = strip_tags( trimBothEndSpace( mb_substr( $_POST[ 'search_term' ], 0, 100 ) ) ); // 前後のspaceなど削除し、文字数を100文字に制限する
$email = strtolower( mb_convert_kana( $email, 'ash' ) ); // 半角英字小文字に変換する

$stmt = $pdo->prepare( "SELECT * FROM `doctor_tbls` WHERE `email` LIKE :email ORDER BY `english_sirname` ASC;" );
$stmt->bindValue( ":email", $email . '%', PDO::PARAM_STR );
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
$search_results .= '<th class="smf sm">#</th>';
$search_results .= '<th class="smf">Sirname/Firstname</th>';
$search_results .= '<th class="smf">姓/名</th>';
$search_results .= '<th class="smf">email</th>';
$search_results .= '</tr>';
$search_results .= '</thead>';
$search_results .= '<tbody>';

$i = 1;

foreach ( $rows as $row ) {
  /*
  	  ここで <form></form>を <td></td>の間に挟まないとイベントが発生しない!!
  	  */
  //$search_results .= '<tr><td class="smf">';
  //$search_results .= _Q( $row[ 'id' ] ) . '</td>';
  $search_results .= '<td class="small_left_align">';
  $search_results .= '<form method="post" action="dr01.php">';
  $search_results .= '<input type="hidden" value=' . _Q( $row[ 'id' ] ) . ' name="id" />';
  $search_results .= '<input type="hidden" name="new_old" value="old" />';
  $search_results .= '<input type="submit" value="' . '修正します' . '" class="btn-sm" />';
  $search_results .= '</td></form>';
  $search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'english_sirname' ] ) ) . ' ' . _Q( trimBothEndSpace( $row[ 'english_firstname' ] ) ) . '</td>';
  $search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'kanji_sirname' ] ) ) . ' ' . _Q( trimBothEndSpace( $row[ 'kanji_firstname' ] ) ) . '</td>';
  $search_results .= '<td class="small_left_align">' . _Q( trimBothEndSpace( $row[ 'email' ] ) ) . '</td>';
  $search_results .= '</tr>';
  $i++;
}
if ( count( $rows ) === 0 ) {
  // この場合候補のメルアドは登録されていない
  $search_results .= '<tr><td colspan="4" class="small_left_align">このメルアドは未登録ですので新規登録します</td></tr>';
  $search_results .= '<tr><td colspane="4"><form method="post" action="dr01new.php">';
  $search_results .= '<button type="submit" class="btn btn-danger" name="email" value="' . _Q( $email ) . '">';
  $search_results .= '了解</button></form></td></tr>';
} else {
  $search_results .= '<tr><td colspan="4" class="small_left_align">このメルアドは登録済です</td></tr>';
  $search_results .= '<tr><td colspane="4"><a href="../../../../index.php">';
  // ここで直接 BASIC認証領域に戻らせようとすると、Server Errorとなるのでトップページに戻す
  $search_results .= '<button class="btn-success">了解</button>';
  $search_results .= '</a></td></tr>';
}
$search_results .= ' </tbody>';
$search_results .= '</table>';
echo $search_results;
exit;

?>