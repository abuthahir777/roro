<div class="card">
  <div class="container">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h3>User Form</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/customer');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/customer/update" onsubmit="return validate()" enctype="multipart/form-data">
      <?php }
      else{ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/customer/save" onsubmit="return validate()" enctype="multipart/form-data">
      <?php } ?>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" <?php if(isset($edit)){ echo 'value="'.$user->firstName.'"'; }?> >
                <small id="fname-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $user->userId;?>">
                <?php }?>
              </div>
              <div class="form-group col-md-6">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" <?php if(isset($edit)){ echo 'value="'.$user->lastName.'"'; }?> >
                <small id="lname-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" <?php if(isset($edit)){ echo 'value="'.$user->userEmail.'"'; }?> >
                <small id="email-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <small id="password-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="cname">Company Name</label>
                <input type="text" class="form-control" id="cname" placeholder="Company Name" name="cname" <?php if(isset($edit)){ echo 'value="'.$user->firstName.'"'; }?> >
                <small id="cname-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $user->userId;?>">
                <?php }?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="caddress">Company Address</label>
                <input type="textarea" class="form-control" id="caddress" placeholder="Company Address" name="caddress" <?php if(isset($edit)){ echo 'value="'.$user->firstName.'"'; }?> >
                <small id="caddress-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $user->userId;?>">
                <?php }?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="country">Country</label>
                <select id="country" class="form-control" name="country">
                  <option value="">Select Country</option>
                  <?php foreach($country as $row){ ?>
                    <option value="<?php echo $row->countryId;?>" <?php if(isset($edit)){ if($row->countryId == $country->countryId){ echo "selected";}}?>><?php echo $row->countryName;?></option>
                  <?php } ?>
                </select>
                <small id="country-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-4">
                <label for="state">State</label>
                <select id="state" class="form-control" name="state">
                  <option value="">Select State</option>
                </select>
                <small id="state-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-4">
                <label for="city">City</label>
                <select id="city" class="form-control" name="city">
                  <option value="">Select City</option>
                </select>
                <small id="city-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="businesstype">Business Type</label>
                <select id="businesstype" class="form-control" name="businesstype">
                  <option value="">Select Business Type</option>
                  <?php foreach($businessType as $row){ ?>
                    <option value="<?php echo $row->businessId;?>" <?php if(isset($edit)){ if($row->businessId == $user->businessId){ echo "selected";}}?>><?php echo $row->businessName;?></option>
                  <?php } ?>
                </select>
                <small id="businesstype-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $user->userId;?>">
                <?php }?>
              </div>
              <div class="form-group col-md-4">
                <label for="shipmentFrequency">Frequency of Shipment</label>
                <select id="shipmentFrequency" class="form-control" name="shipmentFrequency">
                  <option value="">Select Frequency of Shipment</option>
                  <?php foreach($shipmentFreq as $row){ ?>
                    <option value="<?php echo $row->freqShipmentId;?>" <?php if(isset($edit)){ if($row->freqShipmentId == $user->freqShipmentId){ echo "selected";}}?>><?php echo $row->freqShipmentName;?></option>
                  <?php } ?>
                </select>
                <small id="shipmentFrequency-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-4">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" <?php if(isset($edit)){ echo 'value="'.$user->userMobile.'"'; }?> >
                <small id="mobile-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <input type="file" name="idproof" id="idproof" value="ID Proof" class="btn btn-primary">
                <small id="idproof-info" class="text-danger"></small>
              </div>
            </div>

            <?php if(isset($edit)){ ?>
          <input type="submit" class="btn btn-primary" value="Update"></input>
        <?php } 
        else
          { ?>

          <input type="submit" class="btn btn-primary" value="Create"></input>

        <?php } ?>
        </div>
      </form>
    </div>
    <div class="card-footer"></div>
  </div>
  
</div>


<script type="text/javascript">
  
  function validate()
  {
      var valid = true;
      if(!$("#fname").val()){
        $("#fname-info").html("*First Name required.");
        valid = false;
      }else{
          $("#fname-info").html("");
      }

      if(!$("#lname").val()){
        $("#lname-info").html("*Last Name required.");
        valid = false;
      }else{
          $("#lname-info").html("");
      }

      if(!$("#email").val()){
        $("#email-info").html("*Email required.");
        valid = false;
      }else{
          $("#email-info").html("");
      }

      if(!$("#password").val()){
        $("#password-info").html("*Password required.");
        valid = false;
      }else{
          $("#password-info").html("");
      }

      if(!$("#cname").val()){
        $("#cname-info").html("*Company Name required.");
        valid = false;
      }else{
          $("#cname-info").html("");
      }

      if(!$("#caddress").val()){
        $("#caddress-info").html("*Address required.");
        valid = false;
      }else{
          $("#caddress-info").html("");
      }

      if(!$("#country").val()){
        $("#country-info").html("*Country required.");
        valid = false;
      }else{
          $("#country-info").html("");
      }

      if(!$("#state").val()){
        $("#state-info").html("*State required.");
        valid = false;
      }else{
          $("#state-info").html("");
      }

      if(!$("#city").val()){
        $("#city-info").html("*City required.");
        valid = false;
      }else{
          $("#city-info").html("");
      }

      if(!$("#businesstype").val()){
        $("#businesstype-info").html("*Business Type required.");
        valid = false;
      }else{
          $("#businesstype-info").html("");
      }

      if(!$("#shipmentFrequency").val()){
        $("#shipmentFrequency-info").html("*Frequency of Shipment required.");
        valid = false;
      }else{
          $("#shipmentFrequency-info").html("");
      }

      if(!$("#mobile").val()){
        $("#mobile-info").html("*Mobile required.");
        valid = false;
      }else{
          $("#mobile-info").html("");
      }

      if(!$("#idproof").val()){
        $("#idproof-info").html("*ID Proof required.");
        valid = false;
      }else{
          $("#idproof-info").html("");
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

          url: "<?php echo base_url('admin/customer/fetchState');?>",
          method: "POST",
          data: {countryId:countryId},
          success:function(data)
          {
            $('#state').html(data);
          }
        });
      }
    });

    $('#state').change(function()
    {
      var countryId = $('#country').val();
      var stateId = $('#state').val();
      
      if(countryId !="" && stateId != "")
      {
        $.ajax({

          url: "<?php echo base_url('admin/customer/fetchCity');?>",
          method: "POST",
          data: { countryId:countryId, stateId:stateId },
          success:function(data)
          {
            $('#city').html(data);
          }
        });
      }
    });

  });

</script>