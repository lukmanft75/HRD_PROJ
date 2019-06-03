<div class="modal fade" id="bpjs_kesehatan" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" style="max-width:900px !important;"role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" id="close_window">&times;</span>
				</button>
			</div>
			
			<?php
				$candidate_id = GET_url_decode("candidate_id");
				$db->addtable("bpjs");
				$db->awhere("candidate_id = '".$candidate_id."' AND bpjs_type = '1'");
				$databpjs = $db->fetch_data(true);
			?>
			
			
			<?php include_once "bpjs_kesehatan_add.php";?>
			<div class="modal-body" id="List">
				<?=$f->input("div_list","List","type='hidden'");?>
				<div class="login mx-auto mw-100">
					<h5 class="text-center">BPJS Kesehatan</h5>
					<div class="table_list">
						<div style="overflow-x:auto;">
							<?=$t->start("","","data_content");?>
								<?=$t->header(["No",
												"Action",
												"Name",
												"Date of Birth",
												"PISA",
												"Sex",
												"NIK",
												"No BPJS",
												"Remarks"]);?>
								<?php 
									$i=0;
									foreach($databpjs as $no => $data){
										$i++;
										echo $f->input("key_id_".$data["id"],$data["id"],"type='hidden'");
										$actions = 	"<img src='images/edit.png' style='width:20px; height:20px;' title='Edit' onclick='bpjs_1_edit(key_id_".$data["id"].".value)'>";
										$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
										$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?".url_encode("deleting")."=".url_encode($data_candidate["id"])."';}\"><img src='images/cancel.png' style='width:20px; height:20px;' title='Deactive'></a>";
										
										echo $t->row([$i,
													$actions,
													$data["name"],
													format_tanggal($data["birthdate"],"d M Y"),
													$data["pisa"],
													$data["sex"],
													$data["ktp"],
													$data["bpjs_id"],
													$data["remarks"]],
													["align='right'",
													"",
													"align='right'",
													"",
													"align='center'",
													"align='right'",
													"align='right'",
													""]);
									}
								?>
							<?=$t->end();?>
						</div>
					</div>
						<?=$f->input("","Add","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#bpjs_kesehatan_add' onclick='bpjs_1_add(div_list.value)'", "btn btn-info");?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var screen_add = "Add";
	var screen_edit = "Edit";
	var screen_list = "List";
	
	document.getElementById(screen_add).style.display = "none";
	// document.getElementById(screen_edit).style.display = "none";
	
	function bpjs_1_add(screen_list){
		document.getElementById(screen_list).style.display = "none";
		document.getElementById(screen_add).style.display = "block";
	}
	
	function close_div(second_screen){
		document.getElementById(second_screen).style.display = "none";
		document.getElementById(screen_list).style.display = "block";
	}
	
	function bpjs_1_edit(bpjs_id){
		 window.location.assign("#edit_id="+bpjs_id);
		// // alert(bpjs_id);
		document.getElementById(screen_list).style.display = "none";
		// // document.getElementById(screen_edit).style.display = "block";
		// // document.getElementById("mungkin").innerHTML = bpjs_id;
		// $.get( "ajax/bpjs_kesehatan_edit.php?mode=edit_id&bpjs_id="+bpjs_id, function(data) {
			// $("#bpjs_kesehatan_edit").html(data);
		// });
	}
</script>