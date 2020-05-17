<?
// 申込書をmpdfで出力する
 
// mpdfライブラリ
include("mpdf60/mpdf.php");
$mpdf=new mPDF('ja', 'A4');
// utf8でエラーが起こらないようにする
$mpdf->ignore_invalid_utf8 = true;
// PDFをインポートして下敷きとして使うための設定
$mpdf->SetImportUse();
// 下敷きのPDFを読み込む pagecountにはページ数が入る
$pagecount = $mpdf->SetSourceFile("moushikomi.pdf");
// この場合は1ページしかないので1ページ目をテンプレートとして指定
$tplId = $mpdf->ImportPage(1);
$mpdf->SetPageTemplate($tplId);
 
// ページに値を埋め込む
$mpdf->WriteHTML('<div style="position:relative;"');
 
// 内容用のDIVテンプレート
$tempDiv = '<div style="width:430px;position:absolute;top:%spx;left:%spx;font-size:%s;white-space: nowrap;">%s</div>';
// 各項目のセット
$mpdf->WriteHTML(sprintf($tempDiv, 155, 220, '1.3rem', '2016年7月13日'));
$mpdf->WriteHTML(sprintf($tempDiv, 215, 220, '1.3rem', '山本尚子'));
$mpdf->WriteHTML(sprintf($tempDiv, 275, 220, '1.3rem', 'naoko@example.com'));
$mpdf->WriteHTML(sprintf($tempDiv, 335, 220, '1.3rem', '〒100-0011 東京都千代田区内幸町1-1-1　千代田ビル503'));
$mpdf->WriteHTML(sprintf($tempDiv, 470, 220, '1.3rem', '00-9999-6666'));
$mpdf->WriteHTML(sprintf($tempDiv, 530, 220, '1.3rem', 'WordPressのインストール<br />
ホームページ作成と公開'));
 
$mpdf->WriteHTML('</div>');
 
// PDFを出力
$mpdf->Output();