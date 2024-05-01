
<?php 

$user = $this->session->userdata('myuser');



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>An-Nurmaniyah Learning</title>

    <link href="<?php echo site_url('assets/css/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/nprogress/nprogress.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/iCheck/skins/flat/green.css');?>" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo site_url('assets/css/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo site_url('assets/css/jqvmap/dist/jqvmap.min.css');?>" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo site_url('assets/css/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url('assets/css/css_custom/custom.min.css');?>" rel="stylesheet">

	<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css'); ?> ">

 	<script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
  	<script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	
	<script src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

 
 	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

	<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
	<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-home"></i> <span>An-Nurmaniyah Learning</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">


                <?php 

                if($user['foto_profile'])
                {
                  if($user['role'] =='Siswa')
                  {?>
                    <img alt="..." class="img-circle profile_img"  src="<?php echo site_url('assets/images/upload_foto_siswa/'.$user['foto_profile']);?>">

                  <?php }else
                  {?>

                     <img alt="..." class="img-circle profile_img"  src="<?php echo site_url('assets/images/upload_foto_guru/'.$user['foto_profile']);?>">


                  <?php }
                  ?>
                  

                <?php }else
                {?>
                  <img alt="..." class="img-circle profile_img"  src="<?php echo site_url('assets/images/logo_nurmaniyah.png');?>">
                <?php }?>
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $user['nama_lengkap'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">

                	<li>
                		<a><i class="fa fa-calendar"></i><?php echo date('l, m-Y H:i');?></a>
                    
                  	</li>

                  	<li><a><i class="fa fa-home"></i>Home <span class="fa fa-chevron-down"></span></a>
	                    <ul class="nav child_menu">
	                      <li><a href="<?php echo site_url('home');?>">Dashboard</a></li>
                        <li><a href="<?php echo site_url('home/logout');?>" onclick="return confirm_logout()">Logout</a></li>
	                    </ul>
                  	</li>

                  	<?php 

                  	if($user['role'] =='Admin')
                  	{?>

	                  <li><a><i class="fa fa-list"></i>Data<span class="fa fa-chevron-down"></span></a>
	                    <ul class="nav child_menu">
	                      <li><a href="<?php echo site_url('data_guru');?>">Data Guru</a></li>
	                      <li><a href="<?php echo site_url('data_siswa');?>">Data Siswa</a></li>
	                    </ul>
	                  </li>

	                <?php }?>

                  <li><a><i class="fa fa-desktop"></i>Modul Materi<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('modul_materi');?>">List Modul</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-list"></i>Quiz Dan Latihan Soal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('Quiz');?>">Quiz</a></li>
                    </ul>
                  </li>
                 
                </ul>
              </div>
              
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
             
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">

                  <?php 

                  if($user['foto_profile'])
                  {
                    if($user['role'] =='Siswa')
                    {?>
                      
                        <img src="<?php echo site_url('assets/images/upload_foto_siswa/'.$user['foto_profile']);?>" alt=""><?php echo $user['nama_lengkap'];?>

                    <?php }else
                    {?>

                      
                        <img src="<?php echo site_url('assets/images/upload_foto_guru/'.$user['foto_profile']);?>" alt=""><?php echo $user['nama_lengkap'];?>


                    <?php }
                    ?>
                    

                  <?php }else
                  {?>
                    <img src="<?php echo site_url('assets/images/logo_nurmaniyah.png');?>" alt=""><?php echo $user['nama_lengkap'];?>
                  <?php }?>



                   
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="<?php echo site_url('profile_user');?>"> Profile</a>
                    <a class="dropdown-item"  href="<?php echo site_url('home/logout');?>" onclick="return confirm_logout()"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>

                    <?php $count =  count($notification);

                    if($count >='1')
                    {?>

                    	<span class="badge bg-green"><?php echo count($notification);?></span>

                    <?php }
                    ?>

                    
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">


                  	<?php 

                  	foreach ($notification as $key => $value) 
                  	{	
                  		$datetime = date('Y-m-d H:i:s');
                  		$diff    = datediff($value['date_created'],$datetime);

                  		$days_total = $diff['days_total'];
                  		$hours      = $diff['hours'];
                  		$minutes    = $diff['minutes'];
                  		$deconds    = $diff['seconds'];



                  		?>


                  		  <li class="nav-item">
	                      <a class="dropdown-item" href="<?php echo site_url($value['url']);?>" target="_blank">
	                        <span>
	                          <span class="time"><?php echo date("d-m-Y H:i:s",strtotime($value['date_created']));?></span>
	                        </span>
	                        <span class="message">
	                          <?php echo $value['notification'];?>
	                        </span>
	                      </a>
	                    </li>
                  		
                  	<?php }?>

                  

            
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->



        <!-- page content -->
        <div class="right_col" role="main">
          
         	<!-- View -->
         	<?php $this->load->view($view); ?>
         
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
 
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo site_url('assets/css/jquery/dist/jquery.min.js');?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url('assets/css/bootstrap/dist/js/bootstrap.bundle.min.js');?>"></script>
    <!-- FastClick -->
    <script src="<?php echo site_url('assets/css/fastclick/lib/fastclick.js');?>"></script>
    <!-- NProgress -->
    <script src="<?php echo site_url('assets/css/nprogress/nprogress.js');?>"></script>
    <!-- Chart.js -->
    <script src="<?php echo site_url('assets/css/Chart.js/dist/Chart.min.js');?>"></script>
    <!-- gauge.js -->
    <script src="<?php echo site_url('assets/css/gauge.js/dist/gauge.min.js');?>"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php //echo ('assets/css/bootstrap-progressbar/bootstrap-progressbar.min.js');?>"></script>
    <!-- iCheck -->
    <script src="<?php echo site_url('assets/css/iCheck/icheck.min.js');?>"></script>
    <!-- Skycons -->
    <script src="<?php echo site_url('assets/css/skycons/skycons.js');?>"></script>
    <!-- Flot -->
    <script src="<?php echo site_url('assets/css/Flot/jquery.flot.js');?>"></script>
    <script src="<?php echo site_url('assets/css/Flot/jquery.flot.pie.js');?>"></script>
    <script src="<?php echo site_url('assets/css/Flot/jquery.flot.time.js');?>"></script>
    <script src="<?php echo site_url('assets/css/Flot/jquery.flot.stack.js');?>"></script>
    <script src="<?php echo site_url('assets/css/Flot/jquery.flot.resize.js');?>"></script>
    <!-- Flot plugins -->
    <script src="<?php echo site_url('assets/css/flot.orderbars/js/jquery.flot.orderBars.js');?>"></script>
    <script src="<?php echo site_url('assets/css/flot-spline/js/jquery.flot.spline.min.js');?>"></script>
    <script src="<?php echo site_url('assets/css/flot.curvedlines/curvedLines.js');?>"></script>
    <!-- DateJS -->
    <script src="<?php echo site_url('assets/css/DateJS/build/date.js');?>"></script>
    <!-- JQVMap -->
    <script src="<?php echo site_url('assets/css/jqvmap/dist/jquery.vmap.js');?>"></script>
    <script src="<?php echo site_url('assets/css/jqvmap/dist/maps/jquery.vmap.world.js');?>"></script>
    <script src="<?php echo site_url('assets/css/jqvmap/examples/js/jquery.vmap.sampledata.js');?>"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo site_url('assets/css/moment/min/moment.min.js');?>"></script>
    <script src="<?php echo site_url('assets/css/bootstrap-daterangepicker/daterangepicker.js');?>"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo site_url('assets/js/custom_js/custom.min.js');?>"></script>


  </body>
</html>

<script type="text/javascript">


	function confirm_logout()
	{
		return confirm('Apa Anda Yakin akan Logout ?');
	}
</script>
