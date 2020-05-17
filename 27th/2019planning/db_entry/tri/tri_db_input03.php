<?php

session_start();
session_regenerate_id( true );
require_once( '../../../../utilities/config.php' );
require_once( '../../../../utilities/lib.php' );
charSetUTF8();
//接続
try {
	// MySQLサーバへ接続
	$pdo = new PDO( "mysql:host=$db_host;dbname=$db_name_sessions;charset=utf8", $db_user, $db_password );
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
} catch ( PDOException $e ) {
	die( $e->getMessage() );
}

$stmt = $pdo->prepare( "INSERT INTO `session_tbls2019` (`sessionNo`,  `beginDate`, `duration`, `sessionTitle`, `cosponsor`, " .
	"`lectureTitle`, `day`, `venue`, `changed`, `year`, `class`, `begin`, `description`) VALUES " .
	"(:sessionNo, :beginDate, :duration, :sessionTitle, :cosponsor, :lectureTitle, :day, :venue, :changed, :year, :class, :begin, :description);" );

$stmt->bindValue( ":sessionNo", $_POST[ 'sessionNo' ], PDO::PARAM_INT );
$stmt->bindValue( ":beginDate", $_POST[ 'beginDate' ], PDO::PARAM_STR );
$stmt->bindValue( ":duration", $_POST[ 'duration' ], PDO::PARAM_INT );
$stmt->bindValue( ":sessionTitle", $_POST[ 'sessionTitle' ], PDO::PARAM_STR );
$stmt->bindValue( ":cosponsor", $_POST[ 'cosponsor' ], PDO::PARAM_STR );
$stmt->bindValue( ":lectureTitle", $_POST[ 'lectureTitle' ], PDO::PARAM_STR );
$stmt->bindValue( ":day", mb_substr( $_POST[ 'beginDate' ], 0, 10 ), PDO::PARAM_STR );
$stmt->bindValue( ":venue", "HAMAGIN Hall", PDO::PARAM_STR );
$stmt->bindValue( ":changed", date( 'Y-m-d H:i:s' ), PDO::PARAM_STR );
$stmt->bindValue( ":year", $this_year, PDO::PARAM_STR );
$stmt->bindValue( ":class", "tri", PDO::PARAM_STR );
$stmt->bindValue( ":begin", mb_substr( $_POST[ 'beginDate' ], 11, 5 ), PDO::PARAM_STR );
$stmt->bindValue( ":description", $_POST['description'], PDO::PARAM_STR );


try {
	$pdo->beginTransaction();
	$flag = $stmt->execute();
	if ( !$flag ) {
		$infor = $stmt->errorInfo();
		exit( $infor[ 2 ] );
	}

	$pdo->commit();
} catch ( Exception $e ) {
	$pdo->rollBack();
	echo "Failed to update Database" . $e->getMessage();
}



header( 'Location:tri_db_input.php' );
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../../../favicon.ico">
	<title>KAMAKURA LIVE</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/css/bootstrap.css">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" type="text/css" href="../../../../bootstrap/jumbotron/jumbotron.css">
	<link rel="stylesheet" type="text/css" href="../../../2016top.css">
</head>

<body>
	<div class="container"> </div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="../../../../bootstrap/jquery-2.1.4.min.js"><\/script><script src="../../../../bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../../../index2016.js"></script>
</body>
</html>