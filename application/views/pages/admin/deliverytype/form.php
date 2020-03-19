
  <div class="card">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h3>Currency Form</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/deliverytype');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
      <div class="card-body">
        <?php if(isset($edit))
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/deliverytype/update" method="POST" onsubmit="return validate()">
        <?php } 
        else
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/deliverytype/save" method="POST" onsubmit="return validate()">
        <?php }
        ?>
            <?php if(isset($edit))
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="country">Country Name</label>
                    <select id="country" name="country" class="form-control">
                      <option value="">Select Country</option>
                      <?php foreach($countries as $row){ ?>
                        <option value="<?php echo $row->countryId;?>" <?php if($currency->countryId == $row->countryId){echo "selected";}?>><?php echo $row->countryName;?></option>
                      <?php } ?>
                    </select>
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="country">Currency Code</label>
                    <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Enter Currency Code" value="<?php echo $currency->currencyCode;?>">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                    <input type="hidden" name="id" id="id" value="<?php echo $currency->currencyId;?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="country">Currency Name</label>
                    <input type="text" class="form-control" id="currency" name="currency" aria-describedby="emailHelp" placeholder="Enter Currency Name" value="<?php echo $currency->currencyName;?>">
                    <span id="currency-info" class="error-content err-font-color"></span>
                  </div>
                </div>
              </div>
            <?php }
            else
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select id="country" name="country" class="form-control">
                      <option value="">Select Country</option>
                      <?php foreach($country as $row){ ?>
                        <option value="<?php echo $row->countryId;?>"><?php echo $row->countryName;?></option>
                      <?php } ?>
                    </select>
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Enter Code Name">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="currency" name="currency" aria-describedby="emailHelp" placeholder="Enter Currency Name">
                    <span id="currency-info" class="error-content err-font-color"></span>
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
      if(!$("#currency").val()){
        $("#currency-info").html("*Currency required.");
        valid = false;
      }else{
          $("#currency-info").html("");
      }

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

    $('#country').change(function()
    {
      var countryId = $('#country').val();
      
      if(countryId!='')
      {
        $.ajax({

          url: "<?php echo base_url('admin/currency/fetchState');?>",
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

            url: "<?php echo base_url('admin/currency/checkCode');?>",
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
 