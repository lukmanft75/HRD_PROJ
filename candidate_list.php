<?php
	$_isexport = false;
	if(@$_GET["export"]){
		$_exportname = "Candidate_List.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
	include_once "head.php";
	if(GET_url_decode("deleting") > 1 && $__group_id == "0"){
		$db->addtable("candidates");			$db->where("id",GET_url_decode("deleting"));
		$db->addfield("hidden");		$db->addvalue("1");
		$update = $db->update();
		$_SESSION["alert_success"] = "Data deleted successfully!";
		?>
			<script type="text/JavaScript">setTimeout("location.href = 'candidate_list.php';",1500);</script>
		<?php
	}
	
	if(!$_isexport){
	?>
	<!--Filter-->
	<div class="modal fade" id="filter_box" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="login mx-auto mw-100">
						<h5 class="text-center">Filter Box</h5>
						<?=$f->start("filter","GET");?>
							<div class="form-group ">
								<p class="mb-2">Name</p>
								<?=$f->input("name",@$_GET["name"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Year of Brithdate</p>
								<?=$f->input("year",@$_GET["year"],"type='number'","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Sex</p>
								<?=$f->select("sex",[""=>"","M"=>"M","F"=>"F"],@$_GET["sex"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Marital Status</p>
								<?=$f->select("status_id",$db->fetch_select_data("statuses","id","name",[],[],"",true),@$_GET["status_id"],"","select_filter");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Address</p>
								<?=$f->input("address",@$_GET["address"],"","form-control");?>
							</div>
							<?=$f->input("page","1","type='hidden'");?>
							<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
							<?=$f->input("do_filter","Load","type='submit' style='width:140px;'", "btn btn-primary");?>
							<?=$f->input("reset","Reset","type='button' style='width:140px;' onclick=\"window.location='?';\"", "btn btn-warning");?>
							<?=$f->input("export","Export to Excel","type='submit' style='width:170px;'","btn btn-success");?>
						<?=$f->end();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//Filter-->
	<?php } ?>
	
	<!--Table-->
	<section class="typography py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="table_list">
			<div class="sub-head mb-3 ">
			<?php include_once "a_notification.php"; ?>
				<h4>Candidate List</h4>
					<?=$f->input("add","Add","type='button' onclick=\"window.location='candidate_add.php';\"", "btn btn-primary");?>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$__group_id > 0)	$whereclause .= "hidden = '0' AND ";
				if(@$_GET["name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' AND ";
				if(@$_GET["year"]!="") $whereclause .= "birthdate LIKE '".str_replace(" ","%",$_GET["year"])."-%"."' AND ";
				if(@$_GET["sex"]!="") $whereclause .= "sex = '".$_GET["sex"]."' AND ";
				if(@$_GET["status_id"]!="") $whereclause .= "status_id = '".$_GET["sex"]."' AND ";
				if(@$_GET["address"]!="") $whereclause .= "(address LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR 
															address_2 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR
															address_3 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."' OR
															address_4 LIKE '"."%".str_replace(" ","%",$_GET["address"])."%"."'
															) AND ";

				$db->addtable("candidates");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
				$maxrow = count($db->fetch_data(true));

				$db->addtable("candidates");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
				if(@$_GET["sort"] != "") {
					if(@$_GET["desc"]) {$desc = "DESC";} else {$desc = "";}
					$db->order($_GET["sort"]." ".$desc);
				} else {$db->order("created_at DESC");}
				$db->limit($_limit);
				$candidates = $db->fetch_data(true);

				$count_data =count($db->fetch_all_data("candidates",["id"],substr($whereclause,0,-4)));
			?>
			
			<?php  if(!$_isexport){ include "a_pagination.php"; }?>
			<div class="bd-example mb-4">
				<div style="overflow-x:auto; position: relative; height: 60%; overflow: auto; display: block;">
					<?=$t->start($border_tbl,"","data_content");?>
						<?=$t->header(["No",
										"Action",
										"ID",
										"<div onclick=\"sorting('name');\">Name</div>",
										"<div onclick=\"sorting('birthdate');\">Birthdate</div>",
										"<div onclick=\"sorting('sex');\">Sex</div>",
										"<div onclick=\"sorting('status_id');\">Status</div>",
										"Address",
										"Phone",
										"<div onclick=\"sorting('bank_name');\">Bank</div>",
										"Bank Account",
										"NIK",
										"NPWP",
										"Email",
										"<div onclick=\"sorting('created_at');\">Created At</div>"]);?>
						<?php
							foreach($candidates as $data_candidate){
								$actions = 	"<a href=\"candidate_view.php?".url_encode("candidate_id")."=".url_encode($data_candidate["id"])."\"><img src='images/view.png' style='width:20px; height:20px;' title='View'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href=\"candidate_edit.php?".url_encode("candidate_id")."=".url_encode($data_candidate["id"])."\"><img src='images/edit.png' style='width:20px; height:20px;' title='Edit'></a>";
								if($__group_id == "0") {
									$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
									$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?".url_encode("deleting")."=".url_encode($data_candidate["id"])."';}\"><img src='images/cancel.png' style='width:20px; height:20px;' title='Deactive'></a>";
								}
								$inactive = "";
								$address = $data_candidate["address"];
								if($data_candidate["address_2"]) $address .= ", ".$data_candidate["address_2"];
								if($data_candidate["address_3"]) $address .= ", ".$data_candidate["address_3"];
								if($data_candidate["address_4"]) $address .= ", ".$data_candidate["address_4"];
								if($__group_id == 0 && $data_candidate["hidden"] == 1) $inactive = "background-color:#ff8080;";
								echo $t->row([
									$start++,
									$actions,
									$data_candidate["code"],
									ucwords($data_candidate["name"]),
									format_tanggal($data_candidate["birthdate"],"d M Y"),
									$data_candidate["sex"],
									$db->fetch_single_data("statuses","name",["id" => $data_candidate["status_id"]]),
									$address,
									$data_candidate["phone"],
									$data_candidate["bank_name"],
									$data_candidate["bank_account"],
									$data_candidate["ktp"],
									$data_candidate["npwp"],
									$data_candidate["email"],
									format_tanggal($data_candidate["created_at"],"d M Y")
								],[
									"style='width:3%' align=right nowrap",
									"style='width:8%;".$inactive."' align='center'",
									"",
									"",
									"align='right'",
									"align='center'",
									"align='center'",
									"",
									"align='right'",
									"",
									"align='right'",
									"align='right'",
									"align='right'",
									"",
									"align='right'"
								]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
		</div>
	</section>
	<!--//Table-->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
</body>
</html>