<?php
/* このプログラムは MySQLに読み込むために作成したものであり
on-lineで動かすものではありません
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

$stmt = $pdo->prepare( "INSERT INTO `doctor_tbls` (`english_sirname`, `english_firstname`, `is_male`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `email`, `hp_name_english`, `hp_name_japanese`, `member_kind`, `changed`) VALUES (:english_sirname, :english_firstname, :is_male, :kana_sirname, :kana_firstname, :kanji_sirname, :kanji_firstname, :email, :hp_name_english, :hp_name_japanese, :member_kind, :changed);" );

$fp = fopen( 'poster2018.csv', 'r' );

while ( !feof( $fp ) ) {
	$line = fgets( $fp );
	$line = preg_replace( '/\)/', '', $line );
	$line = preg_replace( '/　/', ' ', $line );
	//$row = preg_split('/[,\(,\s]/', $line);
	$row = preg_split( '/,/', $line ); // .csvの区切りは","である
	echo $row[ 0 ] . " : " . $row[ 1 ] . " : " . $row[ 2 ] . " : " . $row[ 3 ] . " : " . $row[ 4 ] . " : " . $row[ 5 ] . " : " . $row[ 6 ] . " : " . $row[ 7 ] . " : " . $row[ 8 ] . " : " . $row[ 9 ] . "<br>";

	$stmt_check = $pdo->prepare( "SELECT count(*) FROM `doctor_tbls` WHERE `email` = :email;" );
	$stmt_check->bindValue( ":email", $row[ 9 ], PDO::PARAM_STR );
	$stmt_check->execute();
	$email_same_count = $stmt_check->fetchColumn();
	echo "email same count = " . $email_same_count . "<br>";
	if ( $email_same_count == 0 ) {
		$stmt->bindValue( ":english_sirname", strtoupper( $row[ 0 ] ), PDO::PARAM_STR );
		$stmt->bindValue( ":english_firstname", strtoupper( $row[ 1 ] ), PDO::PARAM_STR );
		if ( $row[ 2 ] == 'M' ) {
			$sex = 1;
		} else {
			$sex = 0;
		}
		$stmt->bindValue( ":is_male", $sex, PDO::PARAM_INT );
		$stmt->bindValue( ":kana_sirname", mb_convert_kana( $row[ 3 ], 'h' ), PDO::PARAM_STR );
		$stmt->bindValue( ":kana_firstname", mb_convert_kana( $row[ 4 ], 'h' ), PDO::PARAM_STR );
		$stmt->bindValue( ":kanji_sirname", $row[ 5 ], PDO::PARAM_STR );
		$stmt->bindValue( ":kanji_firstname", $row[ 6 ], PDO::PARAM_STR );
		$stmt->bindValue( ":email", $row[ 9 ], PDO::PARAM_STR );
		$stmt->bindValue( ":hp_name_english", $row[ 7 ], PDO::PARAM_STR );
		$stmt->bindValue( ":hp_name_japanese", $row[ 8 ], PDO::PARAM_STR );
		$stmt->bindValue( ":member_kind", 5, PDO::PARAM_INT );
		$stmt->bindValue( ":changed", date( 'Y-m-d H:i:s' ), PDO::PARAM_STR );

		$flag = $stmt->execute();
		if ( !$flag ) {
			echo "<h2 style='color:red;'>Error</h2>";
			$infor = $stmt->errorInfo();
			print_r( $infor );
			exit( $infor[ 2 ] );
		}
	}
}

fclose( $fp );


?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

</head>

<body>

</body>
</html>