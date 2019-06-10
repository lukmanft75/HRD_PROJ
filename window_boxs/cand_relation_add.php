<?php include_once "wb_head.php" ;?>
<body>	
	<div class="modal-body" id="Add">
		<?php
			$candidate_id	= $_GET["candidate_id"];
			$candidate_name = $db->fetch_single_data("candidates","name",array("id"=>$candidate_id));

			if(isset($_POST["saving_new"])){
				$db->addtable("candidate_relations");
				$db->addfield("candidate_id");		$db->addvalue($candidate_id);
				$db->addfield("relation_id");		$db->addvalue($_POST["relation_id"]);
				$db->addfield("fullname");			$db->addvalue($_POST["fullname"]);
				$db->addfield("division");			$db->addvalue($_POST["division"]);
				$db->addfield("location");			$db->addvalue($_POST["location"]);
				$inserting = $db->insert();
				if($inserting["affected_rows"] > 0){
					$_SESSION["alert_success"] = "Data saved successfully!";
					?><script type="text/JavaScript">setTimeout("location.href = '<?=str_replace("_add","_list",$_SERVER["PHP_SELF"]);?>?candidate_id=<?=$candidate_id;?>';",1500);</script><?php
				} else {
					$_SESSION["alert_danger"] = "Failed to saved!";
				}	
			}
		?>

		<div class="login mx-auto mw-100">
			<h5 class="text-center">Candidate Relation - Add</h5>
				
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
										<?=$f->select("relation_id",$db->fetch_select_data("relations","id","name",[],[],"",true),@$_POST["relation_id"],"","select_form");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Full Name</font>
										<?=$f->input("fullname",@$_POST["fullname"],"required","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Division</font>
										<?=$f->input("division",@$_POST["division"],"t","form-control");?>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Location</font>
										<?=$f->input("location",@$_POST["location"],"","form-control");?>
									</div>
								</div>
								<div class="text-left click-subscribe">
									<?=$f->input("saving_new","Save","type='submit'","btn btn-primary");?>
									<?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."?candidate_id=".$candidate_id."';\"","btn btn-secondary");?>
								</div>
							<?=$f->end();?>
							
						</div>
					</div>
				</section>
				<!--//form  -->
				
		</div>
	</div>
</body>	


