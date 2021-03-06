<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('currency',[
            'currencyCode'=>strtoupper($this->input->post('code')),
            'currencyName'=>ucwords($this->input->post('currency')),
            'countryid'=>$this->input->post('country'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "currency";
    var $select_column = array("country.countryId","country.countryName","currency.currencyId","currency.currencyCode","currency.currencyName","currency.active_status","currency.delete_status");
    var $order_column = array("","stateName","countryName", "active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('country','country.countryId = currency.countryId');
        $this->db->where('currency.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("currency.currencyName", $_POST["search"]["value"]);
                $this->db->or_like("currency.currencyCode", $_POST["search"]["value"]);
                $this->db->or_like("country.countryName", $_POST["search"]["value"]);
                $this->db->or_like("currency.active_status", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('currency.currencyId', 'DESC');
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
        $this->db->where('currencyId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('currency',['active_status'=>1]);
        }
        else
        {
            $this->db->update('currency',['active_status'=>0]);
        }
    }

    function get($id)
    {
        return $this->db->from('currency')
                    ->where('currency.currencyId',$id)
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
        $this->db->where('currencyId',$this->input->post('currencyId'))
                ->update('currency',['currencyCode'=>strtoupper($this->input->post('code')),
                    'currencyName'=>ucwords($this->input->post('currency')),
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