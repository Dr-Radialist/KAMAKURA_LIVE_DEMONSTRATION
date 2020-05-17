<?php
session_start();
session_regenerate_id( true );
require_once( '../../utilities/config.php' );
require_once( '../../utilities/lib.php' );
charSetUTF8();
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	//$pdo = new PDO( "mysql:host=localhost;dbname=kamakuralive_sessions;charset=utf8", "root", "root" );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt_dr = $pdo->prepare( "SELECT MAX(`changed`) FROM `doctor_tbls`;" );
$stmt_dr->execute();
$row_dr = $stmt_dr->fetch( PDO::FETCH_ASSOC );
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
$latest = mb_substr( $latest, 0, 10 );

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../favicon.ico">
	<title>鎌倉ライブ2017</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="oct.css">
</head>

<body>
	<div class="container">
		<p></p>
		<div class="top_head">
			<img src="abbott_logo.png" id="abbott_logo" width="100em" height="100em" alt="Abbott"><span class="top_line">&nbsp;OCT/FFR Training Course</span>
		</div>
		<div class="second_head">
			<p>
				<span class="second_line">&nbsp;&nbsp;&nbsp;共催：アボット バスキュラー ジャパン株式会社<br>
				&nbsp;&nbsp;&nbsp;定員: 1コース定員 20名 事前申込制 登録料無料　但し、鎌倉ライブに事前登録必要)</span>
			</p>
			<p>
			</p>
		</div>
		<p></p>
		<div class="oct-description">

			<p>冠動脈イメージングはPCIの予後を改善することが明らかとなっています。これまでイメージングと言えば、IVUSが主体でしたが、より解像度に優れ、また石灰化病変検出にも優れた OCTが注目されています。特に今後冠動脈石灰化病変に対する新たな治療の開始にあたっては、OCTによる冠動脈評価が必須となります。また、FFRにより虚血をきちんと評価することも、PCIの予後を改善することが示されています。FFRは概念的には理解し易いと思いますが、実践するにはそれなりの Tipsが必要です。</p>
			<p>鎌倉ライブ 2017の会期中に、実践的で体験的な OCTおよび FFRのトレーニングコースを開催させて頂きます。</p>
			<p>対象はこれから OCT/FFRを開始しようとされる医師・コメディカルの方々、あるいはもっと深く OCT/FFRについて勉強しようと考えておられる医師・コメディカルの方々です。</p>
			<p>ご参加頂くためには、鎌倉ライブHome Pageより事前登録して頂く必要があります。事前登録は、通常の参加費よりもお得ですし、OCT/FFRトレーニングコースに参加するための追加費用はございません。参加可能定員は少人数ですので、お早めにご登録下さい。</p>
			<p>3つ全てのコースにご参加頂く必要はありません。皆様方のご都合に併せ選択して頂けます。</p>
		</div>

		<div class="oct-description">
			<p></p>
			<a class="btn btn-success btn-sm" role="button" href="https://jp.surveymonkey.com/r/TD86X5H"><span class="button-signify">「Aコース：FFRコース　12/9（土） 13:30-15:00」お申込み</span></a>
			<p></p>
			<a class="btn btn-danger btn-sm" role="button" href="https://jp.surveymonkey.com/r/NNNZQR6"><span class="button-signify">「Bコース：FFRコース 12/10（日） 10:00-11:30」お申込み</span></a>
			<p></p>
			<a class="btn btn-warning btn-sm" role="button" href="https://jp.surveymonkey.com/r/NFG276T"><span class="button-signify">「Cコース：OCTコース 12/10（日） 13:00-14:30」お申込み</span></a>
			<p></p>
		</div>
		<div>
			<p>FFRコース (A、Ｂコース） 講師：メディカル 対象：メディカル/コメディカル Aコース、Bコース共に、機能的な評価法であるFFRの基礎と実臨床における有用性を学ぶことが出来るコースです。FFRの概念から正しい測定方法のコツやピットフォール、FFRによる虚血評価が有用だった症例などを経験豊富な講師に分かり易く解説して頂きます。
				<br><br> OCTコース(Cコース） 講師：メディカル 対象：メディカル/コメディカル OCTのエビデンスや実臨床における様々な症例におけるOCTの有用性を学ぶことが出来るコースです。 アンジオ同期機能や3D-OCT機能の有用性と、PCI治療おいてOCTにより得られた情報をどの様に治療戦略に活かすかを症例提示や最新の論文紹介等を交えて経験豊富な講師に解説して頂きます。
			</p>
		</div>


		<footer>
			<p>&copy; 2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>

	<script src="../../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script>

	<!--<script src="../../js/jquery-2.2.4.min.js"></script>-->
	<!--  jqueryは二度呼びしないとdropdown menuが作動しない!! -->
	<script src="../../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
</body>

</html>