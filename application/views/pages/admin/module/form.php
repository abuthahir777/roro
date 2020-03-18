<div class="card">
  <div class="container">
    <div class="card-header">
      <h2>Module Form</h2>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){ ?>
        <form id="moduleform" name="moduleform" method="POST" action="<?php echo base_url();?>admin/module/update" >
      <?php }
      else{ ?>
        <form id="moduleform" name="moduleform" method="POST" action="<?php echo base_url();?>admin/module/save" >
      <?php } ?>
        <div class="form-row">
          <div class="form-group col-md-6">
            
            <div class="form-group">
              <label for="table">Table</label>
              <select class="form-control" id="table" name="table">
                <option value="">Select Table</option>
                <?php foreach($tables as $row){ ?>
                  <option value="<?php echo $row->tableId;?>" <?php if(isset($edit)){ if($row->tableId == $module->tableId){ echo "selected";}}?>><?php echo $row->tableName;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="operation">Operation</label>
            <select class="form-control" id="operation" name="operation">
                <option value="">Select Operation</option>
                <?php foreach($operations as $opera){ ?>
                  <option value="<?php echo $opera->operationId;?>" <?php if(isset($edit)){ if($opera->operationId == $module->operationId){ echo "selected";}}?>><?php echo $opera->operationName?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label for="modulename">Module Name</label>
          <input type="text" class="form-control" id="modulename" name="modulename" placeholder="Module " <?php if(isset($edit)){ echo 'value="'.$module->moduleName.'"';}?>>

          <?php if(isset($edit)){ ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $module->moduleId;?>">
          <?php }?>
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