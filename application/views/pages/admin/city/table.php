<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-6">
          <h2>Cities</h2>
        </div>

        <div class="col-md-6">
          <div class="row" align="right">
            <div class="col-md-4"></div>
            <div class="col-md-3" align="right">
              <?php if(isset($create)) {?>
                <h2><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></h2>
              <?php } ?>
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
              <h2><a class="btn btn-primary form-control" type="submit" name="download" id="download" href="<?php echo base_url('admin/state/download');?>"><i class="mdi mdi-download"></i></a></h2>
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


<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url('admin/city/action')?>" method="POST" id="myform" onsubmit="return validate()">
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
            <input type="hidden" class="form-control" name="cityId" id="cityId">
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
            <label>City Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Enter City Code">
            <small id="code-info" class="text-danger"></small>
            <small id="code-avl" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>City Name</label>
            <input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name">
            <small id="city-info" class="text-danger"></small>
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
          $("#city-info").html("");
          $('#country').val('');
          $('#state').val('');
          $('#code').val('');
          $('#city').val('');
          $('#cityId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });

        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/city/getbyID');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                var statevalue = data.state;
                $('#mymodal').modal('show');
                $('#country').val(data.country);
                $('#code').val(data.code);
                $('#city').val(data.city);
                $('#cityId').val(id);
                $('#action').val('update');
                $("#country-info").html("");
                $("#state-info").html("");
                $("#code-info").html("");
                $("#city-info").html("");
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
            var id = $('#cityId').val();
            
            if(code!='')
            {
              $.ajax({

                url: "<?php echo base_url('admin/city/checkCode');?>",
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

      if(!$("#city").val()){
        $("#city-info").html("*City required.");
        valid = false;
      }else{
          $("#city-info").html("");
      }

      if(!$("#code").val()){
        $("#code-info").html("*Code required.");
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