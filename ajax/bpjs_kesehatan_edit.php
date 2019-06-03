<?php include_once "../common.php"; ?> 	
<?php echo ?>	
<div class="modal-body" id="Add">

	<div class="login mx-auto mw-100">
		<h5 class="text-center">BPJS Kesehatan - Add</h5>
			
			<!--form -->
			<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
				<div class="container">
					<div class="info-para">
						<?=$f->start("","POST","","enctype='multipart/form-data'");?>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<?php if($candidate_id > 0){ ?>
										<font style="color:#1a75ff;font-style:italic;">Candidate</font>
										<?=$f->input("",$candidate_name,"readonly","form-control");?>
									<?php } else if($employee_id > 0) { ?>
										<font style="color:#1a75ff;font-style:italic;">Employee</font>
										<?=$f->input("",$employee_name,"readonly","form-control");?>
									<?php }?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Name</font>
									<?=$f->input("name",@$_POST["name"],"","form-control");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Birthdate</font>
									<?=$f->input("birthdate",@$_POST["birthdate"]," type='date' style='height:43px;'","form-control");?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Sex</font>
									<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_POST["sex"],"required","select_form");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Marital Status</font>
									<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_POST["status_id"],"required","select_form");?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">PISA</font>
									<?=$f->select("pisa",["peserta" => "Peserta", "istri" => "Istri", "suami"=>"Suami", "anak" => "Anak"],@$_POST["pisa"],"required","select_form");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">PKWT From</font>
									<?=$f->input("pkwt_from",@$_POST["pkwt_from"]," type='date' style='height:43px;'","form-control");?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">NIK</font>
									<?=$f->input("ktp",@$_POST["ktp"]," type='number' required","form-control");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">No BPJS</font>
									<?=$f->input("bpjs_id",@$_POST["bpjs_id"],"type='number'","form-control");?>
								</div>
							</div>
							<div class="form-group contact-forms">
								<font style="color:#1a75ff;font-style:italic;">Remarks</font>
								<?=$f->textarea("remarks",@$_POST["remarks"]," rows='3'","form-control");?>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Info To Employer At</font>
									<?=$f->input("info_to_empl_at",@$_POST["info_to_empl_at"]," type='date' style='height:43px;'","form-control");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Email</font>
									<?=$f->input("email",@$_POST["email"]," type='email'","form-control");?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Softcopy BPJS</font>
									<?=$f->input("softcopy","","type='file'","form-control");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Softcopy KTP</font>
									<?=$f->input("file_ktp","","type='file'","form-control");?>
								</div>
							</div>
							<div class="row wls-contact-mid">
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Softcopy KK</font>
									<?=$f->input("file_kk","","type='file'","form-control");?>
								</div>
								<div class="col-md-6 col-sm-6 form-group contact-forms">
									<font style="color:#1a75ff;font-style:italic;">Surat Pernyataan</font>
									<?=$f->input("file_pernyataan","","type='file'","form-control");?>
								</div>
							</div>
							<div class="text-left click-subscribe">
								<?=$f->input("saving_new","Save","type='submit'","btn btn-primary");?>
								<?=$f->input("cancel","Cancel","type='button' onclick='close_div(div_add.value)' ","btn btn-secondary");?>
							</div>
						<?=$f->end();?>
						
					</div>
				</div>
			</section>
			<!--//form  -->
			
	</div>
</div>
<?php ; ?>