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
		.radial-academy {
			padding: 2rem;
			font-size: 1.6rem;
			color: black;
			font-weight: bold;
			line-height: 2.8rem;
			background-color: #F9EBF9;
			border-radius: 2rem;
			border: solid 1rem #A406F5;
			margin-bottom: 1rem;
		}
		
		.battle-talk {
			padding: 2rem;
			font-size: 1.6rem;
			color: white;
			font-weight: bold;
			line-height: 2.8rem;
			background-color: #1F1F1F;
			border-radius: 2rem;
			border: solid red 1rem;
			margin-bottom: 1rem;
		}
		
		.luncheon-seminar {
			padding: 2rem;
			font-size: 1.6rem;
			color: yellow;
			font-weight: bold;
			line-height: 2.8rem;
			background-color:red;
			border-radius: 2rem;
			margin-bottom: 1rem;
			border: solid yellow 0.8em;
		}
		
		.oneshot-photo {
			padding: 2rem;
			font-size: 1.6rem;
			color: darkblue;
			font-weight: bold;
			line-height: 2.8rem;
			background-color: #8AF6CA;
			border-radius: 2rem;
			margin-bottom: 1rem;
		}
		
		.poster {
			padding: 2rem;
			font-size: 1.6rem;
			color: darkblue;
			font-weight: bold;
			line-height: 2.8rem;
			background-color: #6CDEF6;
			border-radius: 2rem;
			margin-bottom: 1rem;
		}
		
		.poster-final {
			padding: 2rem;
			font-size: 1.6rem;
			color: deepskyblue;
			font-weight: bold;
			line-height: 2.8rem;
			background-color: darkblue;
			border-radius: 2rem;
			margin-bottom: 1rem;
		}
		.pay {
			-webkit-animation: blink 1.0s ease-in-out infinite alternate;
			-moz-animation: blink 1.0s ease-in-out infinite alternate;
			animation: blink 1.0s ease-in-out infinite alternate;
			color: white;
			font-weight: bold;
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
</head>
<!-- <body onLoad="init();"> -->

<body id="back">
	<div class="container">
		<h2 class="text-center white">コメディカル・セッション 12/16 (SUN)</h2>
		<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:&nbsp;
<?= $latest ?>
</span>
		<div class="row">
			<div class="col-lg-11">
				<?php
				for ( $i = 1; $i < 3; $i++ ) {
					//$sessionNo = $i - 1;
					?>
				<!--ここから ラジアルアカデミー -->
				<div class="radial-academy">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>座長:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>講師:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-info btn-lg" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 3; $i < 6; $i++ ) {
					?>
				<!--ここから Battle Talk -->
				<div class="battle-talk">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>座長:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>講師:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-lg btn-warning" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 6; $i < 7; $i++ ) {
					?>
				<!--Luncheon Seminar -->
				<div class="luncheon-seminar pay">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>座長:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>講師:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-success" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 7; $i < 9; $i++ ) {
					?>
				<!--一枚の写真 -->
				<div class="oneshot-photo">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>座長:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>講師:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-success" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 9; $i < 10; $i++ ) {
					?>
				<!--ポスターセッション -->
				<div class="poster">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">みんなで語ろう:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>モデレーター:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>ポスター発表者:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-success" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 10; $i < 11; $i++ ) {
					?>
				<!--ここから ラジアルアカデミー -->
				<div class="radial-academy">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div>座長:
						<?= _Q(makeCommonSessionList($pdo, $i, 1, $class, $this_year)); ?>
					</div>
					<div>講師:
						<?= _Q(makeCommonSessionList($pdo, $i, 3, $class, $this_year)); ?>
					</div>
					<!--
					<div class="fleft">内容:
						<?=_Q($rows[$i]['description']); ?>
					</div>
					-->
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-success" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
				<?php
				for ( $i = 11; $i < 12; $i++ ) {
					?>
				<!--ここから ポスター審査結果 -->
				<div class="poster-final">
					<div class="fleft">&nbsp;
						<?= _Q(mb_substr($rows[$i]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$i]['begin']) +$rows[$i]['duration']*60); ?>
					</div>
					<div class="fright">分類:
						<?= _Q($rows[$i]['sessionTitle']); ?>
					</div>
					<div class="fclear">講演演題名:
						<?= _Q($rows[$i]['lectureTitle']); ?>
					</div>
					<div class="text-center text-white">ポスターセッション審査結果発表 : 遠山　愼一<br><br>❤♡♥　皆様方　今年もご苦労様でした　❤♡♥<br>安全に家路につき、そして良いクリスマスとお正月をお迎え下さい<br>❤♡♥　来年もお会いしましょう　❤♡♥
					</div>
					<div class="col-md-1"><br>
					</div>
					<form method="post" action="comedical_sessions.php">
						<button type="submit" class="btn btn-success" name="sessionNo" value="<?= $i; ?>">内容詳細</button>
					</form>
				</div>
				<?php
				}
				?>
			</div>
			<!--ここまで ポスター審査結果発表と adjourn-->

		</div>
		<hr>
		<footer>
			<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
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