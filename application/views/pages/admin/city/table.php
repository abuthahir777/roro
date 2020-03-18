<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-6">
          <h1>Cities</h1>
        </div>

        <div class="col-md-6">
          <div class="row" align="right">
            <div class="col-md-4"></div>
            <div class="col-md-3" align="right">  
              <h1><a type="button" name="add" id="add" value="Add" class="btn btn-primary" href="<?php echo base_url('admin/city/add');?>">Add</a></h1>
            </div>
            <div class="col-md-3">
              <form name="excelform" id="excelform" enctype="multipart/form-data" action="<?php echo base_url('admin/state/importExcel');?>" method="POST" onsubmit="return validate()">
                <div class="input-group" align="right">
                  <input type="file" name="excelfile" id="excelfile" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <input class="btn btn-primary" type="submit" value="Import"></input>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-1" align="right">
              <a class="btn btn-primary form-control" type="submit" name="download" id="download" href="<?php echo base_url('admin/state/download');?>"><i class="mdi mdi-download"></i></a>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="citytable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">City Code</th>
              <th scope="col">City Name</th>
              <th scope="col">State Name</th>
              <th scope="col">Country Name</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
    </div>
    </div>

</div>


<script type="text/javascript">
  $(document).ready(function()
  {
    $('.hideit').fadeOut(10000);

        var dataTable = $('#citytable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/city/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });


  function validate()
  {
      var valid = true;

      var fileInput = $.trim($("#excelfile").val());
      var ext = $('#excelfile').val().split('.').pop().toLowerCase();
      if (fileInput && fileInput !== '') {   
        if($.inArray(ext, ['xlsx']) == -1) {
          $('#file-info').html('Attach xlsx file.');
          valid = false;
        }else{
          $('#file-info').html('');
        } 
      }

      return valid;
  }
</script>