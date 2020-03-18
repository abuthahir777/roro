<div class="card">
  <div class="container">
    <div class="card-header">
      <div class="row">

        <div class="col-md-4">
          <h3>Role Form</h3>
        </div>

        <div class="col-md-6" align="center"></div>

        <div class="col-md-2" align="right">  
          <a href="<?php echo base_url('admin/role');?>">
              <input type="submit" name="back" id="back" value="Back" class="btn btn-primary">
          </a>
        </div>

      </div>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){ ?>
        <form id="roleform" name="roleform" method="POST" action="<?php echo base_url();?>admin/role/update" >
      <?php }
      else{ ?>
        <form id="roleform" name="roleform" method="POST" action="<?php echo base_url();?>admin/role/save" >
      <?php } ?>
        <div class="form-group">
          <label for="rolename">Role Name</label>
          <input type="text" class="form-control" id="rolename" name="rolename" placeholder="Role" <?php if(isset($edit)){ echo 'value="'.$role->roleName.'"';}?>>

          <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $role->roleId;?>">
          <?php }?>
        </div>
        <label for="module">Modules</label>
        <div class="form-row">
          <?php foreach($modules as $row){ ?>
          <div class="form-group col-md-3">
            <input type="checkbox" name="module[]" id="<?php echo $row->moduleId; ?>" value="<?php echo $row->moduleId; ?>"
            <?php if(isset($edit)){ 
            foreach($rights as $right)
            {
                if($right->moduleId == $row->moduleId)
                {
                    echo "checked";
                }
            }}?>
            ><span for="<?php echo $row->moduleId; ?>"><?php echo $row->moduleName;?></span>
          </div>
        <?php  } ?>
        </div>
        <?php if(isset($edit)){ ?>
          <input type="submit" class="btn btn-primary" value="Update"></input>
        <?php } 
        else
          { ?>

          <input type="submit" class="btn btn-primary" value="Create"></input>

        <?php } ?>
      </form>
    </div>
    <div class="card-footer"></div>
  </div>
  
</div>