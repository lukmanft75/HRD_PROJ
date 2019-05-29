<html lang="zxx">
   <head>
      <title>HRD Proj</title>
	  <link rel="Shortcut Icon" href="favicon.ico">
      <!--meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="keywords" content="Job-point Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
         Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
      <script>
         addEventListener("load", function () {
         	setTimeout(hideURLbar, 0);
         }, false);
         
         function hideURLbar() {
         	window.scrollTo(0, 1);
         }
		 
		 function sorting(field){
			var current_sort = sort.value;
			current_sort = current_sort.replace(" DESC","");
			if((current_sort == field && sort.value.indexOf(" DESC") > 0) || current_sort != field){
				sort.value = field;
			} else {
				sort.value = field + " DESC";
			}
			document.getElementById("do_filter").click();
		}
      </script>
	  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
      <!--//meta tags ends here-->
      <!--booststrap-->
      <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
      <!--//booststrap end-->
      <!-- font-awesome icons -->
      <link href="css/font-awesome.css" rel="stylesheet">
      <!-- //font-awesome icons -->
      <!--stylesheets-->
      <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
      <!--//stylesheets-->
      <link href="//fonts.googleapis.com/css?family=Mukta+Malar:400,500,600,700" rel="stylesheet">
      <link href="//fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
   </head>
   <body>

	<?php 
		include_once "a_common.php";
		if(!$_isexport){ include_once "a_menu.php"; }
		
		if($__isloggedin){
		?>
			<!--<div style="width:95%;margin-top:20px;margin-left:20px;margin-right:20px;">-->
			<?php if(!$__is_allowed){
					include_once "a_403.php";
					include_once "footer.php";
					exit(); 
				} 
		} else {
			if($__phpself != "index.php") {header("Location: index.php");};
			include_once "a_login_page.php";
		}
	?>
	<?php
		$_rowperpage = 200; 
		$_max_counting = 100000; 
		$border_tbl = "";
		if(@$_GET["export"]){$border_tbl = "border=1px";}
		
		if(!$_GET["page"] || $_GET["page"] == 1) {
			$_limit = "0,".$_rowperpage;
			$start = 1;
		} else {
			$num = ($_GET["page"]-1)*$_rowperpage;
			$start = $num + 1;
			$_limit = $num.",".$_rowperpage;
		}
		
		$_SESSION["alert_danger"] = "";
		$_SESSION["alert_success"] = "";
		$_SESSION["alert_dark"] = "";
	?>
	  
      <!--//headder-->