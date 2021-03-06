﻿<?php
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

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018` WHERE `class` = 'tri' AND `year` = '2018' ORDER BY `sessionNo` AND `id` > '185'ASC;" );
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
$//latest = mb_substr( $latest, 0, 10 );

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
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="../2017top.css">
	<link rel="stylesheet" type="text/css" href="tri_session_table.css"
</head>
<!-- <body onLoad="init();"> -->

<body>
	<div class="container">
		<h1 class="text-center text-danger">KAMAKURA TRI (12/15 SAT)</h1>
	<span style="color:red; font-weight:bold; font-size:small;">&nbsp;&nbsp;最終更新日時:
<?= $latest ?>
</span>		
		<div class="row">
			<div class="col-lg-12">
				<div class="session_title">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="1">Detail</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[0]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[0]['begin']) + $rows[0]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[0]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[0]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[0]['venue']); ?>
						</div>
					</div>
					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="subsession_button" name="sessionNo" value="2">Detail</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[1]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[1]['begin']) +$rows[1]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[1]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 2, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 2, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 2, 4, $class, $this_year)); ?>
							</div>
						</div>
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="mini_lecture btn" name="sessionNo" value="3">Detail</button>
							</form>
							<div>Mini-Lecture Speaker:
								<?= _Q(makeTriList($pdo, 3, 3, $class, $this_year)); ?>
							</div>
							<div>Chair:
								<?= _Q(makeTriList($pdo, 3, 1, $class, $this_year)); ?>
							</div>
							<div>Title:
								<?= _Q($rows[2]['lectureTitle']); ?>
							</div>
							<div class="description">Description:
								<?= _Q($rows[2]['description']); ?>
							</div>
							<div>Lecture Co-Sponsor:
								<?= _Q($rows[2]['cosponsor']); ?>
							</div>
						</div>
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="subsession_button" name="sessionNo" value="4">Detail</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[3]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[3]['begin']) +$rows[3]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[3]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 4, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 4, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 4, 4, $class, $this_year)); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="luncheon">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="5">Detail
						</button>
					</form>
					<div>Luncheon Speaker:
						<?= _Q(makeTriList($pdo, 5, 3, $class, $this_year)) ?>
					</div>
					<div>Chair:
						<?= _Q(makeTriList($pdo, 5, 1, $class, $this_year)); ?>
					</div>
					<div>Luncheon Title:
						<?= _Q($rows[4]['lectureTitle']); ?>
					</div>
					<!--
					<div class="description">Description:
						<?= _Q($rows[4]['description']); ?>
					</div>
					-->
					<div>Lecture Co-Sponsor:
						<?= _Q($rows[4]['cosponsor']); ?>
					</div>
				</div>

				<div class="session_title">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="6">Detail
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[5]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[5]['begin']) + $rows[5]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[5]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[5]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[5]['venue']); ?>
						</div>
					</div>

					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="7">Detail
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[6]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[6]['begin']) +$rows[6]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[6]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo,7, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 7, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 7, 4, $class, $this_year)); ?>
							</div>

							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="8">Detail
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 8, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 8, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[7]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[7]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[7]['cosponsor']); ?>
								</div>


							</div>
							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="9">Detail
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[8]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[8]['begin']) +$rows[8]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[8]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 9, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 9, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 9, 4, $class, $this_year)); ?>
								</div>

							</div>

							<form method="post" action="tri_sessions.php">
								<button type="submit" class="mini_lecture btn" name="sessionNo" value="10">Detail
							</button>
							</form>
							<div>Mini-Lecture Speaker:
								<?= _Q(makeTriList($pdo, 10, 3, $class, $this_year)); ?>
							</div>
							<div>Chair:
								<?= _Q(makeTriList($pdo, 10, 1, $class, $this_year)); ?>
							</div>
							<div>Title:
								<?= _Q($rows[9]['lectureTitle']); ?>
							</div>
							<div class="description">Description:
								<?= _Q($rows[9]['description']); ?>
							</div>
							<div>Lecture Co-Sponsor:
								<?= _Q($rows[9]['cosponsor']); ?>
							</div>

							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="11">Detail
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[10]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[10]['begin']) +$rows[10]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[10]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo,11, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 11, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 11, 4, $class, $this_year)); ?>
								</div>

							</div>
						</div>
					</div>
				</div>

				
				<div class="luncheon">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="21">Detail
						</button>
					</form>
					<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[20]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[20]['begin']) +$rows[20]['duration']*60); ?>
								</div>
					<div>Speaker:
						<?= _Q(makeTriList($pdo, 21, 3, $class, $this_year)) ?>
					</div>
					<div>Chair:
						<?= _Q(makeTriList($pdo, 21, 1, $class, $this_year)); ?>
					</div>
					<div>Topic Title:
						<?= _Q($rows[20]['lectureTitle']); ?>
					</div>
					<div class="description">Description:
						<?= _Q($rows[20]['description']); ?>
					</div>
		
					<div>Lecture Co-Sponsor:
						<?= _Q($rows[20]['cosponsor']); ?>
					</div>
				</div>		
				
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container -->

	<div class="container" id="day2">
		<h1 class="text-center text-primary">KAMAKURA TRI (12/16 SUN)</h1>
		<div class="row">
			<div class="col-lg-12">
				<div class="session_title">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="12">Detail
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[11]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[11]['begin']) + $rows[11]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[11]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[11]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[11]['venue']); ?>
						</div>
					</div>

					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="13">Detail
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[12]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[12]['begin']) +$rows[12]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[12]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo, 13, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 13, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 13, 4, $class, $this_year)); ?>
							</div>

							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="14">Detail
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 14, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 14, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[13]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[13]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[13]['cosponsor']); ?>
								</div>

							</div>
							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="15">Detail
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[14]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[14]['begin']) +$rows[14]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[14]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 15, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator::
									<?= _Q(makeTriList($pdo, 15, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 15, 4, $class, $this_year)); ?>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="luncheon">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="16">Detail
						</button>
					</form>
					<div> Speaker:
						<?= _Q(makeTriList($pdo, 16, 3, $class, $this_year)) ?>
					</div>
					<div>Chair:
						<?= _Q(makeTriList($pdo, 16, 1, $class, $this_year)); ?>
					</div>
					<div>Luncheon Title:
						<?= _Q($rows[15]['lectureTitle']); ?>
					</div>
					<div class="description">Description:
						<?= _Q($rows[15]['description']); ?>
					</div>
					<div>Lecture Co-Sponsor:
						<?= _Q($rows[15]['cosponsor']); ?>
					</div>
				</div>
				<div class="session_title">
					<form method="post" action="tri_sessions.php">
						<button type="submit" class="subsession_button" name="sessionNo" value="17">Detail
						</button>
					</form>
					<div>
						<div class="fleft">&nbsp;
							<?= _Q(mb_substr($rows[16]['begin'], 0, 5)); ?>
							-
							<?= date("H:i" , strtotime($rows[16]['begin']) + $rows[16]['duration']*60); ?>
						</div>
						<div class="fright">
							<?= _Q($rows[16]['sessionTitle']); ?>
						</div>
						<div class="fclear">Session Co-Sponsor:
							<?= _Q($rows[16]['cosponsor']); ?>
						</div>
						<div>Venue:
							<?= _Q($rows[16]['venue']); ?>
						</div>
					</div>
					<div class="col-lg-10 session_sub">
						<div class="subsession">
							<form method="post" action="tri_sessions.php">
								<button type="submit" class="subsession_button btn" name="sessionNo" value="18">Detail
								</button>
							</form>
							<div class="fleft">&nbsp;
								<?= _Q(mb_substr($rows[17]['begin'], 0, 5)); ?>
								-
								<?= date("H:i" , strtotime($rows[18]['begin']) +$rows[17]['duration']*60); ?>
							</div>
							<div class="fright">Session Subtitle:
								<?= _Q($rows[17]['sessionTitle']); ?>
							</div>
							<div class="fclear">Chair:
								<?= _Q(makeTriList($pdo,18, 1, $class, $this_year)); ?>
							</div>
							<div>Commentator::
								<?= _Q(makeTriList($pdo, 18, 2, $class, $this_year)); ?>
							</div>
							<div>In-Cathe Interpreter:
								<?= _Q(makeTriList($pdo, 18, 4, $class, $this_year)); ?>
							</div>
							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="mini_lecture btn" name="sessionNo" value="19">Detail
								</button>
								</form>
								<div>Mini-Lecture Speaker:
									<?= _Q(makeTriList($pdo, 19, 3, $class, $this_year)); ?>
								</div>
								<div>Chair:
									<?= _Q(makeTriList($pdo, 19, 1, $class, $this_year)); ?>
								</div>
								<div>Title:
									<?= _Q($rows[18]['lectureTitle']); ?>
								</div>
								<div class="description">Description:
									<?= _Q($rows[18]['description']); ?>
								</div>
								<div>Lecture Co-Sponsor:
									<?= _Q($rows[18]['cosponsor']); ?>
								</div>
							</div>
							<div class="subsession">
								<form method="post" action="tri_sessions.php">
									<button type="submit" class="subsession_button btn" name="sessionNo" value="20">Detail
								</button>
								</form>
								<div class="fleft">&nbsp;
									<?= _Q(mb_substr($rows[19]['begin'], 0, 5)); ?>
									-
									<?= date("H:i" , strtotime($rows[19]['begin']) +$rows[19]['duration']*60); ?>
								</div>
								<div class="fright">Session Subtitle:
									<?= _Q($rows[19]['sessionTitle']); ?>
								</div>
								<div class="fclear">Chair:
									<?= _Q(makeTriList($pdo, 20, 1, $class, $this_year)); ?>
								</div>
								<div>Commentator:
									<?= _Q(makeTriList($pdo, 20, 2, $class, $this_year)); ?>
								</div>
								<div>In-Cathe Interpreter:
									<?= _Q(makeTriList($pdo, 20, 4, $class, $this_year)); ?>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<footer>
						<p>&copy; 2013 - 2018 by NPO International TRI Network & KAMAKURA LIVE</p>
					</footer>
				</div>
			</div>
		</div>
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