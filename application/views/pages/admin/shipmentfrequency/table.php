
<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h1>Frequency Of Shipment</h1>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">
          <?php if(isset($create)){ ?>        
              <input type="submit" name="add" id="add" value="Add" class="btn btn-primary">
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
              <th scope="col">Shipment Frequency</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Shipment Frequency</th>
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
      <form action="<?php echo base_url('admin/shipmentfrequency/action')?>" method="POST" id="myform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Frequency of Shipment</label><span class="text-danger">*</span>
            <input type="text" class="form-control" name="shipmentName" id="shipmentName" placeholder="Enter Frequency of Shipment">
            <input type="hidden" class="form-control" name="action" id="action">
            <input type="hidden" class="form-control" name="shipmentId" id="shipmentId">
            <small id="shipmentName-info" class="text-danger"></small>
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
        $("#shipmentName-info").html("");
        $('#shipmentName').val('');
        $('#shipmentIdhidden').val('');
        $('#action').val('save');
        $("#save").html("Save");
      });


        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/shipmentfrequency/getsingle');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                $('#mymodal').modal('show');
                $('#shipmentName').val(data.freqShipmentName);
                $('#shipmentId').val(id);
                $('#action').val('update');
                $("#shipmentName-info").html("");
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
                  url:"<?php echo base_url('admin/shipmentfrequency/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });


  function validate()
  {
      var valid = true;
      if(!$("#shipmentName").val()){
        $("#shipmentName-info").html("*Please fill this field");
        valid = false;
      }else{
          $("#shipmentName-info").html("");
      }

      return valid;
  }


</script>