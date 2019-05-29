<div class="modal fade" id="bpjs_kesehatan" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" style="max-width:900px !important;"role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" id="close_window">&times;</span>
				</button>
			</div>
			
			<?php include_once "bpjs_kesehatan_add.php";?>
			<div class="modal-body" id="List">
				<?=$f->input("div_list","List","type='hidden'");?>
				<div class="login mx-auto mw-100">
					<h5 class="text-center">BPJS Kesehatan</h5>
					<div class="table_list">
						<div style="overflow-x:auto;">
						<?php
							$id = GET_url_decode("id");
							$db->addtable("bpjs");
							$db->awhere("candidate_id = '".$id."' AND bpjs_type = '1'");
							$databpjs = $db->fetch_data(true);
							echo $db->get_last_query();
						?>
							<?=$t->start("","","data_content");?>
								<?=$t->header(["No",
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
										echo $t->row([$i,
													"Name",
													"Date of Birth",
													"PISA",
													"Sex",
													"NIK",
													"No BPJS",
													"Remarks"]);
									}
								?>
							<?=$t->end();?>
						</div>
					</div>
						<?=$f->input("","Add","type='button' style='text-align:left !important;' data-toggle='modal' data-target='#bpjs_kesehatan_add' onclick='change(div_list.value)'", "btn btn-info");?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var screen_2 = "Add";
	document.getElementById(screen_2).style.display = "none";
	
	function change(screen_1){
		document.getElementById(screen_1).style.display = "none";
		document.getElementById(screen_2).style.display = "block";
	}
</script>