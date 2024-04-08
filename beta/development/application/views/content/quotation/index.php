<style type="text/css">
    .progress-bar-Introduction {
        background-color: #447A34;
    }
    .progress-bar-Quotation {
        background-color: #2B9A21;
    }
    .progress-bar-Negotiation {
        background-color: #21B42B;
    }
    .progress-bar-Deal {
        background-color: #66DB1D;
    }
    .progress-bar-Loss {
        background-color: #000000;
    }

    .progress {
        margin-bottom: 7px;
    }
</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-9">
            <h2>Table CRM</h2>
        </div>

        <div class="col-md-3" style="margin-top: 22px;">
            <label>Select Data</label>
            <select class="form-control" id="select-crm">
                <option value="">On Going</option>
                <option value="Deal">Dealt</option>
                <option value="Loss">Lost</option>
            </select>
            <div id="load-data" style="display:none;margin-top:5px;">
                <i class="fa fa-refresh fa-spin fa-fw"></i>
                <span>Load Data...</span>
            </div>
        </div>
    </div>
    <hr />
    
    <div class="table-responsive">
    <table id="table" class="table table-hover col-md-12" cellspacing="0" style="font-size : 12px">
        <thead>
            <tr>
                <th class="fin">No</th>
                <th class="fin date">Fin Date</th>
                <th>CRM ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Product & Prospect Description</th>
                <th style="width: 120px;">Progress</th>
                <th class="value">Prospect Value</th>
                <th>Last Update</th>
                <th>Status</th>
                <th>Action</th>  
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
