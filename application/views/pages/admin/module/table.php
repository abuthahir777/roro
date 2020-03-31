<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h1>Modules</h1>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">
          <?php if(isset($create)){?>
              <h1><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></h1>
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="moduletable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Module Name</th>
              <th scope="col">Operation Name</th>
              <th scope="col">Table Name</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
    </div>
    </div>
    <div class="card-footer"></div>

</div>


<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/module/action')?>" method="POST" id="myform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Table</label>
            <select id="table" name="table" class="form-control">
              <option value="">Select Table</option>
              <?php foreach($tables as $row){ ?>
                <option value="<?php echo $row->tableId;?>"><?php echo $row->tableName;?></option>
              <?php } ?>
            </select>
            <input type="hidden" class="form-control" name="action" id="action">
            <input type="hidden" class="form-control" name="moduleId" id="moduleId">
            <small id="table-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Operation</label>
            <select id="operation" name="operation" class="form-control">
              <option value="">Select Operation</option>
              <?php foreach($operations as $row){ ?>
                <option value="<?php echo $row->operationId;?>"><?php echo $row->operationName;?></option>
              <?php } ?>
            </select>
            <small id="operation-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Module Name</label>
            <input type="text" class="form-control" name="module" id="module" placeholder="Enter Module Name">
            <small id="module-info" class="text-danger"></small>
            <small id="module-avl" class="text-danger"></small>
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
          $("#table-info").html("");
          $("#operation-info").html("");
          $("#module-info").html("");
          $("#code-avl").html("");
          $('#table').val('');
          $('#operation').val('');
          $('#module').val('');
          $('#airportId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });



    $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/module/getsingle');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                $('#mymodal').modal('show');
                $('#table').val(data.table);
                $('#operation').val(data.operation);
                $('#module').val(data.module);
                $('#moduleId').val(id);
                $('#action').val('update');
                $("#table-info").html("");
                $("#operation-info").html("");
                $("#module-info").html("");
                $("#save").html("Update");
            
            }
          });
        });


    $('select').change(function()
        {
          var tableId = $('#table').val();
          var operaId = $('#operation').val();
          
            $.ajax({

              url: "<?php echo base_url('admin/module/getTObyID');?>",
              method: "POST",
              data: {operaId:operaId, tableId:tableId },
              dataType:"json",
              success:function(data)
              {
                $('#module').val(data.tableName+data.operaName);
              }
            });

        });


    $('.hideit').fadeOut(10000);

        var dataTable = $('#moduletable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/module/fetchModule'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });



  function validate()
  {
      var valid = true;
      if(!$("#table").val()){
        $("#table-info").html("*Please select table.");
        valid = false;
      }else{
          $("#table-info").html("");
      }

      if(!$("#operation").val()){
        $("#operation-info").html("*Please select operation.");
        valid = false;
      }else{
          $("#operation-info").html("");
      }

      if(!$("#module").val()){
        $("#module-info").html("*Module Name required.");
        valid = false;
      }else{
          $("#module-info").html("");
      }

      // if(!$("#code").val()){
      //   $("#code-info").html("*Airport Code required.");
      //   $('#code-avl').html("");
      //   valid = false;
      // }else{
      //     $("#code-info").html("");
      // }

      // if($("#code-avl").html() != ""){
      //   $("#code-avl").html("Already Exists")
      //   valid = false;
      // }

      return valid;
  }


</script>