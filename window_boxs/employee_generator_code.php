<?php include_once "wb_head.php" ;?>
<?php include_once "../employee_func.php";?>

<body>	
	<div class="modal-body" id="Add">
		<?php
		//
		//
		echo $__base_url;
		//
		//
		
		
			$candidate_id	= $_GET["candidate_id"];
			$candidate_name = $db->fetch_single_data("candidates","name",array("id"=>$candidate_id));
			$employee_id	= $_GET["employee_id"];
			$employee_name	= $db->fetch_single_data("employees","name",array("id"=>$employee_id));
			
			$employee_month = ($_GET["employee_month"] != "")?$_GET["employee_month"]:date("Y-m");
			$status_recruitment = ($_GET["status_recruitment"] != "")?$_GET["status_recruitment"]:"01";
			$prefix = $status_recruitment.substr($employee_month,0,4).substr($employee_month,5,2);
			
			$db->addtable("employees");$db->addfield("code");$db->awhere("code like '".$prefix."%'");$db->order("code DESC");$db->limit(1);
			$employee_code = $db->fetch_data();
			$employee_code = $employee_code["code"];
			if($employee_code == ""){
				$employee_code = $prefix."01";
			} else {
				$employee_code_now = (str_replace($prefix,"",$employee_code) * 1) + 1;
				$employee_code = $prefix.substr("00",0,2-strlen($employee_code_now)).$employee_code_now;
			}
	
			if(!$_GET["join_date"]) $_GET["join_date"] = date("Y-m-d");

			if($_GET["apply"] == 1){
				if($_GET["updating_table"] == "true"){
					$db->addtable("employees");$db->addfield("code");$db->addvalue($employee_code);$db->where("id",$_GET["employee_id"]);
					$updating = $db->update();
					if($updating["affected_rows"] > 0){
						?> <script> //parent_load('<?=$_GET["elm_return"];?>','<?=$employee_code;?>','<?=$_GET["join_date"];?>'); </script> <?php
					}
				} else {
					if($_GET["process_to_employee"] == "1"){
						// candidates
						$source = $db->fetch_all_data("candidates",[],"id='".$_GET["candidate_id"]."'")[0];
						$code = get_valid_code($_GET["code"]);
						$db->addtable("employees");
						$db->addfield("code");			$db->addvalue($code);
						$db->addfield("candidate_id");	$db->addvalue($_GET["candidate_id"]);
						$db->addfield("name");			$db->addvalue($source["name"]);
						$db->addfield("nickname");		$db->addvalue($source["nickname"]);
						$db->addfield("birthdate");		$db->addvalue($source["birthdate"]);
						$db->addfield("birthplace");	$db->addvalue($source["birthplace"]);
						$db->addfield("sex");			$db->addvalue($source["sex"]);
						$db->addfield("status_id");		$db->addvalue($source["status_id"]);
						$db->addfield("religion");		$db->addvalue($source["religion"]);
						$db->addfield("nationality");	$db->addvalue($source["nationality"]);
						$db->addfield("address");		$db->addvalue($source["address"]);
						$db->addfield("address_2");		$db->addvalue($source["address_2"]);
						$db->addfield("address_3");		$db->addvalue($source["address_3"]);
						$db->addfield("address_owner");	$db->addvalue($source["address_owner"]);
						$db->addfield("phone");			$db->addvalue($source["phone"]);
						$db->addfield("phone_2");		$db->addvalue($source["phone_2"]);
						$db->addfield("bank_name");		$db->addvalue($source["bank_name"]);
						$db->addfield("bank_account");	$db->addvalue($source["bank_account"]);
						$db->addfield("bank_holder_name");$db->addvalue($source["bank_holder_name"]);
						$db->addfield("no_kk");			$db->addvalue($source["no_kk"]);
						$db->addfield("ktp");			$db->addvalue($source["ktp"]);
						$db->addfield("npwp");			$db->addvalue($source["npwp"]);
						$db->addfield("email");			$db->addvalue($source["email"]);
						$db->addfield("attendance_id");	$db->addvalue($source["attendance_id"]);
						$db->addfield("join_indohr_at");$db->addvalue($_GET["join_date"]);
						$inserting = $db->insert();
						if($inserting["affected_rows"] > 0){
							$employee_id = $inserting["insert_id"];
							// candidate_course
							$sources = $db->fetch_all_data("candidate_course",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_course");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("degree_id");		$db->addvalue($source["degree_id"]);
								$db->addfield("course_name");	$db->addvalue($source["course_name"]);
								$db->addfield("course_year");	$db->addvalue($source["course_year"]);
								$db->insert();
							}
							// candidate_educations
							$sources = $db->fetch_all_data("candidate_educations",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_educations");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("degree_id");		$db->addvalue($source["degree_id"]);
								$db->addfield("institution");	$db->addvalue($source["institution"]);
								$db->addfield("city");			$db->addvalue($source["city"]);
								$db->addfield("major");			$db->addvalue($source["major"]);
								$db->addfield("graduation_year");$db->addvalue($source["graduation_year"]);
								$db->addfield("gpa");			$db->addvalue($source["gpa"]);
								$db->insert();
							}
							// candidate_families
							$sources = $db->fetch_all_data("candidate_families",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_families");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("relation_id");	$db->addvalue($source["relation_id"]);
								$db->addfield("fullname");		$db->addvalue($source["fullname"]);
								$db->addfield("ktp");			$db->addvalue($source["ktp"]);
								$db->addfield("birthdate");		$db->addvalue($source["birthdate"]);
								$db->addfield("degree_id");		$db->addvalue($source["degree_id"]);
								$db->addfield("occupation");	$db->addvalue($source["occupation"]);
								$db->addfield("phone");			$db->addvalue($source["phone"]);
								$db->insert();
							}
							// candidate_infos
							$sources = $db->fetch_all_data("candidate_infos",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_infos");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("info");			$db->addvalue($source["info"]);
								$db->insert();
							}
							// candidate_last_company
							$sources = $db->fetch_all_data("candidate_last_company",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_last_company");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("salary");		$db->addvalue($source["salary"]);
								$db->addfield("call_allowance");$db->addvalue($source["call_allowance"]);
								$db->addfield("insurance");		$db->addvalue($source["insurance"]);
								$db->addfield("bpjs");			$db->addvalue($source["bpjs"]);
								$db->addfield("transport");		$db->addvalue($source["transport"]);
								$db->addfield("overtime");		$db->addvalue($source["overtime"]);
								$db->addfield("other");			$db->addvalue($source["other"]);
								$db->insert();
							}
							// candidate_relations
							$sources = $db->fetch_all_data("candidate_relations",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_relations");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("relation_id");	$db->addvalue($source["relation_id"]);
								$db->addfield("fullname");		$db->addvalue($source["fullname"]);
								$db->addfield("division");		$db->addvalue($source["division"]);
								$db->addfield("location");		$db->addvalue($source["location"]);
								$db->insert();
							}
							// candidate_work_experiences
							$sources = $db->fetch_all_data("candidate_work_experiences",[],"candidate_id='".$_GET["candidate_id"]."'");
							foreach($sources as $source){
								$db->addtable("employee_work_experiences");
								$db->addfield("employee_id");	$db->addvalue($employee_id);
								$db->addfield("company_name");	$db->addvalue($source["company_name"]);
								$db->addfield("location");		$db->addvalue($source["location"]);
								$db->addfield("tasks");			$db->addvalue($source["tasks"]);
								$db->addfield("phone");			$db->addvalue($source["phone"]);
								$db->addfield("join_at");		$db->addvalue($source["join_at"]);
								$db->addfield("last_at");		$db->addvalue($source["last_at"]);
								$db->addfield("leaving_reason");$db->addvalue($source["leaving_reason"]);
								$db->insert();
							}
							?><script> 
									alert("Data kandidat sudah tersimpan sebagai Karyawan");
									window.parent.closeModal();
									window.parent.location.href="../employee_view.php?<?=url_encode("employee_id");?>=<?=url_encode($employee_id);?>";
							</script><?php
						} else {
							?><script> 
									alert("Data kandidat gagal tersimpan di data Karyawan!");
									window.parent.closeModal();
							</script><?php
						}
					} else {
						?><script> 
							window.parent.Passing('<?=$_GET["code"];?>');
						</script><?php
					}
				}
			}
		?>
		<div class="login mx-auto mw-100">
			<h5 class="text-center">Generate Code</h5>
				
				<!--form -->
				<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
					<div class="container">
						<?php include_once "../a_notification.php"; ?>
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
										<font style="color:#1a75ff;font-style:italic;">Month</font>
										<?=$f->input("employee_month",$employee_month,"type='month' onchange='reload.click();'","form-control");?>
									</div>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Status Rekrutmen</font>
										<select id="status_recruitment"  name="status_recruitment" onchange="reload.click();" class="select_form">
											<option value="01" <?=($status_recruitment == "01")?"selected":"";?>>Home Staff</option>
											<option value="02" <?=($status_recruitment == "02")?"selected":"";?>>Tenaga Lokal Reguler</option>
											<option value="03" <?=($status_recruitment == "03")?"selected":"";?>>Tenaga Lokal Desa</option>
											<option value="04" <?=($status_recruitment == "04")?"selected":"";?>>Tenaga Support</option>
										</select>
									</div>
								</div>
								<div class="row wls-contact-mid">
									<?php if($candidate_id > 0) { ?> <div class="col-md-6 col-sm-6 form-group contact-forms"> <?php } ?>
										<?php if($candidate_id > 0) { ?>
											<font style="color:#1a75ff;font-style:italic;">Join Date</font>
											<?php $type="date";} else {$type="hidden";} ?>
										<?=$f->input("join_date",$_GET["join_date"],"type='".$type."' onchange='reload.click();'","form-control");?>
									<?php if($candidate_id > 0) { ?> </div> <?php } ?>
									<div class="col-md-6 col-sm-6 form-group contact-forms">
										<font style="color:#1a75ff;font-style:italic;">Employee Code</font>
										<?=$f->input("employee_code",$employee_code,"readonly","form-control");?>
									</div>
								</div>
								<div class="text-left click-subscribe">
									<?=$f->input("reload","Reload","type='button' onclick=\"window.location='?employee_id=".$_GET["employee_id"]."&candidate_id=".$_GET["candidate_id"]."&process_to_employee=".$_GET["process_to_employee"]."&updating_table=".$_GET["updating_table"]."&function_after=".$_GET["function_after"]."&with_join_date=".$_GET["with_join_date"]."&join_date='+join_date.value+'&employee_month='+employee_month.value+'&status_recruitment='+status_recruitment.value+'&code='+employee_code.value;\"","btn btn-info");?>
									<?=$f->input("apply","Apply","type='button' onclick=\"window.location='?apply=1&employee_id=".$_GET["employee_id"]."&candidate_id=".$_GET["candidate_id"]."&process_to_employee=".$_GET["process_to_employee"]."&updating_table=".$_GET["updating_table"]."&function_after=".$_GET["function_after"]."&with_join_date=".$_GET["with_join_date"]."&join_date='+join_date.value+'&employee_month='+employee_month.value+'&status_recruitment='+status_recruitment.value+'&code='+employee_code.value;\"","btn btn-primary");?>
								</div>
							<?=$f->end();?>
						</div>
					</div>
				</section>
				<!--//form  -->
				
		</div>
	</div>
</body>	


