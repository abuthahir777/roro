<div class="card">
  <div class="container">
    <div class="card-header">
      <h2>Module Form</h2>
    </div>
    <div class="card-body">
      <?php if(isset($edit)){?>
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
                  <option value="<?php echo $row->tableId;?>"><?php echo $row->tableName;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="operation">Operation</label>
            <select class="form-control" id="operation" name="operation">
                <option value="">Select Operation</option>
                <?php foreach($operations as $opera){ ?>
                  <option value="<?php echo $opera->operationId;?>"><?php echo $opera->operationName?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label for="modulename">Module Name</label>
          <input type="text" class="form-control" id="modulename" name="modulename" placeholder="Module ">
        </div>
        <input type="submit" class="btn btn-primary" value="Create"></input>
      </form>
    </div>
    <div class="card-footer"></div>
  </div>
  
</div>