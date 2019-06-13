<?php include_once "wb_head.php" ;?>
<body>	
	<div class="modal-body" id="Add">
		<?php
			$employee_work_experiences	= $db->fetch_all_data("employee_work_experiences",[],"id = '".$_GET["data_id"]."'")[0];
			$employee_id	= $_GET["employee_id"];
			$employee_name = $db->fetch_single_data("employees","name",array("id"=>$employee_id));

			if(isset($_POST["saving_new"])){
				$db->addtable("employee_work_experiences");	$db->where("id",$_GET["data_id"]);
				$db->addfield("employee_id");		$db->addvalue($employee_id);
				$db->addfield("company_name");		$db->addvalue($_POST["company_name"]);
				$db->addfield("location");			$db->addvalue($_POST["location"]);
				$db->addfield("tasks");				$db->addvalue($_POST["tasks"]);
				$db->addfield("phone");				$db->addvalue($_POST["phone"]);
				$db->addfield("join_at");			$db->addvalue($_POST["join_at"]);
				$db->addfield("last_at");			$db->addvalue($_POST["last_at"]);
				$db->addfield("leaving_reason");	$db->addvalue($_POST["leaving_reason"]);
				$inserting = $db->update();
				if($inserting["affected_rows"] > 0){
					$_SESSION["alert_success"] = "Data saved successfully!";
					?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_edit","_list",$_SERVER["PHP_SELF"]);?>?employee_id=<?=$employee_id;?>';",1500);</script><?php
				} else {
					$_SESSION["alert_danger"] = "Failed to saved!";
				}	
			}
		?>

		<div class="login mx-auto mw-100">
			<h5 class="text-center">Employee Work Experiences - Edit</h5>
				
				<!--form -->
				<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
					<div class="container">
						<?php include_once "../a_notification.php"; ?>
						<div class="info-para">
							<?=$f->start("","POST","","enctype='multipart/form-data'");?>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Employee</font>
										<?=$f->input("",$employee_name,"readonly","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Company Name</font>
										<?=$f->input("company_name",@$employee_work_experiences["company_name"],"required","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Location</font>
										<?=$f->input("location",@$employee_work_experiences["location"],"","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Phone</font>
										<?=$f->input("phone",@$employee_work_experiences["phone"],"","form-control");?>
									</div>
								</div>
								<div class="form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Tasks</font>
									<?=$f->textarea("tasks",@$employee_work_experiences["tasks"]," rows='3'","form-control");?>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Join At</font>
										<?=$f->input("join_at",@$employee_work_experiences["join_at"],"type='date'","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Last At</font>
										<?=$f->input("last_at",@$employee_work_experiences["last_at"],"type='date'","form-control");?>
									</div>
								</div>
								<div class="form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Leaving Reason</font>
									<?=$f->textarea("leaving_reason",@$employee_work_experiences["leaving_reason"]," rows='3'","form-control");?>
								</div>
								<div class="text-left click-subscribe">
									<?=$f->input("saving_new","Save","type='submit'","btn btn-primary");?>
									<?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."?employee_id=".$employee_id."';\"","btn btn-secondary");?>
								</div>
							<?=$f->end();?>
							
						</div>
					</div>
				</section>
				<!--//form  -->
				
		</div>
	</div>
</body>	


