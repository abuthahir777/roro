<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function validate($username,$password)
    {
        $status = $this->db->from('users')
                    ->where('userName',$username)
                    ->where('userPassword',md5($password))
                    ->get()
                    ->num_rows();

        if($status =0)
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
                    ->get()
                    ->result();
    }


    function saveModule()
    {
        $this->db->insert('module',[
            'moduleName' => $this->input->post('modulename'),
            'tableId' => $this->input->post('table'),
            'operationId' => $this->input->post('operation'),
            'active_status' => 0,
            'delete_status' => 0
        ]);
    }

    function getModule($action)
    {
        $this->db->from('module');
        if($action == 'specific')
        {
            $this->db->where('moduleId',$this->uri->segment(4));
        }
        $data = $this->db->get();

        if($action == 'specific')
        {
            return $data->row();
        }
        else
        {
            return $data->result();
        }
    }

    function updateModule()
    {
        $this->db->where('moduleId',$this->input->post('id'))
                ->update('module',[
                    'moduleName'=>$this->input->post('modulename'),
                    'tableId'=>$this->input->post('table'),
                    'operationId'=>$this->input->post('operation')
            ]);
    }


    function getSpecific()
    {
        return $this->db->where('countryid',$this->input->post('countryId'))
                        ->where('active_status',0)
                        ->where('delete_status',0)
                        ->get('state')
                        ->result();
    }


    function update()
    {
        $this->db->where('stateId',$this->input->post('id'))
                ->update('state',[
                    'stateCode'=>$this->input->post('code'),
                    'stateName'=>$this->input->post('state'),
                    'countryid'=>$this->input->post('country')
            ]);
    }


    function delete()
    {
        $this->db->where('stateId',$this->uri->segment(4))
                ->update('state',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('stateCode',$this->input->post('code'))
                        ->where('stateId!=',$this->input->post('id'))
                        ->get('state')
                        ->num_rows();

        if($status >=1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	
}




?>