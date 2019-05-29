<?php
	include_once "head.php";
	
	if(isset($_POST["save"])){
		$password = base64_decode($db->fetch_single_data("users","password",["id" => $__user_id]));
		$errormessage = "";
		if($password != $_POST["old_pass"]) {$errormessage = "Failed to saved! Wrong Password";}
		if($errormessage == ""){
			$db->addtable("users");					$db->where("id",$__user_id);
			$db->addfield("password");				$db->addvalue(base64_encode(@$_POST["re_pass"]));
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				?><script type="text/JavaScript">setTimeout("location.href = '?';",1500);</script><?php
			} else {
				$_SESSION["alert_danger"] = "Failed to saved!";
			}
		} else {
			$_SESSION["alert_danger"] = $errormessage;
		}
	}
?>

	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<div class="sub-head mb-3 ">
				<h4>Change Password</h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Current Password</font>
							<?=$f->input("old_pass","","type='password' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">New Password</font>
							<?=$f->input("new_pass","","type='password' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Retype Password</font>
							<?=$f->input("re_pass","","type='password' onkeyup='password_match(new_pass.value,this.value);' required","form-control");?>
							<div id="password_match" style="font-style:italic; color:green; font-weight:bolder; padding-left:10px; display:none;">Password Match</div>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit' style='disabled:true;'","btn btn-primary");?>
						<?=$f->input("back","Home","type='button' onclick=\"window.location='index.php';\"","btn btn-secondary");?>
					</div>
				<?=$f->end();?>
				<?php include_once "a_notification.php"; ?>
			</div>
		</div>
	</section>
    <!--//form  -->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
<script type="text/javascript"> 
	document.getElementById("old_pass").focus();
	document.getElementById("save").disabled = true;
	function password_match(new_pass,re_pass){
		if(new_pass == re_pass){
			$("#password_match").fadeIn( 200 ).delay();
			document.getElementById("save").disabled = false;
		} else {
			$("#password_match").fadeOut( 200 ).delay();
			document.getElementById("save").disabled = true;
		}
	}
</script>
</body>
</html>