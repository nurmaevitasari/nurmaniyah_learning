<?php $user = $this->session->userdata('myuser'); 
$file_url = $this->config->item('file_url');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="index, nofollow">
		<title>MY IIOS</title>
		<!-- BOOTSTRAP STYLES -->
		<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
		<!-- FONTAWESOME STYLES-->
		<link href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" />
		<!-- GOOGLE FONTS-->
		<link href="<?php echo base_url('assets/css/google-fonts.css'); ?>" rel='stylesheet' type='text/css' />

		<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css'); ?> ">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<?php if (!empty($extra['css'])) : foreach ($extra['css'] as $css_file) : ?>
						<link href="<?php echo base_url($css_file); ?>" rel="stylesheet" />
						<?php
				endforeach;
		endif;
		?>

		<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
   		<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
	 	<script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
	  	<script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/moment.min.js'); ?>"></script>
  		<script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
  		<script src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
  		<!-- <style type="text/css">
  			body {
			  -webkit-user-select: none;
			     -moz-user-select: -moz-none;
			      -ms-user-select: none;
			          user-select: none;
			}

			input, textarea {
			     -moz-user-select: text;
			}
  		</style> -->

	</head>

	<body >
		<div id="wrapper">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="adjust-nav">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">MY IIOS</a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">

						</ul>
					</div>
				</div>
			</div>
			<!-- /. NAV TOP  -->
			<nav class="navbar-default navbar-side" role="navigation">
				<div class="sidebar-collapse" >
					<ul class="nav" id="main-menu">
						<li class="text-center user-image-back">
							<img src="<?php echo base_url('assets/images/Indotara ISO.jpg')?>" class="img-responsive" />
						</li>
						<li>
							<a href="#"><i class="fa fa-calendar "></i><?php echo date('l, d-m-Y')?></a>
						</li>
						<!-- <li>
							<a href="#"><i class="fa fa-clock-o" ></i><span id="clock"></span></a>
						</li> -->
						<li>
							<a  href="<?php echo site_url('home/logout'); ?>" onclick="return confirm('Apakah anda yakin keluar dari Myiios ?')"><i class="fa fa-power-off"></i>Logout</a>
						</li>
						<li>
							<a href="<?php echo site_url('home'); ?>"><i class="fa fa-desktop "></i>Dashboard</a>
						</li>

<!-- =======ADMIN=================================================ADMIN================ -->
						<?php if($user['role_id'] == 1){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Admin : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<?php if(in_array($user['position_id'], array('1','2','77','3','14', '55', '56', '57', '95'))) { ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>CRM<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								
								<li>
									<a href="<?php echo site_url('crm/add'); ?>"><i class="fa fa-edit"></i>New CRM</a>
								</li>
								<li>
									<a href="<?php echo site_url('crm'); ?>"><i class="fa fa-table"></i>Table CRM</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if(in_array($user['position_id'], array('1', '2', '77', '14','3'))) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customers'); ?>"><i class="fa fa-list"></i>Customers List</a>
							</li>
						</ul>
						</li>
						<?php } ?>
						<?php if($user['position_id'] != '13' AND $user['position_id'] != '102') {  ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/add/it'); ?>"><i class="fa fa-edit"></i>Delivery Transfer</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
								<?php if(in_array($user['position_id'], array('1','2','77','14','55', '56', '57','58','59'))) { ?>
								<li>
									<a href="<?php echo site_url('C_delivery/do_receipt'); ?>"><i class="fa fa-table"></i>Serah Terima DO</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<?php if(!in_array($user['position_id'], array('3', '58', '59'))) { ?>
								<li>
									<a href="<?php echo site_url('c_artikel'); ?>"><i class = "fa fa-folder-open"></i> Artikel</a>
								</li>
								<?php } ?>
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<?php if(!in_array($user['position_id'], array('3', '13', '59', '102'))) { ?>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<?php } ?>
								<?php if(in_array($user['position_id'], array('1', '2','77','14'))) { ?>
								<li>
									<a href="<?php echo site_url('c_upload_qc'); ?>"><i class="fa fa-folder-open"></i>Files QC</a>
								</li>
								<?php } ?>
						
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
							
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<?php if($user['position_id'] != '58' AND $user['position_id'] != '59' AND $user['karyawan_id'] != '126') { ?>
								<li>
									<a href="<?php echo site_url('c_upload'); ?>"><i class="fa fa-folder-open"></i>Pricelist</a>
								</li>
								<?php } ?>
								<?php if($user['position_id'] != '13' AND $user['position_id'] != '102') { ?>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
								<?php } ?>
								
								<?php if(!in_array($user['position_id'], array('13', '102','3'))) { ?>
								<li>
									<a href="<?php echo site_url('c_point/point_teknisi'); ?>"><i class = "fa fa-folder-open"></i>Table Point Teknisi</a>
								</li>
								<?php } ?>
								<?php if($user['position_id'] == 1 OR $user['position_id'] == 2 OR $user['position_id'] == 14){  ?>
								<li>
									<a href="<?php echo site_url('c_point'); ?>"><i class = "fa fa-folder-open"></i> Tariff Point Teknisi</a>
								</li>
								<?php } ?>
								<?php if(!in_array($user['position_id'], array('3', '58', '59'))) { ?>
								<li>
									<a href="<?php echo site_url('c_tbl_wa/')?>"><i class="fa fa-folder-open"></i>WA Material</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if(in_array($user['position_id'], array('1', '2', '77', '14'))) { ?>
								<li>
									<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_employee_admin/add'); ?>"><i class="fa fa-edit"></i>Create New Employees</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_employee_admin'); ?>"><i class="fa fa-list"></i>Employees List</a>
										</li>
									</ul>
								</li>
								<li>
									<a href=""><i class="fa fa-user"></i>User<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_admin/add'); ?>"><i class="fa fa-edit"></i>Create New User</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_admin'); ?>"><i class="fa fa-list"></i>Users List</a>
										</li>
									</ul>
								</li>

								<li>
									<a href=""><i class="fa fa-tasks"></i>Position<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_position/add'); ?>"><i class="fa fa-edit"></i>Add New Position</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_position'); ?>"><i class="fa fa-list"></i>Positions List</a>
										</li>
									</ul>
								</li>
                                <li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
								<?php } ?>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<?php if($user['position_id'] != '102') { ?>
								<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<?php } ?>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<?php if($user['position_id'] != '13' AND $user['position_id'] != '102') { ?>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
								<?php if ($user['position_id'] == 2): ?>
								<li>
									<a href="<?php echo site_url('C_new_import/add'); ?>"><i class="fa fa-edit"></i>New Import</a>
								</li>
								<?php endif ?>
							</ul>
						</li>
						<?php } ?>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/showAll'); ?>">Proposal SOP</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
								</li>
							</ul>
						</li>
						<?php if($user['position_id'] != '13' AND $user['position_id'] != '102') { ?>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if(!in_array($user['position_id'], array('13', '102','59'))) { ?>
							<li>
								<a href="<?php echo site_url('project'); ?>"><i class="fa fa-table"></i>Project DHC</a>
							</li>
						<?php } ?>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<?php //if($user['position_id'] != '13' AND $user['position_id'] != '102'){  ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								
									<li>
										<a href="<?php echo site_url('c_new_sps/Rekondisi'); ?>"><i class="fa fa-edit"></i>New SPS Rekondisi</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
									</li>

								</ul>
						</li>
						<?php //} ?>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
							</ul>
						</li>

						<!-- <li>
							<a href=""><i class="fa fa-gear"></i>Technician<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php //echo site_url('c_teknisi'); ?>"><i class="fa fa-gears"></i>Status Penyelesaian SPS</a>
							</li>

						</ul>
						</li> -->

<!-- =======SALES============================================SALES================ -->

						<?php }elseif($user['role_id'] == 2){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Sales : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>CRM<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('crm/add'); ?>"><i class="fa fa-edit"></i>New CRM</a>
								</li>
								<li>
									<a href="<?php echo site_url('crm'); ?>"><i class="fa fa-table"></i>Table CRM</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/add/it'); ?>"><i class="fa fa-edit"></i>Delivery Transfer</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_artikel'); ?>"><i class = "fa fa-folder-open"></i> Artikel</a>
								</li>
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<?php if(in_array($user['position_id'], array('15', '67', '93'))) { ?>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<?php } ?>
								<?php if(in_array($user['position_id'], array('88', '89', '90', '91', '92','93', '100'))) { ?>
									<li>
									<a href="<?php echo site_url('c_upload_qc'); ?>"><i class="fa fa-folder-open"></i>Files QC</a>
								</li>
								<?php	} ?>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								
								<li>
									<a href="<?php echo site_url('c_upload'); ?>"><i class="fa fa-folder-open"></i>Pricelist</a>
								</li>
							
								<?php if(in_array($user['position_id'], array('15','91','71'))) { ?>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
								<?php } ?>
								<?php if(in_array($user['position_id'], array('88', '89', '90', '91', '92', '93', '100'))) { ?>
								<li>
									<a href="<?php echo site_url('c_point/point_teknisi'); ?>"><i class = "fa fa-folder-open"></i>Table Point Teknisi</a>
								</li>
								<?php	} ?>
								<li>
									<a href="<?php echo site_url('c_tbl_wa/')?>"><i class="fa fa-folder-open"></i>WA Material</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<?php if(in_array($user['position_id'], array('88','89','90','91','92','93', '100'))) { ?>
								<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<?php } ?>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
							</ul>
						</li>
						<?php
						$divisi = substr($user['position'], -3);

						if(in_array($user['position_id'], array('88', '89', '90', '91', '92', '93', '100'))) { ?>
							<li>
								<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('C_sop/showAll'); ?>">Proposal SOP</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
									</li>
								</ul>
							</li>
						<?php }elseif($divisi == 'les'){ ?>
							<li>
								<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('C_sop/index/65') ?>">DHC</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/index/66') ?>">DRE</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/index/68') ?>">DCE</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/index/71'); ?>">DHE</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/index/72'); ?>">DGC</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_sop/index/67'); ?>">DEE</a>
									</li>
							</ul>
							</li>
						<?php	}else{ ?>
							<li>
								<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('C_sop/index/'.$user['position_id']) ?>"><?php echo $divisi; ?></a>
									</li>
								</ul>
							</li>
						<?php	} ?>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<?php if(in_array($user['position_id'], array('88','65','15'))) { ?>
							<li>
								<a href="<?php echo site_url('project'); ?>"><i class="fa fa-table"></i>Project DHC</a>
							</li>
						<?php } ?>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_new_sps/Rekondisi'); ?>"><i class="fa fa-edit"></i>New SPS Rekondisi</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps_admin/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps_admin/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps_admin/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ==========SERVICES==============================SERVICES====================== -->

						<?php }elseif ($user['role_id'] == 3){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Service : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
							</li>
						</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/do_receipt'); ?>"><i class="fa fa-table"></i>Serah Terima DO</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo site_url('C_sop/index/'.$user['position_id']) ?>">Admin Service</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_new_sps/Rekondisi'); ?>"><i class="fa fa-edit"></i>New SPS Rekondisi</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

		<!-- =========TEKNISI===============================================TEKNISI=================== -->

						<?php }elseif ($user['role_id'] == 4) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Teknisi : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
						<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
							</li>
							<li>
								<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
							</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<?php if(in_array($user['position_id'], array('74','29', '33'))) { ?>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
								<?php } ?>
								<li>
									<a href="<?php echo site_url('c_point/point_teknisi'); ?>"><i class = "fa fa-folder-open"></i>Table Point Teknisi</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<?php if(in_array($user['position_id'], array('29','30','27', '28'))) { ?>
								<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<?php } ?>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<?php if($user['position'] == 'Teknisi') { ?>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/84') ?>">Teknisi DEE</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/85') ?>">Teknisi DHE & DGC</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/86') ?>">Teknisi DRE & DCE</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/28') ?>">Teknisi DHC</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']); ?>">Teknisi</a>
								</li>
							</ul>
							<?php }elseif ($user['position_id'] == '27') { ?>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/27') ?>">Leader Teknisi DEE</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/84') ?>">Helper Teknisi DEE</a>
								</li>
							</ul>
							<?php }elseif ($user['position_id'] == '29') { ?>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/29') ?>">Leader Teknisi DHE & DGC</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/85') ?>">Helper Teknisi DHE & DGC</a>
								</li>
							</ul>
							<?php }elseif($user['position_id'] == '30') { ?>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/30') ?>">Leader Teknisi DRE & DCE</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/86') ?>">Helper Teknisi DRE & DCE</a>
								</li>
							</ul>
							<?php }else{ ?>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']) ?>"><?php echo $user['position']; ?></a>
								</li>
							</ul>
							<?php } ?>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<?php if ($user['position_id'] == '28') { ?>
						<li>
							<a href="<?php echo site_url('project'); ?>"><i class="fa fa-table"></i>Project DHC</a>
						</li>
						<?php } ?>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>
						

<!-- =========DELIVERY===================================DELVERY==================== -->

						<?php }elseif ($user['role_id'] == 5){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Delivery : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
						<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
							</li>
							<li>
								<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
							</li>
							<li>
								<a href="<?php echo site_url('C_delivery/do_receipt'); ?>"><i class="fa fa-table"></i>Serah Terima DO</a>
							</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']) ?>"><?php echo $user['position']; ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>

							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ==========FINANCE / ACCOUNTING=============================FINANCE/ACCOUNTING=========== -->

						<?php }elseif ($user['role_id'] == 6) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>FA : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<?php if(in_array($user['position_id'], array('7','9'))) { ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>CRM<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('crm'); ?>"><i class="fa fa-table"></i>Table CRM</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if(in_array($user['position_id'], array('9','7'))) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_customers'); ?>"><i class="fa fa-list"></i>Customers List</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if(in_array($user['position_id'], array('9','11','8','18','60','62','75','76', '12'))) { ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/add/it'); ?>"><i class="fa fa-edit"></i>Delivery Transfer</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/do_receipt'); ?>"><i class="fa fa-table"></i>Serah Terima DO</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								
								<?php if($user['position_id'] == '76') { ?>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<?php } ?>
								
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<?php if(in_array($user['position_id'], array('5','9','8'))) { ?>
								<li>
									<a href="<?php echo site_url('c_upload'); ?>"><i class="fa fa-folder-open"></i>Pricelist</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php if($user['position_id'] == '18') { ?>
						<li>
							<a href="<?php echo site_url('c_import'); ?>"><i class="glyphicon glyphicon-import"></i>Table Import</a>
						</li>
						<?php } ?>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<?php if($user['position_id'] != '18') { ?>
						<li>
							<a href="<?php echo site_url('c_import'); ?>"><i class="glyphicon glyphicon-import"></i>Table Import</a>
						</li>
						<?php } ?>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']) ?>"><?php echo $user['position']; ?></a>
								</li>
							</ul>
						</li>
						<?php if(in_array($user['position_id'], array('12'))) { ?>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php if(in_array($user['position_id'], array('9'))) { ?>
							<li>
								<a href="<?php echo site_url('project'); ?>"><i class="fa fa-table"></i>Project DHC</a>
							</li>
						<?php } ?>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<?php if(in_array($user['position_id'], array('9','11','8','18', '60', '62', '75','76'))) { ?>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<?php } ?>	
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ===========INVENTORY============================INVENTORY======================= -->

						<?php }elseif ($user['role_id'] == 7) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Inventory : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<?php if($user['position_id'] == '36' OR $user['position_id'] == '82') { ?>
									<li>
										<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
									</li>
								<?php } ?>	
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
							<?php if($user['position_id'] == '82') { ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/82'); ?>">KaBag. Logistik</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/36'); ?>">Leader Inventory</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/22'); ?>">Staff Inventory</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/21'); ?>">Staff Inventory Sparepart</a>
								</li>
							<?php }elseif($user['position_id'] == '36') { ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/36'); ?>">Leader Inventory</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/22'); ?>">Staff Inventory</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/21'); ?>">Staff Inventory Sparepart</a>
								</li>
							<?php }else { ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']); ?>"><?php echo $user['position']; ?></a>
								</li>
							<?php } ?>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>				

<!-- ===========HRD=============HRD============================HRD==================== -->

						<?php  }elseif($user['role_id'] == 8) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>HRD : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_employee_admin/add'); ?>"><i class="fa fa-edit"></i>Create New Employees</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_employee_admin'); ?>"><i class="fa fa-list"></i>Employees List</a>
										</li>
									</ul>
								</li>
								<li>
									<a href=""><i class="fa fa-user"></i>User<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_admin/add'); ?>"><i class="fa fa-edit"></i>Create New User</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_admin'); ?>"><i class="fa fa-list"></i>Users List</a>
										</li>
									</ul>
								</li>
								<li>
									<a href=""><i class="fa fa-tasks"></i>Position<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_position/add'); ?>"><i class="fa fa-edit"></i>Add New Position</a>
										</li>
										<li>
											<a href="<?php echo site_url('c_position'); ?>"><i class="fa fa-list"></i>Positions List</a>
										</li>
									</ul>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/showAll'); ?>">Proposal SOP</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- =========IMPORT===============IMPORT=============================IMPORT============ -->

						<?php }elseif($user['role_id'] == 9){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Import : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload'); ?>"><i class="fa fa-folder-open"></i>Pricelist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_new_import/add'); ?>"><i class="fa fa-edit"></i>New Import</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="<?php echo site_url('C_sop/index/'.$user['position_id']); ?>"><?php echo $user['position']; ?></a></li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- =========PURCHASING================================PURCHASING================= -->

						<?php }elseif($user['role_id'] == 10){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Purchasing : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']); ?>"><?php echo $user['position']; ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>
						

<!-- ############ QC - Quality Control ############################################################# -->

						<?php	}elseif($user['role_id'] == 11){ ?>
							<li>
							<a href=""><i class="fa fa-user"></i>QC : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<?php if ($user['position_id'] == '38'): ?>
									<li>
									<a href="<?php echo site_url('c_absen'); ?>"><i class="fa fa-list "></i>Data Absensi Karyawan</a>
								</li>
								<?php endif ?>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($user['position_id'] == '38') { ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/38'); ?>">Leader QC</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/32'); ?>">Staff QC</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/index/39'); ?>">Staff QC Repair</a>
								</li>
								<?php }elseif($user['position_id'] == '32') { ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/32'); ?>">Staff QC</a>
								</li>
								<?php }elseif($user['position_id'] == '39'){ ?>
								<li>
									<a href="<?php echo site_url('C_sop/index/39'); ?>">Staff QC Repair</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ######## WORKSHOP ################################################# WORKSHOP ###################### -->
						<?php	}elseif ($user['role_id'] == 12) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Workshop : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/index/'.$user['position_id']); ?>"><?php echo $user['position']; ?></a>
								</li>
							</ul>
						</li>
						<li>
							<a href="<?php echo site_url('project'); ?>"><i class="fa fa-table"></i>Project DHC</a>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tablesps/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ### UMUM ############################### UMUM ########################## UMUM ########################## -->
						<?php }elseif ($user['role_id'] == 13) { ?>
							<li>
							<a href=""><i class="fa fa-user"></i>Umum : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ###### DRIVER ################################ DRIVER ################################# DRIVER ############### -->
						<?php }elseif ($user['role_id'] == 14) { ?>
							<li>
							<a href=""><i class="fa fa-user"></i>Driver : <?php echo $user['nama']; ?><span class="fa arrow"></span></a>

							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_admin/change_password'); ?>"><i class="fa fa-edit"></i>Change Password</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_form_registered'); ?>"><i class="fa fa-folder-open"></i>Form Registered</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
									</li>
								</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/new_tool'); ?>"><i class="fa fa-edit"></i>New Tools</a>
								</li>
							</ul>
						</li>

<!-- ########## GUEST ####################################### GUEST ########################################### -->
						<?php	}elseif ($user['role_id'] == 15) { ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Guest : <?php echo $user['nama']; ?></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-file-text"></i>Activity & Wishlist<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_wishlist/daily_activity'); ?>">Daily Activity</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_wishlist'); ?>">Wishlist</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-folder "></i>Folders<span class = "fa arrow"></span></a>
							<ul class = "nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_artikel'); ?>"><i class = "fa fa-folder-open"></i> Artikel</a>
								</li>
								<li>
									<a href="#"><i class="fa fa-folder-open "></i>Cara Mengisi Form SPT<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 S.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 S.mp4</a>
										</li>
										<li>
											<a href="<?php echo $file_url.'assets/images/upload_spt/EFiling SPT 1770 SS.mp4'; ?>" target="_blank"><i class="fa fa-film"></i>EFiling SPT 1770 SS.mp4</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload/data_pel/'); ?>"><i class="fa fa-folder-open"></i>Data PEL</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload_qc'); ?>"><i class="fa fa-folder-open"></i>Files QC</a>
								</li>
								<li>
									<a href="<?php echo $file_url.'assets/images/upload_spt/pph21+memo.pdf'; ?>" target="_blank"><i class="fa fa-file-text"></i> Memo Pph21</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_upload'); ?>"><i class="fa fa-folder-open"></i>Pricelist</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_sparepart/')?>"><i class="fa fa-folder-open"></i>Spareparts Hand Pallet</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_point/point_teknisi'); ?>"><i class = "fa fa-folder-open"></i>Table Point Teknisi</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_point'); ?>"><i class = "fa fa-folder-open"></i> Tariff Point Teknisi</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_tbl_wa/')?>"><i class="fa fa-folder-open"></i>WA Material</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>CRM<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('crm'); ?>"><i class="fa fa-table"></i>Table CRM</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>SPS<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/'); ?>"><i class="fa fa-table"></i>Table SPS</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/8'); ?>"><i class="fa fa-table"></i>Persiapan Barang</a>
									</li>
									<li>
										<a href="<?php echo site_url('C_tablesps_admin/selected/101'); ?>"><i class="fa fa-table"></i>SPS Finished</a>
									</li>
								</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-table "></i>Delivery<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery'); ?>"><i class="fa fa-table"></i>Delivery</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/term/delivery_finished'); ?>"><i class="fa fa-table"></i>Delivery Finished</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_delivery/do_receipt'); ?>"><i class="fa fa-table"></i>Serah Terima DO</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-book"></i>MY SOP<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_sop/showAll'); ?>">Proposal SOP</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_sop/table_sop'); ?>">Table SOP</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-users"></i>HRD<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_employee'); ?>"><i class="fa fa-list"></i>Employees List</a>
										</li>
									</ul>
								</li>
								<li>
									<a href=""><i class="fa fa-user"></i>User<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_admin'); ?>"><i class="fa fa-list"></i>Users List</a>
										</li>
									</ul>
								</li>
								<li>
									<a href=""><i class="fa fa-tasks"></i>Position<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="<?php echo site_url('c_position'); ?>"><i class="fa fa-list"></i>Positions List</a>
										</li>
									</ul>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Struktur Organisasi Indotara Persada_260318.pdf'; ?>"><i class="fa fa-sitemap"></i>Struktur Organisasi</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN PERUSAHAAN_HRD 170315.pdf'; ?>"><i class="fa fa-book"></i>Peraturan Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/PERATURAN MESS PERUSAHAAN.pdf'; ?>"><i class="fa fa-home"></i>Peraturan Mess Perusahaan</a>
								</li>
								<li>
									<a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/Contact User Indotara Persada(1).pdf'; ?>"><i class="glyphicon glyphicon-book"></i>Contact User Indotara</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_imp'); ?>"><i class="fa fa-pencil-square-o "></i>IMP</a>
								</li>
								<li>
									<a href="<?php echo site_url('user_log'); ?>"><i class="fa fa-sitemap"></i>User Log</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-import"></i>Import<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_import'); ?>"><i class="fa fa-table"></i>Table Import</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="glyphicon glyphicon-shopping-cart"></i>Purchasing<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('cash'); ?>"><i class="fa fa-money"></i>Cash Advance / Expenses</a>
								</li>
								<li>
									<a href="<?php echo site_url('c_purchasing/tablePR'); ?>"><i class="fa fa-table"></i>Table Purchasing</a>
								</li>

							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-cogs"></i>Tools<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('C_tools'); ?>"><i class="fa fa-user"></i>List Holder Tools</a>
								</li>
								<li>
									<a href="<?php echo site_url('C_tools/listTools'); ?>"><i class="fa fa-list"></i>List Tools</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_customers'); ?>"><i class="fa fa-list"></i>Customers List</a>
								</li>
							</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo site_url('c_products'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>
								</li>
							</ul>
						</li>
						<?php	} ?>
					</ul>
                </div>
			</nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <?php $this->load->view($view); ?>
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <!-- BOOTSTRAP SCRIPTS -->

    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo base_url('assets/js/jquery.metisMenu.js'); ?>"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>

	<script src="<?php echo base_url('assets/js/base/global.main.js'); ?>"></script>

	<?php
		$class  = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$path = getcwd();
		//print_r($method);
	?>
	<?php if(file_exists($path.'/assets/js/base/'.$class.'/'.$method.'.js')): ?>
			<script src="<?php echo base_url('assets/js/base/'.$class.'/'.$method.'.js'); ?>"></script>
		<?php else: ?>
		<?php endif; ?>



 <script type="text/javascript">
	$('select').select2();

	var BASE_URL = '<?php echo base_url(); ?>';
	var SITE_URL = '<?php echo site_url(); ?>/';

	var global = GlobalJs.createIt({
			siteUrl: SITE_URL,
			baseUrl: BASE_URL
	});

 global.init();
	if (typeof BaseJs != 'undefined') {
			var baseJs = BaseJs.createIt({
					siteURL  : SITE_URL,
					baseURL: BASE_URL,
					globalJs: global,
			});

			baseJs.init();

	}else {
		console.log(typeof BaseJs);
		//minimumResultsForSearch: -1,
	}
</script>

	 <script type="text/javascript">
	  //$('select').select2();
	  	//minimumResultsForSearch: -1,
	</script>

<script type="text/javascript">
    //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    /* function displayTime(){
        //buat object date berdasarkan waktu saat ini
        var time = new Date();
        //ambil nilai jam,
        //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length
        var sh = time.getHours() + "";
        //ambil nilai menit
        var sm = time.getMinutes() + "";
        //ambil nilai detik
        var ss = time.getSeconds() + "";
        //tampilkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
        document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
    } */

   /*  $(document).ready(function()
	{
       	$(document).bind("contextmenu",function(e){
            return false;
       	});
	}); */
</script>

<?php include "akses_log.php"; ?>

</body>
</html>
