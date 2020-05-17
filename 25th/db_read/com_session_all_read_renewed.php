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
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018` WHERE `class` = 'com' AND `year` = '" . $this_year . "' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
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
//$latest = mb_substr( $latest, 0, 10 );

$class = 'com';

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
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="com_session_table.css">
	<style>
		#back {
			background: linear-gradient(to bottom, rgb(51, 54, 139), rgb(225, 150, 184));
		}
		
		@-webkit-keyframes blink {
			0% {
				opacity: 0.5;
			}
			100% {
				opacity: 1;
			}
		}
		
		@-moz-keyframes blink {
			0% {
				opacity: 0.5;
			}
			100% {
				opacity: 1;
			}
		}
		
		@keyframes blink {
			0% {
				opacity: 0.5;
			}
			100% {
				opacity: 1;
			}
		}
	</style>
	<style>
		li span {
			font-weight: bold;
			color:#040BBB;
		}
	</style>
	<style>
		.inline-form {
			display: inline;
		}
		
		.btn-name {
			border: 0.1em dashed white;
			color: red;
			background-color: white;
			border-radius: 0.5em;
			margin-right: 0.2em;
			font-weight: bold;
		}
		
		.btn-name:hover {
			background-color:red;
			font-weight: bold;
			color: white;
			border: 0.1cm solid blue;
		}
	</style>
</head>

<body id="back">
	<div class="container">
		<div class="row">
			<div class="col-lg-11">
				<h3 class="text-center white"><strong>December 16th (Sunday) at Nisseki Hall</strong></h3><img src="../Logo/face2018-BW.png" width="85" height="85" style="float:right;"/>
				<div style="width: 80%;margin-left: auto; margin-right: auto; background:radial-gradient(rgba(255,255,255,1), rgba(0, 0, 0, 0));padding-bottom:1em;">
					<h4 style="padding-top: 1em;text-align:center; font-weight:bold; color:#B55303;">Co-Medical TRI Session *コメ・コメ倶楽部 17</h4>
					<h1 style="text-align: center; font-weight:bold; color:#B55303;">コメディカル・セッション 12/16 (SUN)</h1>
				</div>
				<span style="color:red; font-weight:bold; font-size:small;"><br>&nbsp;&nbsp;最終更新日時:&nbsp;
<?= $latest ?><br><br></ve></span>

				<?php for ($sessionNo = 1; $sessionNo < 3; $sessionNo++) { ?>
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom:#444 solid 0.5em;border-radius:2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(70,164,221,1.00); border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(70,164,221,1.00); font-weight:bold;padding: 0.3em;"><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(70,164,221,1.00)">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					

					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>
				<?php } ?>

				<?php for ( $sessionNo = 3; $sessionNo < 6; $sessionNo++ ) { ?>
				<!--ここから Battle Talk -->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom: #444 solid 0.5em;border-radius:2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(212,45,38,1.00); border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(212,45,38,1.00); "><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(212,45,38,1.00);">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					





					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>

				<?php } ?>

				<?php $sessionNo = 6; ?>
				<!--Luncheon Seminar -->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom: #444 solid 0.5em;border-radius: 2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(154,192,67,1.00); border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(154,192,67,1.00); "><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(154,192,67,1.00);">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					

					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>

				<?php $sessionNo = 7; ?>
				<!--一枚の写真 -->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom: #444 solid 0.5em;border-radius: 2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(68,154,134,1.00);border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(68,154,134,1.00); "><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(68,154,134,1.00);">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					

					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>写真提示:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>

				<?php $sessionNo = 8; ?>
				<!--ポスターセッション -->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom: #444 solid 0.5em;border-radius: 2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(183, 40, 102,1.00); border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(183, 40, 102,1.00); "><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(183, 40, 102,1.00);">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					
					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>

				<?php $sessionNo = 10; ?>
				<!--ここから ラジアルアカデミー (3)-->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom:#444 solid 0.5em;border-radius: 2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(70,164,221,1.00);border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(70,164,221,1.00); font-weight:bold;padding: 0.3em;"><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(70,164,221,1.00)">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong>
						</h3>
					
					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>

				<?php $sessionNo = 11; ?>
				<!--ここから ポスター審査結果 -->
				<div class="panel panel-default" style="border-right:#444 solid 0.5em; border-bottom: #444 solid 0.5em;border-radius: 2em 2em 0 0;">
					<div class="panel-heading" style="background-color: rgba(183, 40, 102,1.00);border-radius:2em 2em 0 0;">
						<h2 class="white"><strong><span class="white" style="font-size: 0.6em;background-color: rgba(183, 40, 102,1.00); "><?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>&nbsp;-&nbsp;<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) +$rows[$sessionNo]['duration']*60); ?></span>&nbsp;<?= _Q($rows[$sessionNo]['sessionTitle']); ?></strong></h2>
					</div>
					<div class="panel-body">
						<h3 style="color: rgba(183, 40, 102,1.00);">
							<strong><?=_Q($rows[$sessionNo]['lectureTitle']); ?></strong></h3>
					

					</div>
					<div class="panel-footer" style="line-height: 1.2em;">
						<ul class="list-inline">
							<?php
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year ) != "" ) {
								echo "<li><span>&nbsp;座長:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 1, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year ) != "" ) {
								echo "<li><span>講師:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 3, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year ) != "" ) {
								echo "<li><span>発言:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 2, $class, $this_year );
								echo "</li>";
							}
							if ( makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year ) != "" ) {
								echo "<li><span>カテ室解説:&nbsp;</span>";
								echo makeCommonSessionListTRIJ2( $pdo, $sessionNo, 4, $class, $this_year );
								echo "</li>";
							}
							?>
						</ul>
						<p><strong>内容:&nbsp;
							<?=_Q($rows[$sessionNo]['description']); ?></strong>
						</p>
					</div>
				</div>
			</div>
			<!--ここまで ポスター審査結果発表と adjourn-->

		</div>
		<hr>
		<footer>
			<p class="white"><strong>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</strong></p>
		</footer>
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
	<script src="../index2016.js"></script>
</body>

</html>