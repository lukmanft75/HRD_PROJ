<?php include_once "wb_head.php" ;?>
<body>	
	<div class="modal-body" id="Add">
		<?php
			$candidate_last_company	= $db->fetch_all_data("candidate_last_company",[],"id = '".$_GET["data_id"]."'")[0];
			$candidate_id	= $_GET["candidate_id"];
			$candidate_name = $db->fetch_single_data("candidates","name",array("id"=>$candidate_id));

			if(isset($_POST["saving_new"])){
				$db->addtable("candidate_last_company");	$db->where("id",$_GET["data_id"]);
				$db->addfield("candidate_id");		$db->addvalue($candidate_id);
				$db->addfield("salary");			$db->addvalue($_POST["salary"]);
				$db->addfield("call_allowance");	$db->addvalue($_POST["call_allowance"]);
				$db->addfield("insurance");			$db->addvalue($_POST["insurance"]);
				$db->addfield("bpjs");				$db->addvalue($_POST["bpjs"]);
				$db->addfield("transport");			$db->addvalue($_POST["transport"]);
				$db->addfield("overtime");			$db->addvalue($_POST["overtime"]);
				$db->addfield("other");				$db->addvalue($_POST["other"]);
				$inserting = $db->update();
				if($inserting["affected_rows"] > 0){
					$_SESSION["alert_success"] = "Data saved successfully!";
					?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_edit","_list",$_SERVER["PHP_SELF"]);?>?candidate_id=<?=$candidate_id;?>';",1500);</script><?php
				} else {
					$_SESSION["alert_danger"] = "Failed to saved!";
				}	
			}
		?>

		<div class="login mx-auto mw-100">
			<h5 class="text-center">Compensation & Benefit Package Last Company - Edit</h5>
				
				<!--form -->
				<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
					<div class="container">
						<?php include_once "../a_notification.php"; ?>
						<div class="info-para">
							<?=$f->start("","POST","","enctype='multipart/form-data'");?>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Candidate</font>
										<?=$f->input("",$candidate_name,"readonly","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Salary</font>
										<?=$f->input("salary",@$candidate_last_company["salary"],"type='number'","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Call Allowance</font>
										<?=$f->input("call_allowance",@$candidate_last_company["call_allowance"],"type='number'","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Insurance</font>
										<?=$f->input("insurance",@$candidate_last_company["insurance"],"type='number'","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">BPJS</font>
										<?=$f->input("bpjs",@$candidate_last_company["bpjs"],"type='number'","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Transport</font>
										<?=$f->input("transport",@$candidate_last_company["transport"],"type='number'","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Overtime</font>
										<?=$f->input("overtime",@$candidate_last_company["overtime"],"type='number'","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Other</font>
										<?=$f->input("other",@$candidate_last_company["other"],"type='number'","form-control");?>
									</div>
								</div>
								<div class="text-left click-subscribe">
									<?=$f->input("saving_new","Save","type='submit'","btn btn-primary");?>
									<?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."?candidate_id=".$candidate_id."';\"","btn btn-secondary");?>
								</div>
							<?=$f->end();?>
							
						</div>
					</div>
				</section>
				<!--//form  -->
				
		</div>
	</div>
</body>	


