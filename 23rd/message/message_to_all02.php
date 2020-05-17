<?php
	session_start();
	session_regenerate_id(true);
	require_once('../utilities/config.php');
	require_once('../utilities/lib.php');
	charSetUTF8();
	
	if (isset($_POST['message_to_all'])) {
		$_SESSION['message_to_all'] = $_POST['message_to_all'];
	} else {
		$_SESSION['message_to_all'] = "";
		header('Location: messae_to_all01.php');
		exit;
	}
	$message_mod = preg_replace("/<br>/", "\n", $_SESSION['message_to_all']);
	$_SESSION['message_to_all'] = $message_mod;
	
	
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
<form name="message" method="post" action="message_to_all03.php" id="go_to_mailing"><p><br></p>
    
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
		$("#enter_modify").corner().click(function() {
			$("#go_to_mailing").submit();
		});
		$("#back_to_01").corner().click(function() {
			document.location = "message_to_all01.php";
		});
	})
	
</script>

  </body>
</html>
