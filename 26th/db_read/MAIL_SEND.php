<?php // document_dwnld02.php

//require_once('../utilities/config.php');
//require_once('../utilities/lib.php');
//session_start();
mb_language( "japanese" );
mb_internal_encoding( "UTF-8" );


//// 必要書類の送付	

//文書の取得と文書のエンコード
$doc1 = file_get_contents( "come_presentators_list.csv" );
$doc_encode64_001 = chunk_split( base64_encode( $doc1 ) );
$doc2 = file_get_contents( "come_presentators_list.csv" );
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
$headers .= "Cc: rie_iwamoto@kamakuraheart.org\r\n";
$headers .= "Cc: transradial@kamakuraheart.org\r\n";
$headers .= "Cc: a-takahashi@wine.ocn.ne.jp\r\n";
$headers .= "Cc: saito@shonankamakura.or.jp\r\n";
$headers .= "Bcc: transradial@kamakuraheart.org\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: multipart/related;boundary="1000000000"' . "\r\n";


$message = <<<END
--1000000000
Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n

添付ファイルは Excel-csv形式(comma-separated vlues format)です
普通にファイルをdouble clickして頂ければ Excelが立ち上がります
内容は ComeComeセッションの発表者リストです
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
