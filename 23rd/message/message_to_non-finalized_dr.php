<?php
/*
このルーチンは、登録患者さんのfinalizeがされていない症例を有する施設のinvestigatorsに対して
未finalized患者さん一覧をつけて送付するものである
*/
	session_start();
	session_regenerate_id(true);
	require_once('../utilities/config.php');
	require_once('../utilities/lib.php');
	charSetUTF8();
	/*
	if (isset($_POST['message_to_all'])) {
		$_SESSION['message_to_all'] = _Q($_POST['message_to_all']);
	} else {
		$_SESSION['message_to_all'] = "";
		header('Location: messae_to_all01.php');
		exit;
	}
	*/
	//接続
 	try {
    // MySQLサーバへ接続
   	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
	// 注意: 不要なspaceを挿入すると' $db_host'のようにみなされ、エラーとなる
	} catch(PDOException $e){
    	die($e->getMessage());
	}

	// finalizedされていない症例がある医師を重複無く選択する
	$stmt = $pdo->prepare("SELECT DISTINCT `registration_dr_id` as `dr_id` FROM `pt_tbls` WHERE `is_finalized` = '0';");
	$stmt->execute();
	$rows_non_finalized_dr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
	foreach($rows_non_finalized_dr as $row_non_finalized_dr) {
		$stmt = $pdo->prepare("SELECT `firstname`, `sirname`, `email`, `hp_tbl_id` as `hp_id` from `dr_tbls` WHERE `id` = :id;");
		$stmt->bindValue(":id", $row_non_finalized_dr['dr_id'], PDO::PARAM_INT);
		$stmt->execute();
		$row_dr = $stmt->fetch(PDO::FETCH_ASSOC);
		$firstname = $row_dr['firstname']; $sirname = $row_dr['sirname'];	// finalizedされていない症例登録医師
		$email = $row_dr['email'];
		$hp_id = $row_dr['hp_id'];
	
		$stmt = $pdo->prepare("SELECT `hp_name` FROM `hp_tbls` WHERE `id` = '".$hp_id."';");
		$stmt->execute();
		$row_hp = $stmt->fetch(PDO::FETCH_ASSOC);
		$hp_name = $row_hp['hp_name'];
				
		$sender = mb_encode_mimeheader("Message from RAP and BEAT Clinical Trial");
		$subject = "${site_name} : Message from RAP and BEAT Clinical Trial";
		$headers  = "FROM: ".$sender."<fightingradialist@tri-international.org>\r\n";	
		$headers .= "Bcc: transradial@kamakuraheart.org,	rie_iwamoto@kamakuraheart.org, kaori_sudo@kamakuraheart.org, keiko.asou@tokushukai.jp";
		$parameters = '-f'.$support_mail;
		$sendto = $email;
	
		$stmt = $pdo->prepare("SELECT `arbitrary_id`, `registration_date` FROM `pt_tbls` INNER JOIN `dr_tbls` ON `pt_tbls`.`registration_dr_id` = `dr_tbls`.`id` WHERE `pt_tbls`.`is_finalized` = '0' AND `pt_tbls`.`hp_tbl_id` = :hp_tbl_id;");
		$stmt->bindValue(":hp_tbl_id", $hp_id, PDO::PARAM_INT);
		$stmt->execute();
		$rows_non_finalized_pt = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$list_non_finalized = "\nThe list of non-finalized patients from your hospital is:\n";
		foreach($rows_non_finalized_pt  as $row_non_finalized_pt) {
			$pt_arbitrary_id = $row_non_finalized_pt ['arbitrary_id'];
			$registration_date = $row_non_finalized_pt ['registration_date'];
			$list_non_finalized.="  Arbitrary ID: ".$pt_arbitrary_id."    Registration Date (JST): ".$registration_date."\n";
		}
		$body = "Dear Investigator Dr/Mr/Ms ".$firstname." ".$sirname." (".$hp_name.")\n\n";
		$body .= "Could you kindly finalize data from your hospital?\n";
		$body .= $list_non_finalized;
		$body .= "\nSincerely yours,\n\nShigeru SAITO, MD, FACC, FSCAI";
		if ($_SERVER['SERVER_NAME'] === 'localhost') {
			echo $sendto."<br>".$body."<br><br>";
		}  else {
			mb_language('ja');
			mb_internal_encoding('utf-8');
			mb_send_mail($sendto, $subject, $body, $headers, "-ffightingradialist@tri-international.org"); 
		}
	}
	
	//　ここからメール内容

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
