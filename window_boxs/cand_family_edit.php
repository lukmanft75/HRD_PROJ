<?php include_once "wb_head.php" ;?>
<body>	
	<div class="modal-body" id="Add">
		<?php
			$candidate_families	= $db->fetch_all_data("candidate_families",[],"id = '".$_GET["data_id"]."'")[0];
			$candidate_id	= $_GET["candidate_id"];
			$candidate_name = $db->fetch_single_data("candidates","name",array("id"=>$candidate_id));

			if(isset($_POST["saving_new"])){
				$db->addtable("candidate_families");$db->where("id",$_GET["data_id"]);
				$db->addfield("candidate_id");		$db->addvalue($candidate_id);
				$db->addfield("relation_id");		$db->addvalue($_POST["relation_id"]);
				$db->addfield("fullname");			$db->addvalue($_POST["fullname"]);
				$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
				$db->addfield("degree_id");			$db->addvalue($_POST["degree_id"]);
				$db->addfield("occupation");		$db->addvalue($_POST["occupation"]);
				$db->addfield("phone");				$db->addvalue($_POST["phone"]);
				$db->addfield("birthplace");		$db->addvalue($_POST["birthplace"]);
				$db->addfield("sex");				$db->addvalue($_POST["sex"]);
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
			<h5 class="text-center">Candidate Family - Edit</h5>
				
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
										<font style="color:#1a75ff;font-style:italic;">Relation</font>
										<?=$f->select("relation_id",$db->fetch_select_data("relations","id","name",[],[],"",true),@$candidate_families["relation_id"],"","select_form");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Full Name</font>
										<?=$f->input("fullname",@$candidate_families["fullname"],"required","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Degree</font>
										<?=$f->select("degree_id",$db->fetch_select_data("degrees","id","name",[],[],"",true),@$candidate_families["degree_id"],"","select_form");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Sex</font>
										<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$candidate_families["sex"],"required","select_form");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Birthplace</font>
										<?=$f->input("birthplace",@$candidate_families["birthplace"],"","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Birthdate</font>
										<?=$f->input("birthdate",@$candidate_families["birthdate"],"type='date'","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Occupation</font>
										<?=$f->input("occupation",@$candidate_families["occupation"],"","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Phone</font>
										<?=$f->input("phone",@$candidate_families["phone"],"","form-control");?>
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


