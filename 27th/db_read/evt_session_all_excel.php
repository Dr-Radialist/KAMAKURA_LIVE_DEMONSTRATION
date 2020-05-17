<?php
set_time_limit( 600 ); // 10 minutes
ini_set( 'memory_limit', '2048M' );
// Without the upper 2 lines, browser reply back HTTP Error: 500.
// Look at the following page:
// https://stackoverflow.com/questions/20567041/error-500-internal-server-error-php-script-write-to-csv

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

$class = "zagaku";
$this_year = "2019";
$now = date( 'YmdHis' );

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2019` WHERE `class` = '" . $class . "' AND `year` = '" . $this_year . "' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
  $infor = $stmt->errorInfo();
  exit( $infor[ 2 ] );
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


// ファイルをオープンして .csv書き込みに備える
$tmp_file_name = $now . 'zagaku_list.csv';
$fp = fopen( 'tmp/' . $tmp_file_name, 'w' );
$header = "Content-Type: text/plain";
stream_filter_prepend( $fp, 'convert.iconv.utf-8/cp932' );
fputcsv( $fp, $header );
$data_array = [];
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
<title>KAMAKURA LIVE</title>
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
<link rel="stylesheet" type="text/css" href="com_session_table.css">
</head>
<?php
$title_row = [
  '最終更新: ' . $latest
];
fputcsv( $fp, $title_row );

$title_row = [
  'ID',
  '日本語氏名',
  'カナ氏名',
  '日本語病院名',
  '職種',
  'English Hospital Name',
  'English Name',
  'email',
  '役割'
];
fputcsv( $fp, $title_row );
for ( $sessionNo = 0; $sessionNo < 13; $sessionNo++ ) {
  $data_array = [
    "講演番号; " . $sessionNo + 1,
    "開始; " . _Q( mb_substr( $rows[ $sessionNo ][ 'begin' ], 0, 5 ) ),
    "終了; " . date( "H:i", strtotime( $rows[ $sessionNo ][ 'begin' ] ) + $rows[ $sessionNo ][ 'duration' ] * 60 ),
    "講演タイトル; " . _Q( $rows[ $sessionNo ][ 'sessionTitle' ] )
  ];
  fputcsv( $fp, $data_array );
  print_r( $data_array );
  echo "<br>";

  for ( $role_kind = 0; $role_kind < 6; $role_kind++ ) {
    $sql = "SELECT `doctor_tbls`.`id` AS `dr_id`, concat(`kanji_sirname`, '　', `kanji_firstname`), concat(`kana_sirname`, '　', `kana_firstname`), SUBSTRING_INDEX(`hp_name_japanese`, '/', 1), SUBSTRING_INDEX(`hp_name_japanese`, '/', -1), `hp_name_english`, concat(`english_sirname`,' ', `english_firstname`), `email`, `role_kind` FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`sessionNo` = :sessionNo AND `role_tbls`.`role_kind` = :role_kind AND `role_tbls`.`class` = :class AND `role_tbls`.`year` = :year;";
    $stmt = $pdo->prepare( $sql );
    $stmt->bindValue( ":sessionNo", $sessionNo + 1, PDO::PARAM_INT );
    $stmt->bindValue( ":role_kind", $role_kind, PDO::PARAM_INT );
    $stmt->bindValue( ":class", $class, PDO::PARAM_STR );
    $stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
    $flag = $stmt->execute();
    if ( !$flag ) {
      $infor = $stmt->errorInfo();
      exit( $infor[ 2 ] );
    }
    $presentators = $stmt->fetchAll( PDO::FETCH_ASSOC );
    foreach ( $presentators as $presentator ) {
      print_r( $presentator );
      fputcsv( $fp, $presentator );
    }
    //echo "<br>";
  }
}
fclose( $fp );
//exit();
?>
<?php // document_dwnld02.php

//require_once('../utilities/config.php');
//require_once('../utilities/lib.php');
//session_start();
mb_language( "japanese" );
mb_internal_encoding( "UTF-8" );


//// 必要書類の送付	

//文書の取得と文書のエンコード
$doc1 = file_get_contents( 'tmp/' . $tmp_file_name );
$doc_encode64_001 = chunk_split( base64_encode( $doc1 ) );
$doc2 = file_get_contents( 'tmp/' . $tmp_file_name );
$doc_encode64_002 = chunk_split( base64_encode( $doc2 ) );


//ヘッダ情報
$headers = '';
//$sendto = "rie_iwamoto@kamakuraheart.org";
$sendto = "cto.expert@gmail.com";
$sender = "transradial@kamakuraheart.org";
$subject = "KAMAKURA Live 2019　ご請求書類の送付";

$headers .= "FROM: Dr_Radialist(KAMAKURA, JAPAN)<" . $sender . ">\r\n";
$headers .= "Sender: " . $sender . "\r\n";
$headers .= "Reply-To: " . $sender . "\r\n";
//$headers .= "Cc: rie_iwamoto@kamakuraheart.org\r\n";
//$headers .= "Cc: transradial@kamakuraheart.org\r\n";
//$headers .= "Cc: a-takahashi@wine.ocn.ne.jp\r\n";
//$headers .= "Cc: saito@shonankamakura.or.jp\r\n";
$headers .= "Bcc: transradial@kamakuraheart.org\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: multipart/related;boundary="1000000000"' . "\r\n";


$message = <<<END
--1000000000
Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n

添付ファイルは Excel-csv形式(comma-separated vlues format)です
普通にファイルをdouble clickして頂ければ Excelが立ち上がります
内容は 座学セッションの発表者リストです
このファイルを加工することにより　色々な目的に応用可能と思います。

齋藤　滋


--1000000000
Content-Type: application/vnd.ms-excel; name="come_presentators_list.csv"
Content-Transfer-Encoding: base64
Content-ID: <doc_id_001>

$doc_encode64_001
--1000000000


END;


//メール用にサブジェクトと本文をエンコード

$subject = mb_encode_mimeheader( $subject );
$message = mb_convert_encoding( $message, "JIS" );

mail( $sendto, $subject, $message, $headers, "-ftransradial@kamakuraheart.org" );

?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-11">
        <h3 class="text-center white"><strong>December 15<sup>th</sup> (Sunday) at Nisseki Hall</strong></h3>
        <h1 style="text-align: center; font-weight:bold; color:#B55303;">座学 12/14 (SAT)</h1>

        <span style="color:red; font-weight:bold; font-size:small;"><br>
          &nbsp;&nbsp;最終更新日時:&nbsp;
          <?= $latest ?>
</span>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>

</body>
</html>