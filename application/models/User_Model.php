<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function validate($email,$password)
    {
        $status = $this->db->from('user')
                    ->where('userEmail',$email)
                    ->where('userPassword',md5($password))
                    ->where('active_status',0)
                    ->where('delete_status',0)
                    ->get();

        if($status->num_rows() > 0)
        {
            return $status->row();
        }
    }


    function getallOperation()
    {
        return $this->db->from('operations')
                    ->where('active_status',0)
                    ->where('delete_status',0)
                    ->get()
                    ->result();
    }

    function getallTable()
    {
        return $this->db->from('tables')
                    ->where('active_status',0)
                    ->where('delete_status',0)
                    ->order_by('tableName','ASC')
                    ->get()
                    ->result();
    }

    function getTable($id)
    {
        return $this->db->from('tables')  
                        ->where('tableId',$id)
                        ->get()
                        ->row();

    }

    function getOperation($id)
    {
        return $this->db->from('operations')  
                        ->where('operationId',$id)
                        ->get()
                        ->row();
    }

//------------------------------------------------- MODULE AREA START -------------------------------------------------------------------------------

    var $tableModule = "module";
    var $select_columnModule = array("module.moduleId","operations.operationName","tables.tableName","module.moduleName","module.active_status","module.delete_status");
    var $order_columnModule = array("","module.moduleName","operations.operationName","tables.tableName","","");

    function make_queryModule()
    {
        $this->db->select($this->select_columnModule);
        $this->db->from($this->tableModule);
        $this->db->join('operations','operations.operationId = module.operationId');
        $this->db->join('tables','tables.tableId = module.tableId');
        $this->db->where('module.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("module.moduleName", $_POST["search"]["value"]);
                $this->db->or_like("operations.operationName", $_POST["search"]["value"]);
                $this->db->or_like("tables.tableName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_columnModule[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('module.moduleId', 'DESC');
        }
    }

    function fetch_dataModule()
    {
        $this->make_queryModule();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_dataModule()
    {
        $this->make_queryModule();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_dataModule()
    {
        $this->db->select("*");
        $this->db->from($this->tableModule);
        return $this->db->count_all_results();
    }


    function saveModule()
    {
        $this->db->insert('module',[
            'moduleName' => ucwords($this->input->post('module')),
            'tableId' => $this->input->post('table'),
            'operationId' => $this->input->post('operation'),
            'active_status' => 0,
            'delete_status' => 0
        ]);
    }


    function statusModule()
    {
        $this->db->where('moduleId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('module',['active_status'=>1]);
        }
        else
        {
            $this->db->update('module',['active_status'=>0]);
        }
    }



    function getModule($action)
    {
        return $this->db->from('module')
                        ->order_by('moduleName','ASC')
                        ->get()
                        ->result();

    }

    function getModulebyID($id)
    {
        return $this->db->from('module')
                    ->where('moduleId',$id)
                    ->get()
                    ->row();
    }

    function updateModule()
    {
        $this->db->where('moduleId',$this->input->post('moduleId'))
                ->update('module',[
                    'moduleName'=>ucwords($this->input->post('module')),
                    'tableId'=>$this->input->post('table'),
                    'operationId'=>$this->input->post('operation')
            ]);
    }

    function deleteModule()
    {
        $this->db->where('moduleId',$this->uri->segment(4))
                ->update('module',['delete_status'=>1
            ]);
    }

//------------------------------------------------- MODULE AREA END -------------------------------------------------------------------------------



//------------------------------------------------- ROLE AREA START -------------------------------------------------------------------------------


    var $tableRole = "role";
    var $select_columnRole = array("*");
    var $order_columnRole = array("","roleName","active_status","");

    function make_queryRole()
    {
        $this->db->select($this->select_columnRole);
        $this->db->from($this->tableRole);
        $this->db->where('delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("roleName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_columnRole[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('roleId', 'DESC');
        }
    }

    function fetch_dataRole()
    {
        $this->make_queryRole();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_dataRole()
    {
        $this->make_queryRole();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_dataRole()
    {
        $this->db->select("*");
        $this->db->from($this->tableRole);
        return $this->db->count_all_results();
    }


    function saveRole($rolename)
    {
        return $this->db->insert('role',[
            'roleName' => ucwords($rolename),
            'active_status' => 0,
            'delete_status' => 0
        ]);
    }


    function statusRole()
    {
        $this->db->where('roleId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('role',['active_status'=>1]);
        }
        else
        {
            $this->db->update('role',['active_status'=>0]);
        }
    }

    function getRole()
    {
        return $this->db->from('role')
                        ->order_by('roleId', 'DESC')
                        ->get()
                        ->first_row();
    }

    function getRolebyID()
    {
        return $this->db->from('role')
                        ->where('roleId',$this->uri->segment(4))
                        ->get()
                        ->row();
    }


    function getRoles()
    {
        return $this->db->from('role')
                ->where('role.active_status =',0)
                ->where('role.delete_status =',0)
                ->get()
                ->result();

    }

    function updateRole($roleId)
    {
        $this->db->where('roleId',$roleId)
                ->update('role',[
                    'roleName'=>ucwords($this->input->post('rolename'))
            ]);
    }

    function deleteRole()
    {
        $this->db->where('roleId',$this->uri->segment(4))
                ->update('role',['delete_status'=>1
            ]);
    }

//------------------------------------------------- MODULE AREA END -------------------------------------------------------------------------------




//------------------------------------------------- USER AREA START -------------------------------------------------------------------------------


    var $tableUser = "user";
    var $select_columnUser = array("user.*","role.roleName");
    var $order_columnUser = array("","user.firstName","user.lastName","user.userEmail","user.userMobile","role.roleName","user.active_status","");

    function make_queryUser()
    {
        $this->db->select($this->select_columnUser);
        $this->db->from($this->tableUser);
        $this->db->join('role','role.roleId = user.roleId');
        $this->db->where('user.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("user.firstName", $_POST["search"]["value"]);
                $this->db->or_like("user.lastName", $_POST["search"]["value"]);
                $this->db->or_like("user.userEmail", $_POST["search"]["value"]);
                $this->db->or_like("user.userMobile", $_POST["search"]["value"]);
                $this->db->or_like("role.roleName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_columnUser[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('user.userId', 'DESC');
        }
    }

    function fetch_dataUser()
    {
        $this->make_queryUser();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_dataUser()
    {
        $this->make_queryUser();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_dataUser()
    {
        $this->db->select("*");
        $this->db->from($this->tableUser);
        return $this->db->count_all_results();
    }


    function saveUser()
    {
        return $this->db->insert('user',[
            'firstName' => ucwords($this->input->post('fname')),
            'lastName' => ucwords($this->input->post('lname')),
            'userCode' => strtoupper($this->input->post('userid')),
            'userEmail' => strtolower($this->input->post('email')),
            'userPassword' => md5($this->input->post('password')),
            'userMobile' => $this->input->post('mobile'),
            'roleId' => $this->input->post('role'),
            'active_status' => 0,
            'delete_status' => 0
        ]);
    }


    function statusUser()
    {
        $this->db->where('userId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('user',['active_status'=>1]);
        }
        else
        {
            $this->db->update('user',['active_status'=>0]);
        }
    }

    function getUser()
    {
        return $this->db->from('user')
                        ->where('userId',$this->uri->segment(4))
                        ->get()
                        ->row();
    }

    function getUserbyID()
    {
        return $this->db->from('role')
                        ->where('roleId',$this->uri->segment(4))
                        ->get()
                        ->row();
    }


    function getRUser()
    {
        return $this->db->from('role')
                ->join('accessrights','accessrights.roleId = role.roleId')
                ->join('module','module.moduleId = accessrights.moduleId')
                ->where('role.active_status =',0)
                ->where('role.delete_status =',0)
                ->get()
                ->result();

    }

    function updateUser()
    {
        $this->db->where('userId',$this->input->post('id'))
                ->update('user',[
                    'firstName'=> ucwords($this->input->post('fname')),
                    'lastName'=> ucwords($this->input->post('lname')),
                    'userCode'=> strtoupper($this->input->post('userid')),
                    'userEmail'=> strtolower($this->input->post('email')),
                    'userMobile'=> $this->input->post('mobile'),
                    'roleId'=> $this->input->post('role'),
            ]);
    }

    function deleteUser()
    {
        $this->db->where('userId',$this->uri->segment(4))
                ->update('user',['delete_status'=>1
            ]);
    }

//------------------------------------------------- USER AREA END -------------------------------------------------------------------------------



//------------------------------------------------- RIGHTS AREA START -------------------------------------------------------------------------------

    function saveRights($roleId,$module)
    {
        $this->db->insert('accessrights',[
            'roleId' => $roleId,
            'moduleId' => $module
        ]);
    }


    function getRights()
    {
        return $this->db->where('roleId',$this->uri->segment(4))
                ->get('accessrights')
                ->result();
    }

    function updateRights($roleId)
    {
        $this->db->where('roleId',$roleId)->delete('accessrights');
    }


//------------------------------------------------- RIGHTS AREA END -------------------------------------------------------------------------------

//------------------------------------------------- PERMISSION SETTING START -------------------------------------------------------------------------------

    function getPermissions($roleId,$tableId)
    {
        return $this->db->from('role')
                ->join('accessrights','role.roleId = accessrights.roleId')
                ->join('module','module.moduleId = accessrights.moduleId')
                ->group_start()
                ->where('role.roleId',$roleId)
                ->where('module.tableId',$tableId)
                ->where('module.active_status',0)
                ->where('module.delete_status',0)
                ->group_end()
                ->get()
                ->result();
    }

    function getViewPermissions($roleId)
    {
        return $this->db->from('role')
                ->join('accessrights','role.roleId = accessrights.roleId')
                ->join('module','module.moduleId = accessrights.moduleId')
                ->join('tables','tables.tableId = module.tableId')
                ->group_start()
                ->where('role.roleId',$roleId)
                ->where('module.operationId',1)
                ->where('module.active_status',0)
                ->where('module.delete_status',0)
                ->group_end()
                ->get()
                ->result();
    }


//------------------------------------------------- PERMISSION SETTING END -------------------------------------------------------------------------------


	
}




?>