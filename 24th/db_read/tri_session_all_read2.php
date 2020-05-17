<!-- FlexBoxを使用したもの　未だテスト段階 -->

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

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls`WHERE `class` = 'tri' AND `year` = '2017' ORDER BY `sessionNo` ASC;" );
$flag = $stmt->execute();
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
if ( !$flag ) {
	$infor = $stmt->errorInfo();
	exit( $infor[ 2 ] );
}

$stmt = $pdo->prepare( "SELECT MAX(`changed`) FROM `session_tbls`;" );
$stmt->execute();
$row_come = $stmt->fetch( PDO::FETCH_ASSOC );

$stmt = $pdo->prepare( "SELECT MAX(`created`) FROM `role_tbls`" );
$stmt->execute();
$row_role = $stmt->fetch( PDO::FETCH_ASSOC );

$latest = $latest = max( $row_come[ 'MAX(`changed`)' ], $row_role[ 'MAX(`created`)' ] );
$class = 'tri';

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


	<style type="text/css">
		.main-box {
			border: 2px #866002 solid;
			margin-left: 2px;
			margin-right: 2px;
			font-weight: bold;
			font-size: 1.0em;
		}
		
		.main-nav {
			display: flex;
			justify-content: left;
			list-style: none;
		}
		
		.main-nav a {
			margin: 10px;
			border-radius: 5px;
			background: #60B99A;
			color: #fff;
			display: block;
			padding: 15px;
			text-decoration: none;
		}
		
		.main-nav .button-detail {
			background: #4584b1;
		}
		
		.main-box section {
			margin: 10px;
			border-radius: 5px;
			background: #F5F0CF;
			padding: 15px;
		}
		
		.main-box h1 {
			color: #E6AC27;
			font-size: 1.5rem;
		}
		
		.main-box p {
			margin-top: 10px;
		}
		
		ul.test {
			display: -webkit-flex;
			display: flex;
			justify-content: left;
			list-style: none;
		}
		
		ul.test a {
			margin: 1px;
			border: solid 1px blue;
			list-style: none;
			color: red;
			background: yellow;
			display: block;
		}
	</style>
</head>
<!-- <body onLoad="init();"> -->

<body>

	<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
	<div class="container" id="day1">
		<h1 class="text-center text-danger">KAMAKURA TRI (12/09 SAT)</h1>
		<div class="row">
			<div class="main-box">
				<ul class="test">
					<li><a>１番目の要素</a>
					</li>
					<li><a>２番目の要素</a>
					</li>
					<li><a>３番目の要素</a>
					</li>
				</ul>
				<nav>
					<ul class="main-nav">
						<li><a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>" class="button-detail">Detail</a>
						</li>
						<li><a href="#">DATE: December 09 Saturday</a>
						</li>
						<li><a href="#">TIME: <?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?></a>
						</li>
						<li><a href="#">Session Title: <?= _Q($rows[$sessionNo]['sessionTitle']); ?></a>
						</li>
						<li><a href="#">Menu 4</a>
						</li>
					</ul>
				</nav>
				<?php $sessionNo = 1; ?>

				<section class="col-1">
					<h1>Column 1</h1>
					<p>Lorem ipsum dolor sit amet...</p>
				</section>
				<section class="col-2">
					<h1>Column 2</h1>
					<p>Morbi non semper sapien...</p>
					<p>Integer vel pellentesque elit...</p>
				</section>
				<section class="col-3">
					<h1>Column 3</h1>
					<p>Integer commodo...</p>
				</section>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>


			<!-- 土曜日午前のセッション -->
			<?php $sessionNo = 1; ?>
			<div class="panel-group border-thick">
				<?php
				if ( mb_strpos( $rows[ $sessionNo ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}
				?>
				<!-- <div class="panel panel-info"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?= _Q($rows[$sessionNo]['sessionTitle']); ?>--
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<?php
			for ( $sessionNo = 2; $sessionNo < 5; $sessionNo++ ) {
				?>
			<div class="panel-group border-thick">
				<?php
				if ( mb_strpos( $rows[ $sessionNo ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}
				?>
				<!-- <div class="panel panel-info"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?= _Q($rows[$sessionNo]['sessionTitle']); ?>--
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>

		<!-- 土曜日の Luncheon Seminar -->
		<?php $sessionNo = 5; ?>
		<div class="panel-group border-luncheon">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- 土曜日午後のセッション -->
		<?php
		for ( $sessionNo = 6; $sessionNo < 12; $sessionNo++ ) {
			?>
		<div class="panel-group border-thick">
			<?php
			if ( mb_strpos( $rows[ $sessionNo ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
				echo '<div class="panel panel-primary">';
			} else {
				echo '<div class="panel panel-success">';
			}
			?>
			<!-- <div class="panel panel-success"> -->
			<div class="panel-heading">
				<ul class="list-inline">
					<li>
						<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
					</li>
					<li class="bold18">
						<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
					</li>
					<li class="bold18">
						&nbsp;&nbsp;
						<?= _Q($rows[$sessionNo]['sessionTitle']); ?>&nbsp;::&nbsp;
						<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
					</li>
				</ul>
			</div>
			<div class="panel-body">
				<ul class="list-inline">
					<li>Chair:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
					</li>
					<li>Speaker:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
					</li>
				</ul>
			</div>
			<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
				<div class="panel-footer">
					<ul class="list-inline">;
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
				</div>
				<div class="panel-footer">
					<ul class="list-inline">
						<li>Co-sponsors:
							<?= _Q($rows[$sessionNo]['cosponsor']); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<?php
		}
		?>
	</div>

	<!-- SnuffBox Approach -->
	<?php $sessionNo = 21; ?>
	<div class="panel-group border-luncheon">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<ul class="list-inline">
					<li>
						<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
					</li>
					<li class="bold18">
						<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
					</li>
					<li class="bold18">
						&nbsp;&nbsp;
						<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
						<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
					</li>
				</ul>
			</div>
			<div class="panel-body">
				<ul class="list-inline">
					<li>Chair:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
					</li>
					<li>Speaker:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
					</li>
				</ul>
			</div>
			<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
				<div class="panel-footer">
					<ul class="list-inline">
						<li>Content:
							<?= _Q($rows[$sessionNo]['description']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-footer">
					<ul class="list-inline">
						<li>Co-sponsors:
							<?= _Q($rows[$sessionNo]['cosponsor']); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<h1><br></h1>
	<hr>
	<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>
	<div class="container" id="day2">
		<h1 class="text-center text-primary">KAMAKURA TRI (12/10 SUN)</h1>
		<div class="row">

			<!-- 日曜日午前のセッション -->
			<?php
			for ( $sessionNo = 12; $sessionNo < 16; $sessionNo++ ) {
				?>
			<div class="panel-group border-thick">
				<?php
				if ( mb_strpos( $rows[ $sessionNo ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
					echo '<div class="panel panel-primary">';
				} else {
					echo '<div class="panel panel-info">';
				}
				?>
				<!-- <div class="panel panel-info"> -->
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?= _Q($rows[$sessionNo]['sessionTitle']); ?>--
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>


		<!-- 日曜日の Luncheon Seminar -->
		<?php $sessionNo = 16; ?>
		<div class="panel-group border-luncheon">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<ul class="list-inline">
						<li>
							<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
						</li>
						<li class="bold18">
							<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
						</li>
						<li class="bold18">
							&nbsp;&nbsp;
							<?=_Q($rows[$sessionNo]['sessionTitle']); ?>::&nbsp;
							<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li>Chair:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
						</li>
						<li>Speaker:
							<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
						</li>
					</ul>
				</div>
				<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<ul class="list-inline">
							<li>Co-sponsors:
								<?= _Q($rows[$sessionNo]['cosponsor']); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- 日曜日午後のセッション -->
		<?php
		for ( $sessionNo = 17; $sessionNo < 21; $sessionNo++ ) {
			?>
		<div class="panel-group border-thick">
			<?php
			if ( mb_strpos( $rows[ $sessionNo ][ 'sessionTitle' ], "裏ライブ", 0, "UTF-8" ) !== false ) {
				echo '<div class="panel panel-primary">';
			} else {
				echo '<div class="panel panel-success">';
			}
			?>
			<!-- <div class="panel panel-success"> -->
			<div class="panel-heading">
				<ul class="list-inline">
					<li>
						<a data-toggle="collapse" href="#<?= 'collapse'.$sessionNo ?>"><button type="submit" class="button-detail" >詳細</button></a>
					</li>
					<li class="bold18">
						<?= _Q(mb_substr($rows[$sessionNo]['begin'], 0, 5)); ?>
						-
						<?= date("H:i" , strtotime($rows[$sessionNo]['begin']) + $rows[$sessionNo]['duration']*60); ?>
					</li>
					<li class="bold18">
						&nbsp;&nbsp;
						<?= _Q($rows[$sessionNo]['sessionTitle']); ?>&nbsp;::&nbsp;
						<?= _Q($rows[$sessionNo]['lectureTitle']); ?>
					</li>
				</ul>
			</div>
			<div class="panel-body">
				<ul class="list-inline">
					<li>Chair:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 1, $class, $this_year)); ?>
					</li>
					<li>Speaker:
						<?= _Q(makeCommonSessionListTRI($pdo, $sessionNo, 3, $class, $this_year)); ?>
					</li>
				</ul>
			</div>
			<div id="collapse<?= $sessionNo; ?>" class="panel-collapse collapse">
				<div class="panel-footer">
					<ul class="list-inline">;
						<ul class="list-inline">
							<li>Content:
								<?= _Q($rows[$sessionNo]['description']); ?>
							</li>
						</ul>
				</div>
				<div class="panel-footer">
					<ul class="list-inline">
						<li>Co-sponsors:
							<?= _Q($rows[$sessionNo]['cosponsor']); ?>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<?php
		}
		?>
	</div>


	<div class="container">
		<hr>
		<footer>
			<p>&copy; 2013 - 2017 by NPO International TRI Network & KAMAKURA LIVE</p>
		</footer>
	</div>

	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../index2017.js"></script>
</body>

</html>