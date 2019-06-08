<?php include_once "wb_head.php" ;?>

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