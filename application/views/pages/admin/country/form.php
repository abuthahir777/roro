
  <div class="card">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h1>Country Form</h1>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/country');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
      <div class="card-body">
        <?php if(isset($edit))
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/country/update" method="POST" onsubmit="return validate()">
        <?php } 
        else
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/country/save" method="POST" onsubmit="return validate()">
        <?php }
        ?>
          
            <?php if(isset($edit))
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="code">Country Code</label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter Country Code" value="<?php echo $country->countryCode;?>">
                    <span id="code-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="country">Country Name</label>
                    <input type="text" class="form-control" id="country" name="country" aria-describedby="emailHelp" placeholder="Enter Country Name" value="<?php echo $country->countryName;?>">
                    <span id="country-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                    <input type="hidden" name="id" id="id" value="<?php echo $country->countryId;?>">
                  </div>
                </div>
              </div>
            <?php }
            else
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="code">Country Code</label>
                    <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Enter Country Code">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="country">Country Name</label>
                    <input type="text" class="form-control" id="country" name="country" aria-describedby="emailHelp" placeholder="Enter Country Name">
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                </div>
              </div>
             <?php }
            ?>
          <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
  </div>


<script type="text/javascript">
  function validate()
  {
      var valid = true;
      if(!$("#country").val()){
        $("#country-info").html("*Country required.");
        valid = false;
      }else{
          $("#country-info").html("");
      }

      if($("#code-avl").html()){
        valid = false;
      }else{
          $("#code-info").html("");
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
 