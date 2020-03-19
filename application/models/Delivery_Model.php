<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('deliverytype',[
            'currencyName'=>ucfirst($this->input->post('currency')),
            'countryid'=>$this->input->post('country'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "deliverytype";
    var $select_column = array("*");
    var $order_column = array("","deliveryTypeName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->where('delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("deliveryTypeName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('deliveryTypeId', 'DESC');
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
        $this->db->where('deliveryTypeId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('deliverytype',['active_status'=>1]);
        }
        else
        {
            $this->db->update('deliverytype',['active_status'=>0]);
        }
    }

    function get()
    {
        return $this->db->from('currency')
                    ->where('currency.currencyId',$this->uri->segment(4))
                    ->join('country','country.countryId = currency.countryId')
                    ->get()
                    ->row();
    }


    function getall()
    {
        return $this->db->from('currency')
                    ->join('country','country.countryId = currency.countryId')
                    ->where('currency.active_status',0)
                    ->where('currency.delete_status',0)
                    ->get()
                    ->result();
    }


    function getSpecific()
    {
        return $this->db->where('countryid',$this->input->post('countryId'))
                        ->where('active_status',0)
                        ->where('delete_status',0)
                        ->get('currency')
                        ->result();
    }


    function update()
    {
        $this->db->where('currencyId',$this->input->post('id'))
                ->update('currency',['currencyCode'=>$this->input->post('code'),
                    'currencyName'=>$this->input->post('currency'),
                    'countryid'=>$this->input->post('country')
            ]);
    }


    function delete()
    {
        $this->db->where('currencyId',$this->uri->segment(4))
                ->update('currency',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('currencyCode',$this->input->post('code'))
                        ->where('currencyId!=',$this->input->post('id'))
                        ->get('currency')
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