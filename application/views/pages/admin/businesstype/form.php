
  <div class="card">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h1>Country Form</h1>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/businesstype');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
      <div class="card-body">
        <?php if(isset($edit))
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/businesstype/update" method="POST" onsubmit="return validate()">
        <?php } ?>          
            <?php if(isset($edit))
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="businesstype">Business Type</label>
                    <input type="text" class="form-control" id="businesstype" name="businesstype" placeholder="Enter Business Type" value="<?php echo $businesstype->businessName;?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $businesstype->businessId;?>">
                    <span id="businesstype-info" class="text-danger"></span>
                  </div>
                </div>
              </div>
            <?php } ?>
          <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
  </div>



<script type="text/javascript">
  function validate()
  {
      var valid = true;
      if(!$("#businesstype").val()){
        $("#businesstype-info").html("*Business Type is required.");
        valid = false;
      }else{
          $("#businesstype-info").html("");
      }

      return valid;
  }

  $(document).ready(function()
  {



    $('#code').keyup(function()
    {
        var code = $('#code').val();
        var id = $('#id').val();
        
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


    



  });
</script>
 