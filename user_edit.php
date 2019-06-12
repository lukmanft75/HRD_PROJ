<?php
	include_once "head.php";
	$id = GET_url_decode("id");
	$user_details = $db->fetch_all_data("users",[],"id='".$id."'")[0];
	
	if(isset($_POST["save"])){
		$errormessage = "";
		if($errormessage == ""){
			$db->addtable("users");					$db->where("id",$id);
			$db->addfield("name");					$db->addvalue(ucwords(@$_POST["name"]));
			$db->addfield("email");					$db->addvalue(strtolower($_POST["email"]));
			if(@$_POST["password"]){
				$db->addfield("password");				$db->addvalue(base64_encode(@$_POST["password"]));
			}
			$db->addfield("group_id");				$db->addvalue(@$_POST["group_id"]);
			$db->addfield("job_title");				$db->addvalue(@$_POST["job_title"]);
			$db->addfield("hidden");				$db->addvalue(@$_POST["hidden"]);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_edit","_list",$_SERVER["PHP_SELF"]);?>';",1500);</script><?php
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
				<h4>User Edit</h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("name",@$user_details["name"],"placeholder='Name' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("email",@$user_details["email"],"placeholder='Email' type='email' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("password","","placeholder='Password' type='password' ","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("job_title",@$user_details["job_title"],"placeholder='Job Title' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Group</font>
							<?=$f->select("group_id",$db->fetch_select_data("groups","id","name",[],array("name"),"",true),@$user_details["group_id"],"required","select_form");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:red;font-style:italic;">Data Status</font>
							<?=$f->select("hidden",["0"=>"Active","1"=>"Not Active"],@$user_details["hidden"],"required","select_form");?>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
						<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
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