
  <div class="card">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h3>State Form</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/state');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
      <div class="card-body">
        <?php if(isset($edit))
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/state/update" method="POST" onsubmit="return validate()">
        <?php } 
        else
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/state/save" method="POST" onsubmit="return validate()">
        <?php }
        ?>
            <?php if(isset($edit))
            { ?>
              <div class="form-group">   
                <div class="row">
                  <div class="col-md-6">
                    <label for="portname">Country Name</label>
                    <select id="country" name="country" class="form-control">
                      <option value="">Select Country</option>
                      <?php foreach($countrys as $row){ ?>
                        <option value="<?php echo $row->countryId;?>" <?php if($state->countryId == $row->countryId){echo "selected";}?>><?php echo $row->countryName;?></option>
                      <?php } ?>
                    </select>
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="code">State Code</label>
                    <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Enter State Code" value="<?php echo $state->stateCode;?>">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label for="state">State Name</label>
                    <input type="text" class="form-control" id="state" name="state" aria-describedby="emailHelp" placeholder="Enter State Name" value="<?php echo $state->stateName;?>">
                    <span id="state-info" class="error-content err-font-color"></span>
                    <input type="hidden" name="id" id="id" value="<?php echo $state->stateId;?>">
                  </div>
                </div>
              </div>
            <?php }
            else
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="form-control">
                      <option value="">Select Country</option>
                      <?php foreach($country as $row){ ?>
                        <option value="<?php echo $row->countryId;?>"><?php echo $row->countryName;?></option>
                      <?php } ?>
                    </select>
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="code">State Code</label>
                    <input type="text" class="form-control" id="code" name="code" aria-describedby="emailHelp" placeholder="Enter State Code">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label for="state">State Name</label>
                    <input type="text" class="form-control" id="state" name="state" aria-describedby="emailHelp" placeholder="Enter State Name">
                    <span id="state-info" class="error-content err-font-color"></span>
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

  });
</script>
 