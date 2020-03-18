<div class="card">
  <div class="container">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h3>User Form</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/users');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/users/update" >
      <?php }
      else{ ?>
        <form id="userform" name="userform" method="POST" action="<?php echo base_url();?>admin/users/save" >
      <?php } ?>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" <?php if(isset($edit)){ echo 'value="'.$user->firstName.'"'; }?> >
                <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $user->userId;?>">
                <?php }?>
              </div>
              <div class="form-group col-md-6">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" <?php if(isset($edit)){ echo 'value="'.$user->lastName.'"'; }?> >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" <?php if(isset($edit)){ echo 'value="'.$user->userEmail.'"'; }?> >
              </div>
              <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="userid">User ID</label>
                <input type="text" class="form-control" id="userid" placeholder="User ID" name="userid" <?php if(isset($edit)){ echo 'value="'.$user->userCode.'"'; }?>>
              </div>
              <div class="form-group col-md-4">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" <?php if(isset($edit)){ echo 'value="'.$user->userMobile.'"'; }?> >
              </div>
              <div class="form-group col-md-4">
                <label for="role">Role</label>
                <select id="role" class="form-control" name="role">
                  <option value="">Select Role</option>
                  <?php foreach($roles as $row){ ?>
                    <option value="<?php echo $row->roleId;?>" <?php if(isset($edit)){ if($row->roleId == $user->roleId){ echo "selected";}}?>><?php echo $row->roleName;?></option>
                  <?php } ?>
                </select>
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