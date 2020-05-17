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
$stmt_session = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls2018`;" );
$stmt_session->execute();
$row_session = $stmt_session->fetch( PDO::FETCH_ASSOC );
$stmt_role = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`;" );
$stmt_role->execute();
$row_role = $stmt_role->fetch( PDO::FETCH_ASSOC );
$latest = max( $row_dr[ 'MAX(`changed`)' ], $row_session[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
$latest = mb_substr( $latest, 0, 10 );

$stmt_oct = $pdo->prepare("SELECT * FROM `doctor_tbls` INNER JOIN `role_tbls` ON `doctor_tbls`.`id` = `role_tbls`.`dr_tbl_id` WHERE `role_tbls`.`class` = 'oct' AND `role_tbls`.`year` = '2018' ORDER BY `role_tbls`.`sessionNo`;");
$stmt_oct->execute();
$oct_rows = $stmt_oct->fetchAll(PDO::FETCH_ASSOC);

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
	<title>鎌倉ライブ2018</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap-3.3.6/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="oct.css">
	<style>
		.flex {
			display: flex;
			flex-wrap: wrap;
		}
	</style>
	<style>
		li span {
			font-weight: bold;
			color: red;
		}
	</style>
	<style>
		.inline-form {
			display: inline;
		}
		
		.btn-name {
			border: 0.1em dashed white;
			color: blue;
			background-color: white;
			border-radius: 0.5em;
			margin-right: 0.2em;
		}
		
		.btn-name:hover {
			background-color: red;
			font-weight: bold;
			color: yellow;
			border: 0.1cm solid black;
		}
	</style>
</head>

<body>
	<!-- このページは Safariのバグのため崩れる -->
	<div class="container">
		<div class="row flex">
			<div class="col-sm-12">
				<br>
				<div class="top_head">
					<img src="abbott_logo.png" id="abbott_logo" width="100em" height="100em" alt="Abbott"><span class="top_line">&nbsp;OCT/FFR Training Course</span>
				</div>
				<div class="second_head">
					<p style="padding:1em;">
						<span class="second_line">&nbsp;&nbsp;&nbsp;共催：アボット バスキュラー ジャパン株式会社<br>
				&nbsp;&nbsp;&nbsp;定員: 1コース定員 20名 事前申込制 登録料無料 但し、鎌倉ライブに事前登録必要<br></span>
					</p>
				</div>
				<p></p>
				<div class="oct-description">
					<p style="color:#888;">冠動脈イメージングはPCIの予後を改善することが明らかとなっています。これまでイメージングと言えば、IVUSが主体でしたが、より解像度に優れ、また石灰化病変検出にも優れた OCTが注目されています。特に今後冠動脈石灰化病変に対する新たな治療の開始にあたっては、OCTによる冠動脈評価が必須となります。また、FFRにより虚血をきちんと評価することも、PCIの予後を改善することが示されています。FFRは概念的には理解し易いと思いますが、実践するにはそれなりの Tipsが必要です。<br>鎌倉ライブ 2017の会期中に、実践的で体験的な OCTおよび FFRのトレーニングコースを開催させて頂きます。<br>対象はこれから OCT/FFRを開始しようとされる医師・コメディカルの方々、あるいはもっと深く OCT/FFRについて勉強しようと考えておられる医師・コメディカルの方々です。<br>ご参加頂くためには、鎌倉ライブHome Pageより事前登録して頂く必要があります。事前登録は、通常の参加費よりもお得ですし、OCT/FFRトレーニングコースに参加するための追加費用はございません。参加可能定員は少人数ですので、お早めにご登録下さい。<br>3つ全てのコースにご参加頂く必要はありません。皆様方のご都合に併せ選択して頂けます。</p>

					<p></p>
					<div style="display: inline-flex;">
						<a class="btn btn-success btn-sm" role="button" href="https://jp.surveymonkey.com/r/TD86X5H">「Aコース：FFRコース　12/15（土） 13:30-15:00」お申込み</a>
						<div>　　　</div>
						<?php
					$dr = $oct_rows[0];
					$dr_btn = "";
					$dr_btn .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
					$dr_btn .= '<input type="hidden" name="dr_tbl_id" value="' . $dr[ 'id' ] . '">';
					$dr_btn .= '<button type="submit" class="btn-name">';
					$dr_btn .= _Q( $dr[ 'kanji_sirname' ] . ' ' . $dr[ 'kanji_firstname' ] );
					if ( $dr[ 'hp_name_japanese' ] != "" ) {
						$dr_btn .= ' (' . _Q( $dr[ 'hp_name_japanese' ] ) . ')';
					}
					$dr_btn .= '</button>';
					$dr_btn .= '</form>';
					?>
					講師: <?= $dr_btn; ?>
					</div>

					

					<p></p>
					<div style="display: inline-flex;">
						<a class="btn btn-danger btn-sm" role="button" href="https://jp.surveymonkey.com/r/NNNZQR6
">「Bコース：FFRコース 12/16（日） 10:00-11:30」お申込み</a>
						<div>　　　</div><?php
					$dr = $oct_rows[1];
					$dr_btn = "";
					$dr_btn .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
					$dr_btn .= '<input type="hidden" name="dr_tbl_id" value="' . $dr[ 'id' ] . '">';
					$dr_btn .= '<button type="submit" class="btn-name">';
					$dr_btn .= _Q( $dr[ 'kanji_sirname' ] . ' ' . $dr[ 'kanji_firstname' ] );
					if ( $dr[ 'hp_name_japanese' ] != "" ) {
						$dr_btn .= ' (' . _Q( $dr[ 'hp_name_japanese' ] ) . ')';
					}
					$dr_btn .= '</button>';
					$dr_btn .= '</form>';
					?>
					講師: <?= $dr_btn; ?>
					</div>
					<p></p>
					<div style="display: inline-flex;">
						<a class="btn btn-warning btn-sm" role="button" href="https://jp.surveymonkey.com/r/NFG276T
">「Cコース：OCTコース 12/16（日） 13:00-14:30」お申込み</a>
						<div>　　　</div><?php
					$dr = $oct_rows[2];
					$dr_btn = "";
					$dr_btn .= '<form class="inline-form" method="post" action="../each_dr_roles_list.php">';
					$dr_btn .= '<input type="hidden" name="dr_tbl_id" value="' . $dr[ 'id' ] . '">';
					$dr_btn .= '<button type="submit" class="btn-name">';
					$dr_btn .= _Q( $dr[ 'kanji_sirname' ] . ' ' . $dr[ 'kanji_firstname' ] );
					if ( $dr[ 'hp_name_japanese' ] != "" ) {
						$dr_btn .= ' (' . _Q( $dr[ 'hp_name_japanese' ] ) . ')';
					}
					$dr_btn .= '</button>';
					$dr_btn .= '</form>';
					?>
					講師: <?= $dr_btn; ?>
					</div><br><br>
					<p style="color:darkblue;font-size: 1.3em;">FFRコース(A、Ｂコース)&nbsp;&nbsp;&nbsp;講師：メディカル&nbsp;&nbsp;&nbsp;対象：メディカル/コメディカル
					</p>
					<p style="color:dodgerblue;">Aコース、Bコース共に、安定狭心症患者に対する保険算定基準の変更に伴い、注目度が増している機能的評価法であるFFRと新たな安静時指標となるRFRに関して、実臨床での有用性を学ぶことが出来るコースです。機能的評価（FFR & RFR）の概念から正しい測定方法のコツやピットフォール、機能的評価が有用だった症例などを経験豊富な講師に分かり易く解説して頂きます。</p>
					<p style="color:darkblue;font-size: 1.3em;">OCTコース(Cコース）&nbsp;&nbsp;&nbsp;講師：メディカル&nbsp;&nbsp;&nbsp;対象：メディカル/コメディカル
					</p>
					<p style="color: dodgerblue;">OCTのエビデンスや実臨床におけるOCTの様々な有用性を学ぶことが出来るコースです。OCTの画像解析やアンジオ同期機能、さらには3D解析機能などを日常臨床において如何に治療戦略に活用するのかを症例提示や最新の論文紹介等を交えて経験豊富な講師に解説して頂きます。</p>
				</div>
				<footer>
					<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
				</footer>
			</div>
		</div>
	</div>

	<script src="../../bootstrap/docs-assets/javascript/jquery-3.2.0.min.js"></script>

	<!--<script src="../../js/jquery-2.2.4.min.js"></script>-->
	<!--  jqueryは二度呼びしないとdropdown menuが作動しない!! -->
	<script src="../../bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
</body>

</html>