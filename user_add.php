<?php
	include_once "head.php";
	
	if(isset($_POST["save"])){
		$errormessage = "";
		$cek_email = $db->fetch_single_data("users","id",["email" => $_POST["email"]]);
		if($cek_email) $errormessage = "Registration failed, email [<i>".$_POST["email"]."</i>] has been registered!";
		if($errormessage == ""){
			$db->addtable("users");
			$db->addfield("name");					$db->addvalue(ucwords(@$_POST["name"]));
			$db->addfield("email");					$db->addvalue(strtolower($_POST["email"]));
			$db->addfield("password");				$db->addvalue(base64_encode(@$_POST["password"]));
			$db->addfield("group_id");				$db->addvalue(@$_POST["group_id"]);
			$db->addfield("job_title");				$db->addvalue(@$_POST["job_title"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				?><script type="text/JavaScript">setTimeout("location.href = 'user_list.php';",1500);</script><?php
				
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
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>User Add</h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("name",@$_POST["name"],"placeholder='Name' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("email",@$_POST["email"],"placeholder='Email' type='email' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("password",@$_POST["password"],"placeholder='Password' type='password' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("job_title",@$_POST["job_title"],"placeholder='Job Title' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Group</font>
							<?=$f->select("group_id",$db->fetch_select_data("groups","id","name",[],array("name"),"",true),@$_POST["group_id"],"required","select_form");?>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
						<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
					</div>
				<?=$f->end();?>
			</div>
		</div>
	</section>
    <!--//form  -->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
<script type="text/javascript"> 
	document.getElementById("name").focus(); 
</script>
</body>
</html>