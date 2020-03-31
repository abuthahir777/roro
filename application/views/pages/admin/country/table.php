
<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h2>Countries</h2>
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
    <div class="">
        <table class="table table-striped table-bordered" id="countrytable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Country Code</th>
              <th scope="col">Country Name</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Country Code</th>
              <th scope="col">Country Name</th>
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
      <form action="<?php echo base_url('admin/country/action')?>" method="POST" id="myform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Country Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Country Code">
            <small id="code-info" class="text-danger"></small>
            <small id="code-avl" class="text-danger"></small>
            <input type="hidden" class="form-control" name="action" id="action">
            <input type="hidden" class="form-control" name="countryId" id="countryId">
          </div>
          <div class="form-group">
            <label>Country Name</label>
            <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country Name">
            <small id="country-info" class="text-danger"></small>
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
          $("#code-info").html("");
          $("#code-avl").html("");
          $('#country').val('');
          $('#code').val('');
          $('#countryId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });

        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/country/getbyID');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                $('#mymodal').modal('show');
                $('#country').val(data.country);
                $('#code').val(data.code);
                $('#countryId').val(id);
                $('#action').val('update');
                $("#country-info").html("");
                $("#country-avl").html("");
                $("#code-info").html("");
                $("#save").html("Update");
           
            }
          });
        });


        $('#code').keyup(function()
        {
            var code = $('#code').val();
            var id = $('#countryId').val();
            
            if(code!='')
            {
              $.ajax({

                url: "<?php echo base_url('admin/country/checkCode');?>",
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

        var dataTable = $('#countrytable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/country/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });


  function validate()
  {
      var valid = true;
      if(!$("#country").val()){
        $("#country-info").html("*Country required.");
        valid = false;
      }else{
          $("#country-info").html("");
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