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
require '../vendor/autoload.php';

use PhpOffice\ PhpSpreadsheet\ Spreadsheet;
use PhpOffice\ PhpSpreadsheet\ Writer\ Xlsx as Writer;
use PhpOffice\ PhpSpreadsheet\ Reader\ Xlsx as Reader;
use PhpOffice\ PhpSpreadsheet\ Cell\ Coordinate;

$reader = new Reader();
$spreadsheet = $reader->load( 'poster2018.xlsx' );
$sheet = $spreadsheet->getActiveSheet();

$lines = array(); // Columnを数字にした二次元配列

$row_counter = 0;
$column_counter = 0;
foreach ( $sheet->getRowIterator() as $row ) {
	$column_counter = 0; // columnのリセット
	foreach ( $sheet->getColumnIterator() as $column ) {
		$lines[ $row_counter ][ $column_counter ] = $sheet->getCell( $column->getColumnIndex() . $row->getRowIndex() )->getValue();
		// これで$linesという２次元配列に Excel dataが集積された
		// これからは $lines[n][m]のような二次元配列として扱うことが可能となる
		// これを行わないと Excelの行列表現様式である A1, B1, A2, B2, ・・・・のような表現となり扱いにくい
		$column_counter++;
	}
	$row_counter++;
}
$max_row = $row_counter;
$max_column = $column_counter;

array_shift( $lines ); // 最初の表題部分を二行削除する
array_shift( $lines );

$stmt_dr = $pdo->prepare( "INSERT INTO `doctor_tbls` (`english_sirname`, `english_firstname`, `is_male`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `email`, `hp_name_english`, `hp_name_japanese`, `member_kind`, `changed`) VALUES (:english_sirname, :english_firstname, :is_male, :kana_sirname, :kana_firstname, :kanji_sirname, :kanji_firstname, :email, :hp_name_english, :hp_name_japanese, :member_kind, :changed);" );
$stmt = $pdo->prepare( "SELECT COUNT(*) FROM `doctor_tbls` WHERE `email` = :email;" );

foreach ( $lines as $line ) {
	$stmt->bindValue( ":email", $line[ 12 ], PDO::PARAM_STR );
	$flag = $stmt->execute();
	if ( !$flag ) {
		echo "<h2 style='color:red;'>Error</h2>";
		$infor = $stmt->errorInfo();
		print_r( $infor );
		exit( $infor[ 2 ] );
	}
	$already_registered = $stmt->fetchColumn(); // 既に登録済のメルアドであれば、0ではない
	echo strtoupper( $line[ 1 ] ) . strtoupper( $line[ 2 ] ) . mb_convert_kana( $line[ 4 ], 'h' ) . $already_registered . "<br>";
	if ( intval($already_registered) === 0 ) {
		echo "入ったよ" . strtoupper( $line[ 1 ] ) . strtoupper( $line[ 2 ] ) . mb_convert_kana( $line[ 4 ], 'h' ) . "<br>";
		$stmt_dr->bindValue( ":english_sirname", strtoupper( $line[ 1 ] ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":english_firstname", strtoupper( $line[ 2 ] ), PDO::PARAM_STR );
		if ( $line[ 3 ] == 'M' ) {
			$sex = 1;
		} else {
			$sex = 0;
		}
		$stmt_dr->bindValue( ":is_male", $sex, PDO::PARAM_INT );
		$stmt_dr->bindValue( ":kana_sirname", mb_convert_kana( $line[ 4 ], 'h' ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":kana_firstname", mb_convert_kana( $line[ 5 ], 'h' ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":kanji_sirname", $line[ 6 ], PDO::PARAM_STR );
		$stmt_dr->bindValue( ":kanji_firstname", $line[ 7 ], PDO::PARAM_STR );
		$stmt_dr->bindValue( ":email", $line[ 12 ], PDO::PARAM_STR );
		$stmt_dr->bindValue( ":hp_name_english", $line[ 8 ], PDO::PARAM_STR );
		$stmt_dr->bindValue( ":hp_name_japanese", $line[ 9 ], PDO::PARAM_STR );
		$stmt_dr->bindValue( ":member_kind", 5, PDO::PARAM_INT );
		$stmt_dr->bindValue( ":changed", date( 'Y-m-d H:i:s' ), PDO::PARAM_STR );
		$flag = $stmt_dr->execute();
		if ( !$flag ) {
			echo "<h2 style='color:red;'>Error</h2>";
			$infor = $stmt_dr->errorInfo();
			print_r( $infor );
			exit( $infor[ 2 ] );
		}
	}
}

/*
exit;

for ( $rowNo = 2; $rowNo++; $rowNo < $max_row + 1 ) {
	$stmt = $pdo->prepare( "SELECT COUNT(*) FROM `doctor_tbls` WHERE `email` = :email;" );
	$stmt->bindValue( ":email", $line[ $rowNo ][ 12 ], PDO::PARAM_STR );
	$stmt->execute();
	$count_same_email = $stmt->fetchColumn();

	if ( $count_same_email < 1 ) { // 既に登録されているメルアドの場合には登録しない
		$stmt_dr = $pdo->prepare( "INSERT INTO `doctor_tbls` (`english_sirname`, `english_firstname`, `is_male`, `kana_sirname`, `kana_firstname`, `kanji_sirname`, `kanji_firstname`, `email`, `hp_name_english`, `hp_name_japanese`, `member_kind`, `changed`) VALUES (:english_sirname, :english_firstname, :is_male, :kana_sirname, :kana_firstname, :kanji_sirname, :kanji_firstname, :email, :hp_name_english, :hp_name_japanese, :member_kind, :changed);" );
		$stmt_dr->bindValue( ":english_sirname", strtoupper( mb_convert_encoding( $line[ $rowNo ][ 1 ], "utf-8", "sjis" ) ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":english_firstname", strtoupper( mb_convert_encoding( $line[ $rowNo ][ 2 ], "utf-8", "sjis" ) ), PDO::PARAM_STR );
		if ( $line[ 3 ] === 'M' ) {
			$sex = 1;
		} else {
			$sex = 0;
		}
		$stmt_dr->bindValue( ":is_male", $sex, PDO::PARAM_INT );
		$stmt_dr->bindValue( ":kana_sirname", mb_convert_kana( mb_convert_encoding( $line[ $rowNo ][ 4 ], "utf-8", "sjis" ), 'h' ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":kana_firstname", mb_convert_kana( mb_convert_encoding( $line[ $rowNo ][ 5 ], "utf-8", "sjis" ), 'h' ), PDO::PARAM_STR );

		$stmt_dr->bindValue( ":kanji_sirname", mb_convert_encoding( $line[ $rowNo ][ 6 ], "utf-8", "sjis" ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":kanji_firstname", mb_convert_encoding( $line[ $rowNo ][ 7 ], "utf-8", "sjis" ), PDO::PARAM_STR );

		$stmt_dr->bindValue( ":email", mb_convert_encoding( $line[ $rowNo ][ 12 ], "utf-8", "sjis" ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":hp_name_english", mb_convert_encoding( $line[ $rowNo ][ 8 ], "utf-8", "sjis" ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":hp_name_japanese", mb_convert_encoding( $line[ $rowNo ][ 9 ], "utf-8", "sjis" ), PDO::PARAM_STR );
		$stmt_dr->bindValue( ":member_kind", 5, PDO::PARAM_INT );

		$stmt_dr->bindValue( ":changed", date( 'Y-m-d H:i:s' ), PDO::PARAM_STR );

		$flag = $stmt_dr->execute();

		if ( !$flag ) {
			echo "<h2 style='color:red;'>Error</h2>";
			$infor = $stmt_dr->errorInfo();
			print_r( $infor );
			exit( $infor[ 2 ] );
		}

	}
}
*/
echo "End";