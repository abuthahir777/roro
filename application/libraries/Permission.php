<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
/** 
 * Layouts Class. PHP5 only. 
 * 
 */
class Permission { 

  private $CI; 
    
  public function __construct()  
  { 
    $this->CI =& get_instance(); 
  } 

  public function  setRights($roleId,$tableId)
  {
      $permissions = $this->CI->User_Model->getPermissions($roleId,$tableId);
      $data = array();


      foreach($permissions as $permission)
      {
      		if($permission->operationId == 1)
      		{
      			$data['view'] = "View";
      		}

      		if($permission->operationId == 2)
      		{
      			$data['create'] = "Create";
      		}

      		if($permission->operationId == 3)
      		{
      			$data['update'] = "Update";
      		}

      		if($permission->operationId == 4)
      		{
      			$data['delete'] = "Delete";
      		}

          if($permission->operationId == 5)
          {
            $data['status'] = "Status";
          }
      }

      if($data != "")
      {
          return $data;
      }
  }
}