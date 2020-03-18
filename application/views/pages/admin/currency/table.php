<div class="card">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h3>Currency</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/currency/add');?>">
              <input type="submit" name="add" id="add" value="Add" class="btn btn-primary">
          </a>
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


<script type="text/javascript">
  $(document).ready(function()
  {
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