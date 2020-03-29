
  <div class="card">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <h1>Airport Form</h1>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/airport');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
      <div class="card-body">
        <?php if(isset($edit))
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/airport/update" method="POST" onsubmit="return validate()">
        <?php } 
        else
        { ?>
          <form id="portform" action="<?php echo base_url();?>admin/airport/save" method="POST" onsubmit="return validate()">
        <?php }
        ?>
          
            
            <?php if(isset($edit))
            { ?>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="form-control">
                      <option value="">Select Country</option>
                      <?php foreach($countries as $row){ ?>
                        <option value="<?php echo $row->countryId;?>" <?php if($airport->countryId == $row->countryId){echo "selected";}?>><?php echo $row->countryName;?></option>
                      <?php } ?>
                    </select>
                    <span id="country-info" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="state">State</label>
                    <select id="state" name="state" class="form-control">
                      <option value="">Select State</option>
                      <?php foreach($states as $row){ ?>
                        <option value="<?php echo $row->stateId;?>" <?php if($airport->stateId == $row->stateId){echo "selected";}?>><?php echo $row->stateName;?></option>
                      <?php } ?>
                    </select>
                    <span id="state-info" class="error-content err-font-color"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="code" name="code" placeholder="Enter Airport Code" value="<?php echo $airport->airportCode;?>">
                  <span id="code-info" class="error-content err-font-color"></span>
                  <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="airport" name="airport" placeholder="Enter Airport Name" value="<?php echo $airport->airportName;?>">
                  <input type="hidden" name="id" id="id" value="<?php echo $airport->airportId; ?>">
                  <span id="port-info" class="error-content err-font-color"></span>
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
                    <select id="state" name="state" class="form-control">
                      <option value="">Select State</option>
                    </select>
                    <span id="state-info" class="error-content err-font-color"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter Airport Code">
                    <span id="code-info" class="error-content err-font-color"></span>
                    <span id="code-avl" class="error-content err-font-color"></span>
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" id="airport" name="airport" placeholder="Enter Airport Name">
                    <small id="airport-info" class="text-danger"></small>
                  </div>
                </div>
              </div>

             <?php }
            ?>
          <button type="submit" class="btn btn-primary" id="save">Save</button>
          </form>
        </div>
      </div>
  </div>


<script type="text/javascript">
  
  $(document).ready(function()
  {

    $('#country').change(function()
    {
      var countryId = $('#country').val();
      
      if(countryId!='')
      {
        $.ajax({

          url: "<?php echo base_url('admin/port/fetchState');?>",
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
        $("#airport-info").html("*Port name required.");
        valid = false;
      }else{
          $("#airport-info").html("");
      }

      if(!$("#code").val() ){
        $("#code-info").html("*Code required.");
        $('#code-avl').html("");
        valid = false;
      }else{
          $("#code-info").html("");
      }

      if($("#code-avl").html()){
        valid = false;
      }else{
          $("#code-info").html("");
      }

      return valid;
  }
</script>
 