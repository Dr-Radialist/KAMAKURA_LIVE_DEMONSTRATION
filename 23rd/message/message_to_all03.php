<?php
	session_start();
	session_regenerate_id(true);
	require_once('../utilities/config.php');
	require_once('../utilities/lib.php');
	charSetUTF8();
	
	if (isset($_POST['message_to_all'])) {
		$_SESSION['message_to_all'] = _Q($_POST['message_to_all']);
	} else {
		$_SESSION['message_to_all'] = "";
		header('Location: messae_to_all01.php');
		exit;
	}
	
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    	die($e->getMessage());
	}
	
	$stmt = $pdo->prepare("SELECT `firstname`, `sirname`, `email`, `hp_name` FROM `dr_tbls` INNER JOIN `hp_tbls` ".
		"ON `dr_tbls`.`hp_tbl_id` = `hp_tbls`.`id`  WHERE `dr_tbls`.`is_active` = '1';");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	/*
	echo "message = "._Q($_POST['message_to_all'])."<br>";
	
	foreach($rows as $row) {
		echo $row['sirname']." ".$row['firstname']." -- ".$row['email']."<br>";
	}
	exit;
	*/
	////////////////////////////////////////////////////////////////////////////	

	$sender = mb_encode_mimeheader("Message from RAP and BEAT Clinical Trial");
	$subject = "${site_name} : Message from RAP and BEAT Clinical Trial";
	$headers  = "FROM: ".$sender."<fightingradialist@tri-international.org>\r\n";	
	$headers .= "Bcc: transradial@kamakuraheart.org,	rie_iwamoto@kamakuraheart.org, kaori_sudo@kamakuraheart.org, keiko.asou@tokushukai.jp";
	$parameters = '-f'.$support_mail;
	$message = _Q($_POST['message_to_all']);
	echo $message;
	$message = preg_replace("/&lt;br&gt;/", "\n", $message);
	$message = preg_replace("/&lt;BR&gt;/", "\n", $message);
	$message = preg_replace("/&quot;/", "\"", $message);
			
	//　ここからメール内容
			
	foreach($rows as $row) {
		$body = "This is the important message from RAP and BEAT Clinical Trial\n\n";
		$body .= "Dear Investigator Dr/Mr/Ms ".$row['firstname']." ".$row['sirname']."\n\n";
		$body .= $message;
		$sendto = $row['email'];
	
		if ($_SERVER['SERVER_NAME'] === 'localhost') {
			echo $sendto."<br>".$body."<br><br>";
		}  else {
			mb_language('ja');
			mb_internal_encoding('utf-8');
			mb_send_mail($sendto, $subject, $body, $headers, "-ffightingradialist@tri-international.org"); 
		}
	}

	
?>	

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RAP and BEAT Clinical Trial">
    <meta name="author" content="Shigeru SAITO, MD, FACC, FSCAI, FJCC">
    <meta http-equiv="cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="expires" content="0">   
    <link rel="shortcut icon" href="../favicon.ico">

    <title>RAP and BEAT</title>

   <script type="text/javascript">
//		window.onunload = function(){};
//		history.forward();
	</script>

</head>

<body>
<div class="container">
<div class="row center">
	<div class="col-md-12 header"><img src="../Color_Guitar_moving.gif" />&nbsp;&nbsp;RAP and BEAT Clinical Trial&nbsp;&nbsp;<img src="../Color_Guitar_moving.gif" width="64" height="64" alt=""/></div>
</div>
<p></p>

<div class="container">
  <div class="row center">
    <div class="col-md-4 tab_box">
        </div>
	</div>
</div>
<form name="rapandbeat" method="post" action="message_to_all03.php" id="go_to_mailing"><p><br></p>
    
    <div class="row">
    <div class="col-md-2"><strong>Message to All: </strong></div>
    <div class="col-sm-10">
      <input type="hidden" class="form-control gray_back" id="message_to_all" value='<?php if (isset($_SESSION['message_to_all'])) echo _Q($_SESSION['message_to_all']); ?>' name="message_to_all">
      <?php if (isset($_SESSION['message_to_all'])) echo _Q($_SESSION['message_to_all']); ?>
      
    </div><br><br><br>
    
    <div class="form-group"><br>
      </div>
    </div> 
    <!-- row -->
      <p></p>
      <p class="line2"></p>      
<div id="cancel_enter">
	<input type="button" id="enter_modify" value="&hearts;&hearts;&nbsp;OK proceed to sending mails&nbsp;&hearts;&hearts;" /><br /><br />
    <input type="button" id="back_to_01" value="&hearts;&hearts;&nbsp;Back to writing mails&nbsp;&hearts;&hearts;" /><br /><br />  
</div> 

      <hr>
	</form>
    
      <footer>
      <div class="row">
      <div class="col-md-6 left"><p>&nbsp;&nbsp;&copy; 2014-2016 by NPO International TRI Network</p></div>
      <div class="col-md-6 right"><p>Programmed solely by Shigeru SAITO, MD&nbsp;&nbsp;</p></div>
      </div>
      </footer>
    </div> <!-- /container -->

<?php
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
?>
		<link rel="stylesheet" type="text/css" href="../twitter_bootstrap/css/bootstrap.css">
		<script src = "../javascriptlib/jquery-1.10.2.min.js"></script>
		<script src="../twitter_bootstrap/js/bootstrap.min.js"></script>
<?php
	} else {
?>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<script src = "//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<?php
	}
?>
	<script src="../javascriptlib/jquery-corner.js"></script>

    <!-- Custom styles for this template -->
    <link href="../twitter_bootstrap/css/jumbotron.css" rel="stylesheet">
 <script>
   	jQuery(function() {
		$("#enter").corner().click(function() {
			$("#go_to_mailing").submit();
		});
		$("#back_to_01").corner().click(function() {
			document.location = "message_to_all01.php";
		});
	})
	
</script>

  </body>
</html>
