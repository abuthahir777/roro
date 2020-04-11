<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model extends CI_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $this->db->insert('customer',[
            'customerFname'=>ucwords($this->input->post('fname')),
            'customerLname'=>ucwords($this->input->post('lname')),
            'customerEmail'=>strtolower($this->input->post('email')),
            'customerMobile'=>$this->input->post('mobile'),
            'customerPassword'=>md5($this->input->post('password')),
            'customerCity'=>$this->input->post('city'),
            'customerState'=>$this->input->post('state'),
            'customerCountry'=>$this->input->post('country'),
            'customerCompany'=>ucwords($this->input->post('cname')),
            'customerAddress'=>ucwords($this->input->post('caddress')),
            'customerBusinessType'=>$this->input->post('businesstype'),
            'customerShipmentFrequency'=>$this->input->post('shipmentFrequency'),
            'customerIDName'=>$this->upload->data('file_name'),
            'active_status'=>1,
            'delete_status'=>0]);
    }

    var $table = "customer";
    var $select_column = array("customer.customerId","customer.customerFname","customer.customerLname","customer.customerEmail","customer.customerMobile","customer.customerCompany","customer.customerAddress","country.countryName","customer.active_status");
    var $order_column = array("","customer.customerFname","customer.customerLname","customer.customerEmail","customer.customerMobile","customer.customerCompany","customer.customerAddress","country.countryName", "customer.active_status", "");

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join("country","country.countryId = customer.customerCountry");
        $this->db->where('customer.delete_status =',0);

        if(isset($_POST["search"]["value"]))
        {
            $this->db->group_start();
                $this->db->like("customer.customerFname", $_POST["search"]["value"]);
                $this->db->or_like("customer.customerLname", $_POST["search"]["value"]);
                $this->db->or_like("customer.customerEmail", $_POST["search"]["value"]);
                $this->db->or_like("customer.customerMobile", $_POST["search"]["value"]);
                $this->db->or_like("customer.customerCompany", $_POST["search"]["value"]);
                $this->db->or_like("customer.customerAddress", $_POST["search"]["value"]);
                $this->db->or_like("country.countryName", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('customer.customerFname', 'ASC');
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
        $this->db->where('customerId',$this->uri->segment(5));
        if($this->uri->segment(4)=="deactivate")
        {
            $this->db->update('customer',['active_status'=>1]);
        }
        else
        {
            $this->db->update('customer',['active_status'=>0]);
        }
    }

    function getall()
    {
        return $this->db->where('active_status',0)
                    ->where('delete_status',0)
                    ->get('country')
                    ->result();
    }

    function get($id)
    {
        return $this->db->where('customerId',$id)
                    ->get('customer')
                    ->row();
    }


    function update()
    {
        $this->db->where('customerId',$this->input->post('id'))
                ->update('customer',[
                    'customerFname'=>ucwords($this->input->post('fname')),
                    'customerLname'=>ucwords($this->input->post('lname')),
                    'customerEmail'=>strtolower($this->input->post('email')),
                    'customerMobile'=>$this->input->post('mobile'),
                    'customerCity'=>$this->input->post('city'),
                    'customerState'=>$this->input->post('state'),
                    'customerCountry'=>$this->input->post('country'),
                    'customerCompany'=>ucwords($this->input->post('cname')),
                    'customerAddress'=>ucwords($this->input->post('caddress')),
                    'customerBusinessType'=>$this->input->post('businesstype'),
                    'customerShipmentFrequency'=>$this->input->post('shipmentFrequency')
                ]);

    }


    function delete()
    {
        $this->db->where('customerId',$this->uri->segment(4))
                ->update('customer',['delete_status'=>1
            ]);
    }


    function checkCode()
    {
        $status = $this->db->where('countryCode',$this->input->post('code'))
                        ->where('countryId!=',$this->input->post('id'))
                        ->get('country')
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


    function checkCustomer()
    {
        $query = $this->db->where('customerId',$this->input->post('custId'))
        ->where('customerPassword',md5($this->input->post('custPwd')))
        ->get('customer');

        if($query->num_rows() >0)
        {
            return $query->row();
        }
    }

    function updatePwd()
    {
        $this->db->update('customer',[
            'customerPassword' => md5($this->input->post('newpwd'))
        ]);
    }


	
}




?>