<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h2>Airports</h2>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">
          <?php if(isset($create)){ ?>
              <h2><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></h2>
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="mb-5 mt3 table table-responsive">
        <table class="table table-striped table-bordered" id="airporttable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Airport Code</th>
              <th scope="col">Airport Name</th>
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
      <form action="<?php echo base_url('admin/airport/action')?>" method="POST" id="myform" onsubmit="return validate()">
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
            <input type="hidden" class="form-control" name="airportId" id="airportId">
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
            <label>Airport Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Airport Code">
            <small id="code-info" class="text-danger"></small>
            <small id="code-avl" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Airport Name</label>
            <input type="text" class="form-control" name="airport" id="airport" placeholder="Enter Airport Name">
            <small id="airport-info" class="text-danger"></small>
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
          $("#airport-info").html("");
          $("#code-avl").html("");
          $('#country').val('');
          $('#state').val('');
          $('#code').val('');
          $('#airport').val('');
          $('#airportId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });

        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/airport/getsingle');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                var statevalue = data.state;
                $('#mymodal').modal('show');
                $('#country').val(data.country);
                $('#code').val(data.code);
                $('#airport').val(data.airport);
                $('#airportId').val(id);
                $('#action').val('update');
                $("#country-info").html("");
                $("#state-info").html("");
                $("#code-info").html("");
                $("#airport-info").html("");
                $("#save").html("Update");

                $.ajax({

                  url: "<?php echo base_url('admin/airport/fetchState');?>",
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

              url: "<?php echo base_url('admin/airport/fetchState');?>",
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
              var id = $('#id').val();
              
              if(code!='')
              {
                $.ajax({

                  url: "<?php echo base_url('admin/airport/checkCode');?>",
                  method: "POST",
                  data: {code:code , id:id},
                  success:function(data)
                  {
                    $('#code-info').html('');
                    $('#code-avl').html(data);
                  }
                });
              }

          });

    $('.hideit').fadeOut(10000);

        var dataTable = $('#airporttable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/airport/fetch'); ?>",  
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

      if(!$("#airport").val()){
        $("#airport-info").html("*Airport Name required.");
        valid = false;
      }else{
          $("#airport-info").html("");
      }

      if(!$("#code").val()){
        $("#code-info").html("*Airport Code required.");
        $('#code-avl').html("");
        valid = false;
      }else{
          $("#code-info").html("");
      }

      if($("#code-avl").html() != ""){
        $("#code-avl").html("Already Exists")
        valid = false;
      }

      return valid;
  }
</script>