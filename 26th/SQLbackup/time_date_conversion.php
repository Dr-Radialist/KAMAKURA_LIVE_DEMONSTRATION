<?php
// このルーチンは session_tbls2018 に新たに追加した　beginDate列に正しい datetimeデータを植え込むものである

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

$stmt = $pdo->prepare( "SELECT * FROM `session_tbls2018` WHERE '1' = '1';" );

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
$rows = $stmt->fetchAll( PDO::FETCH_ASSOC );
$stmt1 = $pdo->prepare("UPDATE `session_tbls2018` SET `beginDate` = :beginDate WHERE `id` = :id;");

foreach ( $rows as $row ) { // 全てのデータ
	if ( ( $row[ 'id' ] > '171' )AND( $row[ 'id' ] < '186' ) ) {	//2017年　座学修正用
		$begintime = date( 'Y/m/d H:i:s', strtotime( '2017/12/09' . $row[ 'begin' ] ) );
		$stmt1->bindValue( ":beginDate", $begintime, PDO::PARAM_STR );
		$stmt1->bindValue( ":id", $row[ 'id' ], PDO::PARAM_INT );
		$stmt1->execute();
		try {
			$pdo->beginTransaction();
			$flag = $stmt1->execute();
			if ( !$flag ) {
				$infor = $stmt1->errorInfo();
				exit( $infor[ 2 ] );
			}

			$pdo->commit();
		} catch ( Exception $e ) {
			$pdo->rollBack();
			echo "Failed to update Database" . $e->getMessage();
		}
		echo $begintime . "<br>";
	}
	if ($row['id'] == 185) echo "座学が修正されました<br><br>";
	
	if ( ( $row[ 'id' ] > '185' )AND( $row[ 'id' ] < '198' ) ) {	//2017年　TRI Session 12/09修正用
		$begintime = date( 'Y/m/d H:i:s', strtotime( '2017/12/09' . $row[ 'begin' ] ) );
		$stmt1->bindValue( ":beginDate", $begintime, PDO::PARAM_STR );
		$stmt1->bindValue( ":id", $row[ 'id' ], PDO::PARAM_INT );
		$stmt1->execute();
		try {
			$pdo->beginTransaction();
			$flag = $stmt1->execute();
			if ( !$flag ) {
				$infor = $stmt1->errorInfo();
				exit( $infor[ 2 ] );
			}

			$pdo->commit();
		} catch ( Exception $e ) {
			$pdo->rollBack();
			echo "Failed to update Database" . $e->getMessage();
		}
		echo $begintime . "<br>";
	}
	if ($row['id'] == 197) echo "TRI Session 12/09 が修正されました<br><br>";
	
	if ( ( $row[ 'id' ] > '197' )AND( $row[ 'id' ] < '207' ) ) {	//2017年　TRI Session 12/10修正用
		$begintime = date( 'Y/m/d H:i:s', strtotime( '2017/12/10' . $row[ 'begin' ] ) );
		$stmt1->bindValue( ":beginDate", $begintime, PDO::PARAM_STR );
		$stmt1->bindValue( ":id", $row[ 'id' ], PDO::PARAM_INT );
		$stmt1->execute();
		try {
			$pdo->beginTransaction();
			$flag = $stmt1->execute();
			if ( !$flag ) {
				$infor = $stmt1->errorInfo();
				exit( $infor[ 2 ] );
			}

			$pdo->commit();
		} catch ( Exception $e ) {
			$pdo->rollBack();
			echo "Failed to update Database" . $e->getMessage();
		}
		echo $begintime . "<br>";
	}
	if ($row['id'] == 206) echo "TRI Session 12/10が修正されました<br><br>";

	if ( ( $row[ 'id' ] > '207' )AND( $row[ 'id' ] < '219' ) ) {	//2017年　COMECOME修正用
		$begintime = date( 'Y/m/d H:i:s', strtotime( '2017/12/10' . $row[ 'begin' ] ) );
		$stmt1->bindValue( ":beginDate", $begintime, PDO::PARAM_STR );
		$stmt1->bindValue( ":id", $row[ 'id' ], PDO::PARAM_INT );
		$stmt1->execute();
		try {
			$pdo->beginTransaction();
			$flag = $stmt1->execute();
			if ( !$flag ) {
				$infor = $stmt1->errorInfo();
				exit( $infor[ 2 ] );
			}

			$pdo->commit();
		} catch ( Exception $e ) {
			$pdo->rollBack();
			echo "Failed to update Database" . $e->getMessage();
		}
		echo $begintime . "<br>";
	}
	if ($row['id'] == 218) echo "COMECOMEが修正されました<br><br>";
}
	
exit();

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
	<link rel="stylesheet" type="text/css" href="../2016top.css">

</head>

<body>
	<div class="container">
		<div class="col-sm-10">
			
		</div>

	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
	<script>
		if ( !window.jQuery ) {
			document.write( '<script src="bootstrap/jquery-2.1.4.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script>' );
		}
	</script>
	<script src="../../bootstrap/docs-assets/javascript/extension.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jglycy-1.0.js"></script>
	<script src="../../bootstrap/docs-assets/javascript/jtruncsubstr.js"></script>
	<script src="../index2016.js"></script>
</body>
</html>