<style type="text/css">
    .label-outline {
      color: black;
      border: 1px solid #999;
      background-color: transparent;
    }

    .label-servis{
      color: black;
      background-color: white;
      border: 2px solid #d65752;

    }

    .label-instalasi{
      color: black;
      background-color: white;
      border: 2px solid #F0AD4E;
    }

    .label-survey{
      color: black;
      background-color: white;
      border: 2px solid #5171d5;
    }

    .label-rekondisi{
      color: black;
      background-color: white;
      border: 2px solid grey;
    }

    .label-green{
      color: white;
      background-color: #1a908a;

    }

    .label-maintenance{
      color: black;
      background-color: white;
      border: 2px solid #1a908a;
    }

    .label-purple{
      color: white;
      background-color: #99004d;
    }

    .label-training{
      color: black;
      background-color: white;
      border: 2px solid #99004d;
    }

    .label-brown{
      color: white;
      background-color: #833C14;
    }

    .label-perakitan{
      color: black;
      background-color: white;
      border: 2px solid #833C14;
    }

    .label-bblue{
      color: white;
      background-color: #00cccc;
    }

    .label-persiapan{
      color: black;
      background-color: white;
      border: 2px solid #00cccc;
    }

    .label-pink{
      color : white;
      background-color: #ff3399;
    }

    .label-kanibal{
      color : black;
      background-color: white;
      border: 2px solid #ff3399;
    }

    .label-finish{
      color: black;
      background-color: white;
      border: 2px solid #5bba5b;
    }

    .fa-check {
      color: white;
      background-color: #5bba5b;
      /*//border: 2px solid #5bba5b;*/
    }

    .label-border{
      color: #5bba5b;
       //border: 1.5px solid #5bba5b;
   }

   .btn-finish{
    background-color : #d9d9d9;
    border : 1px solid #d9d9d9;
   }

   #status{
    width : 140px;
   }

   .sm{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
     }

    .edit-tgl{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
     }
  </style>

<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2>Table SPS</h2>
    </div>

    <div class="col-md-3" style="margin-top: 22px;">
      <label>Select Data</label>
      <select class="form-control" id="select-sps">
        <option value="">-None-</option>
        <option value="8">Persiapan Barang</option>
        <option value="101">SPS Finished</option>
      </select>
      <div id="load-data" style="display:none;margin-top:5px;">
        <i class="fa fa-refresh fa-spin fa-fw"></i>
        <span>Load Data...</span>
      </div>
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" id="karyawan_id" value="<?php echo $_SESSION['myuser']['karyawan_id']; ?>">
      <table id="data-sps" class="table table-hover">
        <thead>
          <tr>
            <th>Job ID</th>
            <th>No SPS</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Product</th>
            <th>SPS Age</th>
            <th>Status</th>
            <th>Purchase Age</th>
            <th>Finish</th>
            <th>Schedule</th>
            <th></th>
            <th>Status Ori</th>
            <th>SPSID</th>
            <th>DateOpen</th>

          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php $this->load->view('content/sps/modal'); ?>
