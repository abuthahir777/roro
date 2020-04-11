<div class="card">
  <div class="container">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h3>Customer Form</h3>
        </div>

        <div class="col-md-3" align="center"></div>
      
        <div class="col-md-3" align="right">
          <?php if(isset($edit)){?>
              <input type="button" name="changepassword" id="changepassword" class="btn btn-primary" value="Change Password">
          <?php } ?>
        </div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/customer');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/customer/update" onsubmit="return editvalidate()" enctype="multipart/form-data">
      <?php }
      else{ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/customer/save" onsubmit="return validate()" enctype="multipart/form-data">
      <?php } ?>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" <?php if(isset($edit)){ echo 'value="'.$customer->customerFname.'"'; }?> >
                <small id="fname-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $customer->customerId;?>">
                <?php }?>
              </div>
              <div class="form-group col-md-6">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" <?php if(isset($edit)){ echo 'value="'.$customer->customerLname.'"'; }?> >
                <small id="lname-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" <?php if(isset($edit)){ echo 'value="'.$customer->customerEmail.'"'; }?> >
                <small id="email-info" class="text-danger"></small>
              </div>           
              <div class="form-group col-md-6">
                <?php if(!isset($edit)){?>
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                  <small id="password-info" class="text-danger"></small>
                <?php }?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="cname">Company Name</label>
                <input type="text" class="form-control" id="cname" placeholder="Company Name" name="cname" <?php if(isset($edit)){ echo 'value="'.$customer->customerCompany.'"'; }?> >
                <small id="cname-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="caddress">Company Address</label>
                <textarea type="text" class="form-control" id="caddress" placeholder="Company Address" name="caddress" rows="2"><?php if(isset($edit)){ echo $customer->customerAddress; }?></textarea>
                <small id="caddress-info" class="text-danger"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="country">Country</label>
                <select id="country" class="form-control" name="country">
                  <option value="">Select Country</option>
                  <?php foreach($country as $row){ ?>
                    <option value="<?php echo $row->countryId;?>" <?php if(isset($edit)){ if($row->countryId == $customer->customerCountry){ echo "selected";}}?>><?php echo $row->countryName;?></option>
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
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="stateId" id="stateId" value="<?php echo $customer->customerState;?>">
                <?php } ?>
              </div>
              <div class="form-group col-md-4">
                <label for="city">City</label>
                <select id="city" class="form-control" name="city">
                  <option value="">Select City</option>
                </select>
                <small id="city-info" class="text-danger"></small>
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="cityId" id="cityId" value="<?php echo $customer->customerCity;?>">
                <?php } ?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="businesstype">Business Type</label>
                <select id="businesstype" class="form-control" name="businesstype">
                  <option value="">Select Business Type</option>
                  <?php foreach($businessType as $row){ ?>
                    <option value="<?php echo $row->businessId;?>" <?php if(isset($edit)){ if($row->businessId == $customer->customerBusinessType){ echo "selected";}}?>><?php echo $row->businessName;?></option>
                  <?php } ?>
                </select>
                <small id="businesstype-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-4">
                <label for="shipmentFrequency">Frequency of Shipment</label>
                <select id="shipmentFrequency" class="form-control" name="shipmentFrequency">
                  <option value="">Select Frequency of Shipment</option>
                  <?php foreach($shipmentFreq as $row){ ?>
                    <option value="<?php echo $row->freqShipmentId;?>" <?php if(isset($edit)){ if($row->freqShipmentId == $customer->customerShipmentFrequency){ echo "selected";}}?>><?php echo $row->freqShipmentName;?></option>
                  <?php } ?>
                </select>
                <small id="shipmentFrequency-info" class="text-danger"></small>
              </div>
              <div class="form-group col-md-4">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" <?php if(isset($edit)){ echo 'value="'.$customer->customerMobile.'"'; }?> >
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
            <?php }else{ ?>
                <input type="submit" class="btn btn-primary" value="Create"></input>
            <?php } ?>
        </div>
      </form>
    </div>
    <div class="card-footer"></div>
  </div>
  
</div>


<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">Change Password</div>
      <form action="<?php echo base_url('admin/customer/updatePwd')?>" method="POST" id="myoldform" onsubmit="return validate()">
      <div class="modal-body">
          <div class="form-group">
            <label>Old Password</label>
            <input type="text" class="form-control" name="old" id="old" placeholder="Enter Old Password">
            <input type="hidden" class="form-control" name="customerId" id="customerId" value="<?php echo $customer->customerId;?>">
            <small id="oldpwd-info" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label id="newlabel">New Password</label>
            <input type="hidden" class="form-control" name="newpwd" id="newpwd" placeholder="Enter New Password">
            <small id="newpwd-info" class="text-danger"></small>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary" id="save">Submit</button>
      </div>

      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  
  $(document).ready(function()
  {
        $('#changepassword').click(function()
        {
            $('#mymodal').modal('show');
            $('#newlabel').attr("hidden", "hidden");
            $('#newpwd').attr('type','hidden');
            $('#old').val('');
            $('#newpwd').val('');
            $('#oldpwd-info').html("");
            $('#newpwd-info').html("");

        });


        $('#myoldform').on('submit',function(e)
        {
            e.preventDefault();
            var custId = $('#customerId').val();
            var custPwd = $('#old').val();

            if(custPwd !="")
            {
              $.ajax({

                  url: "<?php echo base_url('admin/customer/checkPwd');?>",
                  method:"POST",
                  dataType: "json",
                  data: { custId : custId, custPwd: custPwd },
                  success:function(data)
                  {
                      if(data.item == 'enable')
                      {
                        $('#newlabel').removeAttr("hidden");
                        $('#newpwd').attr('type','text');
                        $('#oldpwd-info').html("");

                        $('#save').click(function(){

                            if($('#newpwd').val().replace(/ /g,'').length >=1)
                            {
                              $('#newpwd-info').html("");
                              e.currentTarget.submit();
                            }
                            else
                            {
                              $('#newpwd-info').html("Please enter New Password");
                            }
                        });

                      }
                      else
                      {
                        $('#oldpwd-info').html("password Incorrect");
                      }

                  }

              });
            }
            else
            {
              $('#oldpwd-info').html("Please enter your old password");
              $('#newpwd-info').html("");
            }


        });




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
            $('#newpwd').attr('type','text');
          }
        });
      }
    });

    $('#state').on('change',function()
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


    var countryId = $('#country').val();
    var stateId = $('#stateId').val();
    var cityId = $('#cityId').val();

    $.ajax({

      url: "<?php echo base_url('admin/state/fetchState');?>",
      method: "POST",
      data: { countryId:countryId },
      success:function(data)
      {
        $('#state').html(data);
        $('#state').val(stateId);

        $.ajax({

          url: "<?php echo base_url('admin/customer/fetchCity');?>",
          method: "POST",
          data: { countryId:countryId, stateId:stateId },
          success:function(data)
          {
            $('#city').html(data);
            $('#city').val(cityId);
          }
        });
      }
    });
    

  });


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

</script>