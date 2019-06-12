<?php 
	if($_GET["printme"] != 1){
		include_once "head.php";
	} else {
		include_once "a_common.php";
	}
?>
<?php
	$id = GET_url_decode("candidate_id");
	$candidate = $db->fetch_all_DATA("candidates",[],"id='".$id."'")[0];
	$employee_id = $db->fetch_single_data("employees","id",["candidate_id" => $id]);
?>
	
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
			<br>
			
			<?php if($_GET["printme"] != 1){ ?>
				<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
				<?=$f->input("edit","Edit","type='button' onclick=\"window.location='".str_replace("_view","_edit",$_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"]."';\"","btn btn-info");?>
				<?=$f->input("accepted_as_employee","Accepted as Employee","type='button' onclick=\"accepted_as_employee();\"","btn btn-primary");?>
				<?=$f->input("print","Print","type='button' onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&printme=1';\"","btn btn-success");?>
				<?=$f->input("code_generate","","type='hidden' style='width: 1px !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/employee_generator_code.php?candidate_id=".$id."&updating_table=false&process_to_employee=1\")'", "");?>
			<?php } ?>
			</div>
			<style type="text/css">
				#id_1 {
					border: 1px solid black; 
					background: #80ffff;
				}
				#id_2 {
					border: 1px solid black; 
					background: #ccffcc;
				}
				#id_3 {
					background: #b8b894;
					font-weight: bold;
					border: 1px solid black; 
				}
				#id_4 {
					border: 1px solid black; 
				}
				#id_5 {
					background: #ccffff;
					border: 1px solid black; 
				}
				.table_cv td{
					border: 1px solid black; 
				}
			</style>
			<table width="100%" border="3" align="center" rules="all" style="font-family: Arial;">
				<tr>
					<td colspan="19" align="center">
						<table width="100%" border="0">
							<tr>
								<td align="center" style="font-size:24px; font-weight:bold;">COMPREHENSIVE RESUME</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="19" align="center" style="padding:0">
						<table width="100%" border="0" style="font-family:Arial;font-size:14px;">
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="17" width="89.6%" align="center" style="padding:10 0 10 0"><hr width="100%" style="border-top: 2px solid #000;"></td>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
							</tr>
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Full Name</td>
								<td colspan="6" width="31.2%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$candidate["name"];?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Sex</td>
								<td colspan="4" width="20.8%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=($candidate["sex"] == "F")?"Female":"Male";?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
							</tr>
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Nick Name</td>
								<td colspan="6" width="31.2%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$candidate["nickname"];?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Marital Status</td>
								<td colspan="4" width="20.8%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$db->fetch_single_data("statuses","name",["id" => $candidate["status_id"]]);?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
							</tr>
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Place of Birth</td>
								<td colspan="6" width="31.2%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$candidate["birthplace"];?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Nationality</td>
								<td colspan="4" width="20.8%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$candidate["nationality"];?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
							</tr>
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Date of Birth</td>
								<td colspan="6" width="31.2%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=format_tanggal($candidate["birthdate"]);?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0">Religion</td>
								<td colspan="4" width="20.8%" align="left" style="padding:0 0 0 0;font-weight: bolder;">:&nbsp;&nbsp;<?=$candidate["religion"];?></td>
								<td colspan="2" width="10.4%" align="left" style="padding:0 0 0 0"></td>
							</tr>
							<tr>
								<td colspan="1" width="5.2%" align="left" style="padding:15 0 0 0"></td>
								<td colspan="10" width="52%" align="center" style="padding:15 0 0 0" valign="top">
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="10" align="center" id="id_3">HOME ADDRESS</td>
										</tr>
										<tr>
											<td colspan="7" width="70%" rowspan="4" valign="top"><?=$candidate["address"].", ".$candidate["address_2"].", ".$candidate["address_3"].", ".$candidate["address_4"];?></td>
											<td colspan="3" width="30%" align="center" id="id_5"><b>Ownership</b></td>
										</tr>
										<tr>
											<td colspan="2" width="20%" align="center">Own</td>
											<td colspan="1" width="10%" align="center"><?=($candidate["address_owner"] == "own")?"X":"";?></td>
										</tr>
										<tr>
											<td colspan="2" width="20%" align="center">Parent/Family</td>
											<td colspan="1" width="10%" align="center"><?=($candidate["address_owner"] == "parent_family")?"X":"";?></td>
										</tr>
										<tr>
											<td colspan="2" width="20%" align="center">Rent/Lease</td>
											<td colspan="1" width="10%" align="center"><?=($candidate["address_owner"] == "rent_lease")?"X":"";?></td>
										</tr>
										<tr>
											<td colspan="2" width="20%" align="center" id="id_5">Phone:</td>
											<td colspan="4" width="40%" align="center"><?=$candidate["phone"];?></td>
											<td colspan="1" width="10%" align="center" id="id_5">HP:</td>
											<td colspan="3" width="30%" align="center"><?=$candidate["phone_2"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="20%" align="center" id="id_5">Email:</td>
											<td colspan="8" width="80%" align="center"><?=$candidate["email"];?></td>
										</tr>
									</table>
								</td>
								<td colspan="1" width="5.2%" align="left" style="padding:15 0 0 0"></td>
								<td colspan="6" width="31.2%" align="center" style="padding:15 0 0 0" valign="top">
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="6" width="100%" align="center" id="id_3">SUPPORTING DATA</td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>Kartu Keluarga No.</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["no_kk"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>NIK No.</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["ktp"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>NPWP No.</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["npwp"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>Bank Account Name</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["bank_name"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>Bank Account No.</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["bank_account"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>Bank Holder Name</td>
											<td colspan="4" width="66.8%" align="center"><?=$candidate["bank_holder_name"];?></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>BPJS Ketenagakerjaan No.</td>
											<td colspan="4" width="66.8%" align="center"></td>
										</tr>
										<tr>
											<td colspan="2" width="33.2%" align="center" nowrap>BPJS Kesehatan No.</td>
											<td colspan="4" width="66.8%" align="center"></td>
										</tr>
									</table>
								</td>
								<td colspan="1" width="5.2%" align="left" style="padding:15 0 0 0"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="19" align="center" style="padding: 15 0 15 0">
						<table width="100%" border="0" style="font-family: Arial; font-size: 14px;">
							<tr>
								<td colspan="1" width="5.2%" align="left"></td>
								<td colspan="17" width="89.8%" align="center">
									<?php $candidate_families = $db->fetch_all_data("candidate_families",[],"candidate_id = '".$id."'"); ?>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="17" width="100%" align="center" id="id_3">FAMILY DATA ( SPOUSE and/or CHILDREN )</td>
										</tr>
										<tr>
											<td colspan="2" width="11.6%" align="center" valign="middle">Relation</td>
											<td colspan="6" width="34.8%" align="center" valign="middle">Full Name</td>
											<td colspan="3" width="17.4%" align="center" valign="middle">Date of Birth</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">N I K</td>
											<td colspan="2" width="11.6%" align="center" valign="middle" nowrap>Phone Number for<br>Emergency</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">Occupation</td>
										</tr>
										<?php 
											$ii = 0;
											foreach($candidate_families as $candidate_family){ 
												$ii++;
										?>
											<tr>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$db->fetch_single_data("relations","name",["id" => $candidate_family["relation_id"]]);?></td>
												<td colspan="6" width="34.8%" align="center" valign="middle"><?=$candidate_family["fullname"];?></td>
												<td colspan="3" width="17.4%" align="center" valign="middle"><?=format_tanggal($candidate_family["birthdate"]);?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_family["ktp"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_family["phone"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_family["occupation"];?></td>
											</tr>
										<?php } ?>
										<?php for($xx = $ii; $xx < 4; $xx++){ ?>
											<tr>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="6" width="34.8%" align="center" valign="middle">&nbsp;</td>
												<td colspan="3" width="17.4%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
											</tr>
										<?php } ?>
									</table>
									<br>
									<?php $candidate_educations = $db->fetch_all_data("candidate_educations",[],"candidate_id = '".$id."'"); ?>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="17" width="100%" align="center" id="id_3">EDUCATIONAL BACKGROUND</td>
										</tr>
										<tr>
											<td colspan="5" width="29%" align="center" valign="middle">Level of Study</td>
											<td colspan="5" width="29%" align="center" valign="middle">Name of Institution</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">Town/City</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">Major</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">Graduation Year</td>
											<td colspan="1" width="5.8%" align="center" valign="middle">GPA</td>
										</tr>
										<?php 
											$ii = 0;
											foreach($candidate_educations as $candidate_education){ 
												$ii++;
										?>
											<tr>
												<td colspan="5" width="29%" align="center" valign="middle"><?=$db->fetch_single_data("degrees","name",["id" => $candidate_education["degree_id"]]);?></td>
												<td colspan="5" width="29%" align="center" valign="middle"><?=$candidate_education["institution"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_education["city"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_education["major"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_education["graduation_year"];?></td>
												<td colspan="1" width="5.8%" align="center" valign="middle"><?=$candidate_education["gpa"];?></td>
											</tr>
										<?php } ?>
										<?php for($xx = $ii; $xx < 4; $xx++){ ?>
											<tr>
												<td colspan="5" width="29%" align="center" valign="middle">&nbsp;</td>
												<td colspan="5" width="29%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
												<td colspan="1" width="5.8%" align="center" valign="middle">&nbsp;</td>
											</tr>
										<?php } ?>
									</table>
									<br>
									<?php $candidate_courses = $db->fetch_all_data("candidate_course",[],"candidate_id = '".$id."'"); ?>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="17" width="100%" align="center" id="id_3">COURSE, TRAINING, SEMINAR  or NON - FORMAL EDUCATION</td>
										</tr>
										<tr>
											<td colspan="1" width="5.8%" align="center" valign="middle">No. </td>
											<td colspan="14" width="81.2%" align="center" valign="middle">Name of Course, Training, Seminar / Certificate</td>
											<td colspan="2" width="11.6%" align="center" valign="middle">Year</td>
										</tr>
										<?php 
											$ii = 0;
											foreach($candidate_courses as $candidate_course){ 
												$ii++;
										?>
											<tr>
												<td colspan="1" width="5.8%" align="center" valign="middle"><?=$ii;?></td>
												<td colspan="14" width="81.2%" align="center" valign="middle"><?=$candidate_course["course_name"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle"><?=$candidate_course["course_year"];?></td>
											</tr>
										<?php } ?>
										<?php for($xx = $ii; $xx < 4; $xx++){ ?>
											<tr>
												<td colspan="1" width="5.8%" align="center" valign="middle">&nbsp;</td>
												<td colspan="14" width="81.2%" align="center" valign="middle">&nbsp;</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">&nbsp;</td>
											</tr>
										<?php } ?>
									</table>
								</td>
								<td colspan="1" width="5.2%" align="left"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="19" align="center" style="padding: 15 0 15 0">
						<table width="100%" border="0" style="font-family: Arial; font-size: 14px;">
							<tr>
								<td colspan="1" width="5.2%" align="left"></td>
								<td colspan="17" width="89.8%" align="center">
									<?php 
										$candidate_work_experiences = $db->fetch_all_data("candidate_work_experiences",[],"candidate_id = '".$id."'"); 
										foreach($candidate_work_experiences as $candidate_work_experience){
									?>
										<table class="table_cv" width="100%">
											<tr>
												<td colspan="17" width="100%" align="center" id="id_3">WORKING EXPERIENCE ( Present or Last )</td>
											</tr>
											<tr>
												<td colspan="6" width="32.4%" align="center" valign="middle">Company</td>
												<td colspan="2" width="11.6%" align="center" valign="middle">Phone</td>
												<td colspan="9" width="52.2%" align="left" valign="middle">Join Date :&nbsp;&nbsp;&nbsp;<?=format_tanggal($candidate_work_experience["join_at"]);?></td>
											</tr>
											<tr>
												<td colspan="6" rowspan="2" width="32.4%" align="center" valign="middle"><?=$candidate_work_experience["company_name"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle" id="id_5"><?=$candidate_work_experience["phone"];?></td>
												<td colspan="9" width="52.2%" align="left" valign="middle">Last Date :&nbsp;&nbsp;&nbsp;<?=format_tanggal($candidate_work_experience["last_at"]);?></td>
											</tr>
											<tr>
												<td colspan="2" width="11.6%" align="center" valign="middle">Join Date</td>
												<td colspan="9" rowspan="2" width="52.2%" align="left" valign="top">Reason for leaving:&nbsp;&nbsp;&nbsp;<?=$candidate_work_experience["leaving_reason"];?></td>
											</tr>
											<tr>
												<td colspan="6" width="32.4%" align="left" valign="middle">Location :&nbsp;&nbsp;&nbsp;<?=$candidate_work_experience["location"];?></td>
												<td colspan="2" width="11.6%" align="center" valign="middle" id="id_5"><?=format_tanggal($candidate_work_experience["join_at"]);?></td>
											</tr>
											<tr>
												<td colspan="17" align="left" valign="top" style="padding-bottom:10">Major Tasks and Responsibilities :&nbsp;&nbsp;&nbsp;<?=$candidate_work_experience["tasks"];?></td>
											</tr>
										</table>
										<br>
									<?php } ?>

									<?php $candidate_relations = $db->fetch_all_data("candidate_relations",[],"candidate_id = '".$id."'"); ?>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="11" width="63.8%" align="left" >Do you have any relatives or friends working at this company ?</td>
											<td colspan="2" width="11.6%" align="left" id="id_5"></td>
											<td colspan="4" width="23.2%" align="left">If yes, please mention :</td>
										</tr>
									</table>
									<br>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="2" width="11.6%" align="center">Relation</td>
											<td colspan="6" width="34.2%" align="center">Full Name</td>
											<td colspan="5" width="29%" align="center">Division / Department</td>
											<td colspan="4" width="23.2%" align="center">Location</td>
										</tr>
										<?php 
											$ii = 0;
											foreach($candidate_relations as $candidate_relation){ 
												$ii++;
										?>
											<tr>
												<td colspan="2" width="11.6%" align="center"><?=$db->fetch_single_data("relations","name",["id" => $candidate_relation["relation_id"]]);?></td>
												<td colspan="6" width="34.2%" align="center"><?=$candidate_relation["fullname"];?></td>
												<td colspan="5" width="29%" align="center"><?=$candidate_relation["division"];?></td>
												<td colspan="4" width="23.2%" align="center"><?=$candidate_relation["location"];?></td>
											</tr>
										<?php } ?>
										<?php for($xx = $ii; $xx < 3; $xx++){ ?>
											<tr>
												<td colspan="2" width="11.6%" align="center">&nbsp;</td>
												<td colspan="6" width="34.2%" align="center">&nbsp;</td>
												<td colspan="5" width="29%" align="center">&nbsp;</td>
												<td colspan="4" width="23.2%" align="center">&nbsp;</td>
											</tr>
										<?php } ?>
									</table>
									<br>
								</td>
								<td colspan="1" width="5.2%" align="left"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="19" align="center" style="padding: 15 0 15 0">
						<table width="100%" border="0" style="font-family: Arial; font-size: 14px;">
							<tr>
								<td colspan="1" width="5.2%" align="left"></td>
								<td colspan="17" width="89.8%" align="center">
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="17" width="100%" align="center" id="id_3">ADDITIONAL INFORMATION RELATED WITH CORE COMPETENCIES AND TECHNICAL SKILLS</td>
										</tr>
										<tr>
											<td colspan="17" width="100%" align="center" style="padding-bottom:10"><?=$db->fetch_single_data("candidate_infos","info",["candidate_id" => $id],["id"]);?></td>
										</tr>
									</table>
									<br>
									<table class="table_cv" width="100%">
										<tr>
											<td colspan="17" width="100%" align="center" id="id_3">COMPENSATION & BENEFIT PACKAGE (Last Company)</td>
										</tr>
										<tr>
											<td colspan="2" width="11.6%" align="center">Salary (Gross)</td>
											<td colspan="2" width="11.6%" align="center">Call Allowance</td>
											<td colspan="2" width="11.6%" align="center">Insurance</td>
											<td colspan="2" width="11.6%" align="center">BPJS</td>
											<td colspan="2" width="11.6%" align="center">Transport (If any)</td>
											<td colspan="3" width="17.4%" align="center">Overtime</td>
											<td colspan="4" width="23.2%" align="center">Other</td>
										</tr>
										<?php $candidate_last_company = $db->fetch_all_data("candidate_last_company",[],"candidate_id = '".$id."'","id DESC")[0];?>
										<tr>
											<td colspan="2" width="11.6%" align="center"><?=format_amount($candidate_last_company["salary"]);?></td>
											<td colspan="2" width="11.6%" align="center"><?=format_amount($candidate_last_company["call_allowance"]);?></td>
											<td colspan="2" width="11.6%" align="center"><?=format_amount($candidate_last_company["insurance"]);?></td>
											<td colspan="2" width="11.6%" align="center"><?=format_amount($candidate_last_company["bpjs"]);?></td>
											<td colspan="2" width="11.6%" align="center"><?=format_amount($candidate_last_company["transport"]);?></td>
											<td colspan="3" width="17.4%" align="center"><?=format_amount($candidate_last_company["overtime"]);?></td>
											<td colspan="4" width="23.2%" align="center"><?=format_amount($candidate_last_company["other"]);?></td>
										</tr>
									</table>
									<br>
									<table width="100%" border="0" style="font-family: Arial; font-size: 14px;">
									<tr>
										<td colspan="17" width="100%" align="left" style="padding: 15 0 15 0">
											<b>Declare that the particulars in this resume are true and correct in every respect, I understand that if any of the particulars supplied by me are proved untrue, I am liable to be summarily dismissed.</b>
										</td>
									</tr>
									<tr>
										<td colspan="13" width="60%" align="left"></td>
										<td colspan="4" align="center" style="padding: 15 0 15 0">
											Jakarta, ................ 20.....
											<br>&nbsp;
											<br>Signature,
											<br>&nbsp;
											<br>&nbsp;
											<br>&nbsp;
											<br>&nbsp;
											<br>( .................................... )
										</td>
									</tr>
									</table>
								</td>
								<td colspan="1" width="5.2%" align="left"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div class="sub-head mb-3 ">
			<br>
			<?php if($_GET["printme"] != 1){ ?>
				<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
				<?=$f->input("edit","Edit","type='button' onclick=\"window.location='".str_replace("_view","_edit",$_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"]."';\"","btn btn-info");?>
				<?=$f->input("accepted_as_employee","Accepted as Employee","type='button' onclick=\"accepted_as_employee();\"","btn btn-primary");?>
				<?=$f->input("print","Print","type='button' onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&printme=1';\"","btn btn-success");?>
			<?php } ?>
			</div>
		</div>
	</section>
    <!--//form  -->
<script>
	function accepted_as_employee(){
		
		var passthrough = true;
		if("<?=$employee_id;?>" > "0"){
			if(!confirm("Kandidat ini sudah pernah terdaftar sebagai Karyawan. Apakah Anda ingin menambah kandidat ini sebagai Karyawan baru?")) passthrough = false;
		}
		if(passthrough) {
			generate_code('','employee_code','false','accepted_as_employee_go()',1);
		}
	}

	// function accepted_as_employee_go(){
		// window.location = "candidate_view.php?accepted_as_employee=1&id=<?=$_GET["id"];?>&code="+document.getElementById("employee_code").value+"&join_at="+document.getElementById("join_at").value;
	// }
	
	// function window_success(){
		// alert();
	// }
</script>
<?php 
	if($_GET["printme"] != 1){
		include_once "ajax/employees_js.php";
		include_once "footer.php";
		include_once "a_pop_up_js.php";
		include_once "window_boxs/wb_default.php";
	} else {
		?>
		<script>
			window.print();
			setTimeout("location.href = 'candidate_view.php?<?=url_encode("candidate_id");?>=<?=url_encode($id);?>';",0);
		</script>
		<?php
	}
?>
</body>
</html>