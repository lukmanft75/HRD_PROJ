<?php include_once "wb_head.php" ;?>
<body>	
	<div class="modal-body" id="Edit">
		<?php
			$candidate_educations	= $db->fetch_all_data("candidate_educations",[],"id = '".$_GET["data_id"]."'")[0];
			$candidate_id		= $_GET["candidate_id"];
			$candidate_name 	= $db->fetch_single_data("candidates","name",array("id"=>$candidate_id));

			if(isset($_POST["saving_new"])){
				$db->addtable("candidate_educations");	$db->where("id",$_GET["data_id"]);
				$db->addfield("candidate_id");			$db->addvalue($candidate_id);
				$db->addfield("degree_id");				$db->addvalue($_POST["degree_id"]);
				$db->addfield("institution");			$db->addvalue($_POST["institution"]);
				$db->addfield("city");					$db->addvalue($_POST["city"]);
				$db->addfield("major");					$db->addvalue($_POST["major"]);
				$db->addfield("graduation_year");		$db->addvalue($_POST["graduation_year"]);
				$db->addfield("gpa");					$db->addvalue($_POST["gpa"]);
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
			<h5 class="text-center">Candidate Course - Edit</h5>
				
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
										<font style="color:#1a75ff;font-style:italic;">Degree</font>
										<?=$f->select("degree_id",$db->fetch_select_data("degrees","id","name",[],[],"",true),@$candidate_educations["degree_id"],"","select_form");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Institution</font>
										<?=$f->input("institution",@$candidate_educations["institution"],"","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">City</font>
										<?=$f->input("city",@$candidate_educations["city"],"","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Major</font>
										<?=$f->input("major",@$candidate_educations["major"],"","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Graduation Year</font>
										<?=$f->input("graduation_year",@$candidate_educations["graduation_year"],"type='number'","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">GPA</font>
										<?=$f->input("gpa",@$candidate_educations["gpa"],"","form-control");?>
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


