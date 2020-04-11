
<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-3">
          <h2>Business Type</h2>
        </div>

          <div class="col-md-6" align="center">
          
            <?php

            if($this->session->flashdata('save'))
            { ?>
              <div class="alert alert-success hideit" role="alert">
                <h3><?php echo $this->session->flashdata('save'); ?></h3>
              </div>
            <?php }

            if($this->session->flashdata('update'))
            { ?>
              <div class="alert alert-info hideit" role="alert">
                <h3><?php echo $this->session->flashdata('update'); ?></h3>
              </div>
            <?php }

            if($this->session->flashdata('delete'))
            { ?>
              <div class="alert alert-danger hideit" role="alert">
                <h3><?php echo $this->session->flashdata('delete'); ?></h3>
              </div>
            <?php }

            ?>     
        </div>

        <div class="col-md-3" align="right">
          <?php if(isset($create)){ ?>        
              <h2><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></h2>
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="businesstypetable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Business Type</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Business Type</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </tfoot>
          <tbody>

          </tbody>
        </table>
    </div>
    </div>

</div>

<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/businesstype/action')?>" method="POST" id="myform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Business Type</label><span class="text-danger">*</span>
            <input type="text" class="form-control" name="businesstype" id="businesstype" placeholder="Enter Business Type Name">
            <input type="hidden" class="form-control" name="action" id="action">
            <input type="hidden" class="form-control" name="businessId" id="businessId">
            <small id="businesstype-info" class="text-danger"></small>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary" id="save">Save</button>
      </div>

      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function()
  {

    $('#add').click(function()
      {
        $('#mymodal').modal('show');
        $("#businesstype-info").html("");
        $('#businesstype').val('');
        $('#businessId').val('');
        $('#action').val('save');
        $("#save").html("Save");
      });


        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/businesstype/getsingle');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                $('#mymodal').modal('show');
                $('#businesstype').val(data.businessName);
                $('#businessId').val(id);
                $('#action').val('update');
                $("#businesstype-info").html("");
                $("#save").html("Update");
            }
          });
        });

    $('.hideit').fadeOut(10000);

        var dataTable = $('#businesstypetable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/businesstype/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });


  function validate()
  {
      var valid = true;
      if(!$("#businesstype").val()){
        $("#businesstype-info").html("*Enter Business Type");
        valid = false;
      }else{
          $("#businesstype-info").html("");
      }

      return valid;
  }


</script>