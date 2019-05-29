<?php
	include_once "head.php";
	
	if(isset($_POST["save"])){
		$errormessage = "";
		if($errormessage == ""){
			$db->addtable("groups");
			$db->addfield("name");					$db->addvalue(ucwords(@$_POST["name"]));
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				?><script type="text/JavaScript">setTimeout("location.href = 'group_list.php';",1500);</script><?php
				
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
				<h4>Group Add</h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<?=$f->input("name",@$_POST["name"],"placeholder='Name' required","form-control");?>
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