<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-3">
          <h3>Ports</h3>
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
          <?php if(isset($create)){?>
              <input type="submit" name="add" id="add" value="Add" class="btn btn-primary">
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="porttable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Port Code</th>
              <th scope="col">Port Name</th>
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

<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/port/action')?>" method="POST" id="myform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Country</label>
            <select id="country" name="country" class="form-control">
              <option value="">Select Country</option>
              <?php foreach($country as $row){ ?>
                <option value="<?php echo $row->countryId;?>"><?php echo $row->countryName;?></option>
              <?php } ?>
            </select>
            <input type="hidden" class="form-control" name="action" id="action">
            <input type="hidden" class="form-control" name="portId" id="portId">
            <small id="country-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>State</label>
            <select id="state" name="state" class="form-control">
              <option value="">Select State</option>
            </select>
            <small id="state-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Port Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Port Code">
            <small id="code-info" class="text-danger"></small>
            <small id="code-avl" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Port Name</label>
            <input type="text" class="form-control" name="port" id="port" placeholder="Enter Port Name">
            <small id="port-info" class="text-danger"></small>
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
          $("#country-info").html("");
          $("#state-info").html("");
          $("#code-info").html("");
          $("#port-info").html("");
          $('#country').val('');
          $('#state').val('');
          $('#code').val('');
          $('#port').val('');
          $('#portId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });

        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/port/getbyID');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                var statevalue = data.state;
                $('#mymodal').modal('show');
                $('#country').val(data.country);
                $('#code').val(data.code);
                $('#port').val(data.port);
                $('#portId').val(id);
                $('#action').val('update');
                $("#country-info").html("");
                $("#state-info").html("");
                $("#code-info").html("");
                $("#port-info").html("");
                $("#save").html("Update");

                $.ajax({

                  url: "<?php echo base_url('admin/state/fetchState');?>",
                  method: "POST",
                  data: {countryId:data.country},
                  success:function(data)
                  {
                    $('#state').html(data);
                    $('#state').val(statevalue);
                  }
                });
           
            }
          });
        });

        $('#country').change(function()
        {
          var countryId = $('#country').val();
          
          if(countryId!='')
          {
            $.ajax({

              url: "<?php echo base_url('admin/state/fetchState');?>",
              method: "POST",
              data: {countryId:countryId},
              success:function(data)
              {
                $('#state').html(data);
              }
            });
          }
        });


        $('#code').keyup(function()
        {
            var code = $('#code').val();
            var id = $('#portId').val();
            
            if(code!='')
            {
              $.ajax({

                url: "<?php echo base_url('admin/port/checkCode');?>",
                method: "POST",
                data: {code:code, id:id},
                success:function(data)
                {
                  $('#code-info').html('');
                  $('#code-avl').html(data);
                }
              });
            }

        });


    $('.hideit').fadeOut(10000);

        var dataTable = $('#porttable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/port/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });


  function validate()
  {
      var valid = true;
      if(!$("#state").val()){
        $("#state-info").html("*State required.");
        valid = false;
      }else{
          $("#state-info").html("");
      }

      if(!$("#country").val()){
        $("#country-info").html("*Country required.");
        valid = false;
      }else{
          $("#country-info").html("");
      }

      if(!$("#port").val()){
        $("#port-info").html("*Port required.");
        valid = false;
      }else{
          $("#port-info").html("");
      }

      if(!$("#code").val()){
        $("#code-info").html("*Code required.");
        $('#code-avl').html("");
        valid = false;
      }else{
          $("#code-info").html("");
      }

      if($("#code-avl").html() !=""){
        $('#code-avl').html("Already Exists");
        valid = false;
      }

      return valid;
  }

</script>