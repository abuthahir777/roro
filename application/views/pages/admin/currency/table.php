<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h2>Currency</h2>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">
          <?php if(isset($create)){?>
              <h2><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></h2>
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="currencytable">
          <thead>
            <tr>
              <th scope="col">SI No</th>
              <th scope="col">Currency Code</th>
              <th scope="col">Currency Name</th>
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
      <form action="<?php echo base_url('admin/currency/action')?>" method="POST" id="myform" onsubmit="return validate()">
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
            <input type="hidden" class="form-control" name="currencyId" id="currencyId">
            <small id="country-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label>Currency Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Enter Currency Code">
            <small id="code-info" class="text-danger"></small>
            <span><small id="code-avl" class="text-danger"></small></span>
          </div>
          <div class="form-group">
            <label>Currency Name</label>
            <input type="text" class="form-control" name="currency" id="currency" placeholder="Enter Currency Name">
            <small id="currency-info" class="text-danger"></small>
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
          $("#currency-info").html("");
          $("#code-info").html("");
          $('#country').val('');
          $('#currency').val('');
          $('#code').val('');
          $('#stateId').val('');
          $('#action').val('save');
          $("#save").html("Save");
        });

        $(document).on('click','.edit', function(){

          var id = $(this).attr("id");

          $.ajax({

            url: "<?php echo base_url('admin/currency/getbyID');?>",
            method: "POST",
            data: { id:id },
            dataType:"json",
            success:function(data)
            {
                $('#mymodal').modal('show');
                $('#country').val(data.country);
                $('#code').val(data.code);
                $('#currency').val(data.currency);
                $('#currencyId').val(id);
                $('#action').val('update');
                $("#country-info").html("");
                $("#currency-info").html("");
                $("#code-info").html("");
                $("#save").html("Update");               
            
            }
          });
        });

        $('#code').keyup(function()
        {
            var code = $('#code').val();
            var id = $('#currencyId').val();
            
            if(code!='')
            {
              $.ajax({

                url: "<?php echo base_url('admin/state/checkCode');?>",
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

        var dataTable = $('#currencytable').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url('admin/currency/fetch'); ?>",  
                  type:"POST"  
             },  
        });   
      
  });
</script>