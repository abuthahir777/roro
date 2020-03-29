<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ShipmentFrequency_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('shipmentfrequency',[
            'freqShipmentName'=>ucwords($this->input->post('shipmentName')),
            'active_status'=>0,
            'delete_status'=>0]);
    }

    var $table = "shipmentfrequency";
    var $select_column = array("*");
    var $order_column = array("","freqShipmentName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("freqShipmentName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('freqShipmentName', 'ASC');
        }
    }

    function fetch_data()
    {
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    function status()
    {
        $this->db->where('freqShipmentId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('shipmentfrequency',['active_status'=>1]);
        }
        else
        {
            $this->db->update('shipmentfrequency',['active_status'=>0]);
        }
    }

    function getall()
    {
        return $this->db->where('active_status',0)
                    ->where('delete_status',0)
                    ->get('shipmentfrequency')
                    ->result();
    }

    function get($id)
    {
        return $this->db->where('freqShipmentId',$id)
                    ->get('shipmentfrequency')
                    ->row();
    }


    function update()
    {
        $this->db->where('freqShipmentId',$this->input->post('shipmentId'))
                ->update('shipmentfrequency',[
                    'freqShipmentName'=>ucwords($this->input->post('shipmentName'))
            ]);
    }


    function delete()
    {
        $this->db->where('freqShipmentId',$this->uri->segment(4))
                ->update('shipmentfrequency',['delete_status'=>1]);
    }
	
}




?>