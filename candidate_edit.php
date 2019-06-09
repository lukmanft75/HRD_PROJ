<?php
	include_once "head.php";
	$id = GET_url_decode("candidate_id");
	$_DATA = $db->fetch_all_DATA("candidates",[],"id='".$id."'")[0];
	
	if(isset($_POST["save"])){
		$errormessage = "";
		$_POST["phone"] = msisdn_format($_POST["phone"]);
		if($errormessage == ""){
			$db->addtable("candidates");		$db->where("id",$id);
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("nickname");			$db->addvalue($_POST["nickname"]);
			$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
			$db->addfield("birthplace");		$db->addvalue($_POST["birthplace"]);
			$db->addfield("sex");				$db->addvalue($_POST["sex"]);
			$db->addfield("status_id");			$db->addvalue($_POST["status_id"]);
			$db->addfield("religion");			$db->addvalue($_POST["religion"]);
			$db->addfield("address");			$db->addvalue($_POST["address"][1]);
			$db->addfield("address_2");			$db->addvalue($_POST["address"][2]);
			$db->addfield("address_3");			$db->addvalue($_POST["address"][3]);
			$db->addfield("address_4");			$db->addvalue($_POST["address"][4]);
			$db->addfield("address_owner");		$db->addvalue($_POST["address_owner"]);
			$db->addfield("phone");				$db->addvalue($_POST["phone"]);
			$db->addfield("bank_name");			$db->addvalue($_POST["bank_name"]);
			$db->addfield("bank_account");		$db->addvalue($_POST["bank_account"]);
			$db->addfield("bank_holder_name");	$db->addvalue($_POST["bank_holder_name"]);
			$db->addfield("no_kk");				$db->addvalue($_POST["no_kk"]);
			$db->addfield("ktp");				$db->addvalue($_POST["ktp"]);
			$db->addfield("npwp");				$db->addvalue($_POST["npwp"]);
			$db->addfield("email");				$db->addvalue($_POST["email"]);
			$db->addfield("hidden");			$db->addvalue($_POST["hidden"]);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$_SESSION["alert_success"] = "Data saved successfully!";
				 ?><script type="text/JavaScript">setTimeout("location.href = 'candidate_list.php';",1500);</script><?php
			} else {
				$_SESSION["alert_danger"] = "Failed to saved!";
			}
		} else {
			$_SESSION["alert_danger"] = $errormessage;
		}
	}
?>
	
	<?=$f->input("","Details BPJS Ketenagakerjaan","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/bpjs_ketenagakerjaan_list.php?candidate_id=".$id."\")'", "btn btn-light");?>

							
							
							
							
	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>Candidate Edit</h4>
			</div>
			<div class="info-para">
			
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Name</font>
							<?=$f->input("name",@$_DATA["name"],"placeholder='' required","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Nickname</font>
							<?=$f->input("nickname",@$_DATA["nickname"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthplace</font>
							<?=$f->input("birthplace",@$_DATA["birthplace"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Birthdate</font>
							<?=$f->input("birthdate",@$_DATA["birthdate"],"placeholder='' type='date' style='height:43px;'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Sex</font>
							<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_DATA["sex"],"required","select_form");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Marital Status</font>
							<?=$f->select("status_id",$db->fetch_select_DATA("statuses","id","name",[],[],"",true),@$_DATA["status_id"],"required","select_form");?>
						</div>
					</div>
					<div class="form-group contact-forms">
						<font style="color:#1a75ff;font-style:italic;">Address</font>
						<?=$f->textarea("address[1]",@$_DATA["address"][1],"placeholder='' rows='3'","form-control");?>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Sub-District</font>
							<?=$f->input("address[2]",@$_DATA["address"][2],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">City</font>
							<?=$f->input("address[3]",@$_DATA["address"][3],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Province</font>
							<?=$f->input("address[4]",@$_DATA["address"][4],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Owner of the address</font>
							<?=$f->select("address_owner",["own" => "Own","parent_family" => "Parent/Familiy","rent_lease" => "Rent/Lease"],@$_DATA["address_owner"],"","select_form");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Religion</font>
							<?=$f->input("religion",@$_DATA["religion"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Handphone</font>
							<?=$f->input("phone",@$_DATA["phone"],"placeholder='' type='number'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Name</font>
							<?=$f->input("bank_name",@$_DATA["bank_name"],"placeholder=''","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Account</font>
							<?=$f->input("bank_account",@$_DATA["bank_account"],"placeholder='' type='number'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Bank Holder Name</font>
							<?=$f->input("bank_holder_name",@$_DATA["bank_holder_name"],"placeholder=''","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Family Card Number</font>
							<?=$f->input("no_kk",@$_DATA["no_kk"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NIK</font>
							<?=$f->input("ktp",@$_DATA["ktp"],"placeholder='' type='number' required","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">NPWP</font>
							<?=$f->input("npwp",@$_DATA["npwp"],"placeholder='' type='number'","form-control");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">Email</font>
							<?=$f->input("email",@$_DATA["email"],"placeholder='' type='email'","form-control");?>
						</div>
					</div>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">BPJS Kesehatan</font>
							<?=$f->input("kesehatan","Details BPJS Kesehatan","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/bpjs_kesehatan_list.php?candidate_id=".$id."\")'", "btn btn-light");?>
						</div>
						<div class="col-md-6 col-sm-6 form-group contact-forms">
							<font style="color:#1a75ff;font-style:italic;">BPJS Ketenagakerjaan</font>
							<?=$f->input("ketenagakerjaan","Details BPJS Ketenagakerjaan","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#window_boxs' onclick='SetPage(\"window_boxs/bpjs_ketenagakerjaan_list.php?candidate_id=".$id."\")'", "btn btn-light");?>
						</div>
					</div>
					<div class="form-group">
						<font style="color:red;font-style:italic;">Data Status</font>
						<?=$f->select("hidden",["0" => "Active","1" => "Not Active"],@$_DATA["hidden"],"","select_form");?>
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
	include_once "window_boxs/wb_default.php";
?>
<script type="text/javascript"> 
	document.getElementById("name").focus(); 
	
	function window_box_success(){
		// alert('<?=$__base_url;?>');
		$('#List').load('<?=$__base_url;?> #List');
		document.getElementById("kesehatan").click();
	}
</script>
</body>
</html>