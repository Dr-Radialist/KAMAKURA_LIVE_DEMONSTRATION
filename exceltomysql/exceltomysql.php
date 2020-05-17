<?php

require '../vendor/autoload.php';

use PhpOffice\ PhpSpreadsheet\ Spreadsheet;
use PhpOffice\ PhpSpreadsheet\ Writer\ Xlsx as Writer;
use PhpOffice\ PhpSpreadsheet\ Reader\ Xlsx as Reader;
use PhpOffice\ PhpSpreadsheet\ Cell\ Coordinate;
/*
$spreadsheet = new Spreadsheet();

$spreadsheet->getProperties()
    ->setTitle('タイトル')
    ->setSubject('サブタイトル')
    ->setCreator('作成者')
    ->setCompany('会社名')
    ->setManager('管理者')
    ->setCategory('分類')
    ->setDescription('コメント')
    ->setKeywords('キーワード');

$writer = new Xlsx($spreadsheet);
$writer->save('test.xlsx');
*/
/*
$reader->setInputEncoding('SJIS');
$spreadsheet = $reader->load( "poster2018.csv" );



$sheet = $spreadsheet->getSheet( 0 );

// rowとcolのデータ領域を確認
$rowMax = $sheet->getHighestRow();
$colMaxStr = $sheet->getHighestColumn();
$colMax = Coordinate::columnIndexFromString( $colMaxStr );

// 1セルごとにテキストデータを取得
$sheetData = [];
for ( $r = 1; $r <= $rowMax; $r++ ) {
	for ( $c = 1; $c <= $colMax; $c++ ) {
		$cell = $sheet->getCellByColumnAndRow( $c, $r );
		$sheetData[ $r ][ $c ] = $cell->getValue();
		echo $sheatData[ $r ][ $c ];
	}
}
*/
$reader = new Reader();
//$reader->setInputEncoding('SJIS');
$spreadsheet = $reader->load( 'poster2018.xlsx' );
//$reader->setInputEncoding('SJIS');

$sheet = $spreadsheet->getActiveSheet();
foreach ( $sheet->getRowIterator() as $row ) {
	//var_dump( $sheet->getCell( "C" . $row->getRowIndex() )->getValue() );
	echo $sheet->getCell( "C" . $row->getRowIndex() )->getValue();
	//echo "<br>***************<br>";
}
echo "<br>***************<br>";
foreach ( $sheet->getColumnIterator() as $column ) {
	//var_dump( $sheet->getCell( $column->getColumnIndex() . "1" )->getValue() );
	echo $sheet->getCell( $column->getColumnIndex() . "3" )->getValue();
}
/*
//echo $sheet->getCell('A6')->getValue(); // =A4 + A5
//echo $sheet->getCell('A6')->getCalculatedValue(); // 15
//$name = $sheet->getCell('A1')->getValue();

$sheet->setCellValue('A6', '=A4 * A5');

$writer = new Writer($spreadsheet);
$writer->save('test.xlsx');

echo "名前 = ".$name."<br>";
*/
echo "End";