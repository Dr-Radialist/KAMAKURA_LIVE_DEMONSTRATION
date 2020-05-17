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
</head>

<body>
<?php
// https://qiita.com/ikemonn/items/f2bc4f9f834c989084ff
    
$rows[ 0 ][ 0 ] = "00";
$rows[ 0 ][ 1 ] = "齋藤　滋";
$rows[ 0 ][ 2 ] = "齋藤　滋です";
$rows[ 1 ][ 0 ] = "10";
$rows[ 1 ][ 1 ] = "SAITO SHIGERU";
$rows[ 1 ][ 2 ] = "さいとう";

$header = "Content-Type: text/plain";
$fp = fopen( 'isample.csv', 'w' );
stream_filter_prepend( $fp, 'convert.iconv.utf-8/cp932' );
fputcsv( $fp, $header );
foreach ( $rows as $row ) {
  fputcsv( $fp, $row );
}
fclose( $fp );
?>
</body>
</html>