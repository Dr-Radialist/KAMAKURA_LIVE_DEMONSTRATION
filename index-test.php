<?php
if ( isset( $_POST ) ) {
  echo $_POST[ 'val' ];
}
?>

<!DOCTYPE html >
<html lang="ja">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<style>
.inline-form {
    display: inline;
}
.btn-name {
    font-weight: bold;
    border: 0.1em solid black;
    color: blue;
    background-color: white;
    border-radius: 1em;
}
.btn-name:hover {
    background-color: red;
    color: yellow
}
</style>
<?php
/*
echo "begin<br>";
$val = array(
  array( "A", "B", "C", "E", ),
  array( "a", "b", "c", ),
);
print_r( $val );
*/

$view = "";
$list = array(
  array( '三石琴乃', '田中敦子', '榊原良子', '池田昌子', ),
  array( '髙橋孝治', '関俊彦', '田の中勇', ),
);
echo "<br>";
//print_r( $list );
foreach ( $list as $value ) {
  print_r( $value );
  $view .= implode( "\t", $value ) . "\r\n";
  //$view .= $value. "\r\n";
}
exit;

//// http://rider-dice.hatenablog.com/entry/2017/11/13/145652
$fp = fopen( 'hogehoge.csv', 'w' );
stream_filter_prepend( $fp, 'convert.iconv.utf-8/cp932' );
fopen( $fp, "w" );
foreach ( $data as $v ) {
  $line = "hoge,fuga,moge";
  fwrite( $fp, $line . "\n" );
}
fclose( $fp );
////
//$view1 = pack( 'C*', 0xFE, 0xFF );
//$str = mb_convert_encoding($str, "UTF-7", "EUC-JP");
//  $view2 = mb_convert_encoding( $view, "UTF-16LE", "UTF-8" ); 
// $view2 = mb_convert_encoding($str, "UTF-7", "EUC-JP"); 
$view1 = pack( 'C*', 0xFE, 0xFF ) . mb_convert_encoding( $view, "SJIS" );
echo "<br>";
echo "view = " . $view1;
echo "<br>";
print_r( $list );
//$fp = fopen( "koe.csv", 'w' );
file_put_contents( "koe.csv", $view1 );
//fputcsv( $fp, $list );
//fclose($fp);
?>
</head>

<body>
<?php
/*
$view = "";    
$list = array(
    array('三石琴乃', '田中敦子', '榊原良子', '池田昌子', ),
              array( '髙橋孝治', '関俊彦', '田の中勇', ),
); 
foreach ( $list as $value ) {     //配列の内容を「,」区切りで連結する     
  $view .= implode( "\t", $value ) . "\r\n";
} 
$view = pack( 'C*', 0xFE, 0xFF ) . mb_convert_encoding( $view, 'UTF-16LE', 'UTF-8' ); 
//「$view」を「koe.csv」ファイルに書き出しする
file_put_contents( "koe.csv", $view );
*/
?>
</body>
</html>