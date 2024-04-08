<?php $user = $this->session->userdata('myuser'); ?>
<?php //var_dump($user); exit; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>MY SPS APPLICATION</title>
		<!-- BOOTSTRAP STYLES -->
		<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" />
		<!-- FONTAWESOME STYLES-->
		<link href="<?php echo base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" />
		<!-- GOOGLE FONTS-->
		<link href="<?php echo base_url('assets/css/google-fonts.css'); ?>" rel='stylesheet' type='text/css' />
		
		<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />

		<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    
		
		
	</head>
	<body onload="displayTime();setInterval('displayTime()', 1000);" >
		<div id="wrapper">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="adjust-nav">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">MY SPS</a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li ><a  href="<?php echo site_url('home/logout'); ?>">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /. NAV TOP  -->
			<nav class="navbar-default navbar-side" role="navigation">
				<div class="sidebar-collapse" >
					<ul class="nav" id="main-menu">
						<li class="text-center user-image-back">
							<img src="<?php echo base_url('assets/images/indotara1.png')?>" class="img-responsive" />
						</li>
						<li>
							<a href="#"><i class="fa fa-calendar "></i><?php echo date('l, d-m-Y')?></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-clock-o" ></i><span id="clock"></span></a>
						</li>
						<li>
							<a href="#"><i class="fa fa-desktop "></i>Dashboard</a>
						</li>
						<?php if($user['role_id'] == 1){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Admin : <?php echo $user['nama']; ?></a>
						</li>
						<li>
							<a href="<?php echo site_url('c_tablesps_admin'); ?>"><i class="fa fa-table "></i>Table SPS</a>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>User<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_admin/add'); ?>"><i class="fa fa-edit"></i>Create New User</a>								
							</li>
							<li>
								<a href="<?php echo site_url('c_admin'); ?>"><i class="fa fa-list"></i>Users List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_employee_admin/add'); ?>"><i class="fa fa-edit"></i>Create New Employees</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_employee_admin'); ?>"><i class="fa fa-list"></i>Employees List</a>
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-tasks"></i>Position<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_position/add'); ?>"><i class="fa fa-edit"></i>Add New Position</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_position'); ?>"><i class="fa fa-list"></i>Positions List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customer/add'); ?>"><i class="fa fa-edit"></i>Create New Customer</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_customer'); ?>"><i class="fa fa-list"></i>Customers List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_product'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-folder-open"></i>Forms<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">	
							<li>
								<a href="<?php echo site_url('c_new_sps/add'); ?>"><i class="fa fa-edit"></i>SPS</a>
							</li>
							<!-- <li>
								<a href="<?php echo site_url('c_req_sparepart'); ?>"><i class="fa fa-edit"></i>Request Sparepart</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_new_po'); ?>"><i class="fa fa-edit"></i>PO</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_new_so'); ?>"><i class="fa fa-edit"></i>SO</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_new_do'); ?>"><i class="fa fa-edit"></i>DO</a>
							</li> -->
						</ul>
						</li>
						<?php }elseif($user['role_id'] == 2){ ?>
						<li>
							<a href=""><i class="fa fa-user"></i>Sales : <?php echo $user['nama']; ?></a>
						</li>
						<li>
							<a href="<?php echo site_url('c_tablesps_admin'); ?>"><i class="fa fa-table "></i>Table SPS</a>
						</li>
						<li>
							<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_employee'); ?>"><i class="fa fa-list"></i>Employees List</a>
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customer/add'); ?>"><i class="fa fa-edit"></i>Create New Customer</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_customer'); ?>"><i class="fa fa-list"></i>Customers List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_product'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>								
							</li>
						</ul>
						</li>	
						<li>
							<a href=""><i class="fa fa-folder-open"></i>Forms<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">	
							<li>
								<a href="<?php echo site_url('c_new_sps/add'); ?>"><i class="fa fa-edit"></i>SPS</a>
							</li>
							<!-- <li>
								<a href="<?php echo site_url('c_new_po'); ?>"><i class="fa fa-edit"></i>PO</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_new_so'); ?>"><i class="fa fa-edit"></i>SO</a>
							</li> -->
						</ul>
						</li>	
						<?php }elseif ($user['role_id'] == 3){ ?>
							<li>
								<a href=""><i class="fa fa-user"></i>Kepala Service : <?php echo $user['nama']; ?></a>
							</li>
						<li>
							<a href="<?php echo site_url('c_redirect_sps'); ?>"><i class="fa fa-table "></i>Table SPS</a>
						</li>
						<li>
							<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_employee'); ?>"><i class="fa fa-list"></i>Employees List</a>
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customer'); ?>"><i class="fa fa-list"></i>Customers List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_product'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-folder-open"></i>Forms<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_req_sparepart'); ?>"><i class="fa fa-edit"></i>Request Sparepart</a>
							</li>
						</ul>
						</li>
						<?php }elseif ($user['role_id'] == 4) { ?>
							<li>
								<a href=""><i class="fa fa-user"></i>Teknisi : <?php echo $user['nama']; ?></a>
							</li>
							<li>
							<a href="<?php echo site_url('c_redirect_sps'); ?>"><i class="fa fa-table "></i>Table SPS</a>
						</li>
						<li>
							<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_employee'); ?>"><i class="fa fa-list"></i>Employees List</a>
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customer/add'); ?>"><i class="fa fa-edit"></i>Create New Customer</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_customer'); ?>"><i class="fa fa-list"></i>Customers List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_product'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>								
							</li>
						</ul>
						</li>	
							<li>
								<a href=""><i class="fa fa-folder-open"></i>Forms<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">	
							<li>
								<a href="<?php echo site_url('c_req_sparepart'); ?>"><i class="fa fa-edit"></i>Request Sparepart</a>
							</li>
						</ul>
						</li>
						<?php }else{ ?>
							<li>
								<a href=""><i class="fa fa-user"></i>Delivery : <?php echo $user['nama']; ?></a>
							</li>
							<li>
							<a href="<?php echo site_url('c_redirect_sps'); ?>"><i class="fa fa-table "></i>Table SPS</a>
						</li>
						<li>
							<a href=""><i class="fa fa-briefcase"></i>Employees<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_employee'); ?>"><i class="fa fa-list"></i>Employees List</a>
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-user"></i>Customer<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_customer/add'); ?>"><i class="fa fa-edit"></i>Create New Customer</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_customer'); ?>"><i class="fa fa-list"></i>Customers List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-wrench"></i>Products and Spareparts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="<?php echo site_url('c_product/add'); ?>"><i class="fa fa-edit"></i>Add New Products and Spareparts</a>
							</li>
							<li>
								<a href="<?php echo site_url('c_product'); ?>"><i class="fa fa-list"></i>Products and Spareparts List</a>								
							</li>
						</ul>
						</li>
						<li>
							<a href=""><i class="fa fa-folder-open"></i>Forms<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">	
							<li>
								<a href="<?php echo site_url('c_new_do'); ?>"><i class="fa fa-edit"></i>DO</a>
							</li>
						</ul>
						</li>
						<?php } ?>
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
	<script type="text/javascript">
	  $('select').select2();
	</script>
	
<script type="text/javascript">    
    //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    function displayTime(){
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
    }
</script>
</body>
</html>
