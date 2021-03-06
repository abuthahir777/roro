<?php
class Customer extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('Customer_Model','User_Model','Country_Model','State_Model','City_Model','BusinessType_Model','ShipmentFrequency_Model'));

		$this->page = $this->config->item("base_url_admin")."/customer";

		//$this->permission = $this->permission->setRights($this->session->userdata('roleId'),11);
		$this->permission = array('create' => 1, 'view'=>1, 'update'=>1 , 'delete'=>1 , 'status'=>1);

		if(!$this->session->userdata('fname') && 
			!$this->session->userdata('lname') &&
			!$this->session->userdata('userId') && 
			!$this->session->userdata('email') &&
			!$this->session->userdata('mobile') && 
			!$this->session->userdata('roleId') &&
			!$this->session->userdata('loggedin'))
		{
			header("Location:".$this->config->item("base_url_admin"));
		}
	
	}


	function index()
	{

		if(isset($this->permission['create']))
		{
			$data['create'] = "create";
		}
		else{ $data = ""; }

		$this->layouts->title('Customer Table');
		$this->layouts->view('pages/admin/customer/table',$data,'admin');
	}

	function fetch()
	{

		$fetch_data = $this->Customer_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->customerFname;
			$sub_array[] = $row->customerLname;
			$sub_array[] = $row->customerEmail;
			$sub_array[] = $row->customerMobile;
			$sub_array[] = $row->customerCompany;
			$sub_array[] = $row->customerAddress;
			$sub_array[] = $row->countryName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';								
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 				
			}

			if(isset($this->permission))
			{
				if(isset($this->permission['view']))
				{
					$view = '';
				}
				else
				{
					$view = '';
				}

				if(isset($this->permission['status']))
				{
					if($row->active_status == 1)
					{
						$status = '<a href ="'.base_url('admin/customer').'/status/activate/'.$row->customerId.'" type="submit" name="delete" id="'.$row->customerId.'" class="update" ><i class="fa fa-toggle-off"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/customer').'/status/deactivate/'.$row->customerId.'" type="submit" name="delete" id="'.$row->customerId.'" class="update" ><i class="fa fa-toggle-on"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/customer').'/edit/'.$row->customerId.'" type="submit" name="edit" id="'.$row->customerId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/customer').'/delete/'.$row->customerId.'" type="submit" name="edit" id="'.$row->customerId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}

				$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';
			}
			else
			{
				$sub_array[] = '<div align="center">NO ACTIONS ALLOWED</div>';
			}
  
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->Customer_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Customer_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['country'] = $this->Country_Model->getall();
		$data['businessType'] = $this->BusinessType_Model->getall();
		$data['shipmentFreq'] = $this->ShipmentFrequency_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/customer/form',$data,'admin');
	}

	function save()
	{
		$config['allowed_types'] = 'doc|docx|pdf|jpg|png';
		$config['upload_path'] = './forms/IDProof';
		$config['file_name'] = $this->input->post('fname')."_".$this->input->post('lname')."_".$this->input->post('cname');

		$this->load->library('upload',$config);

		if($this->upload->do_upload('idproof'))
		{
			$this->Customer_Model->save();
			$this->session->set_flashdata('save','Saved');
		}
		else
		{
			$this->session->set_flashdata('uploaderror',$this->upload->display_errors());
		}
		
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Customer_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['customer'] = $this->Customer_Model->get($this->uri->segment(4));
		$data['country'] = $this->Country_Model->getall();
		$data['businessType'] = $this->BusinessType_Model->getall();
		$data['shipmentFreq'] = $this->ShipmentFrequency_Model->getall();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/customer/form',$data,'admin');
	}

	function update()
	{
		$this->Customer_Model->update();
		$this->session->set_flashdata('update','Updated');
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->Customer_Model->delete();
		$this->session->set_flashdata('delete','Deleted');
		header("Location:".$this->page);
	}


	function fetchState()
	{
		$states = $this->State_Model->getSpecific();

		if($states)
		{
			echo '<option value="">Select State</option>';
			foreach($states as $row)
			{
				echo '<option value="'.$row->stateId.'">'.$row->stateName.'</option>';
			}
		}
		else
		{
			echo '<option value="">No State</option>';
		}
	}

	function fetchCity()
	{
		$cities = $this->City_Model->getSpecific();

		if($cities)
		{
			echo '<option value="">Select City</option>';
			foreach($cities as $row)
			{
				echo '<option value="'.$row->cityId.'">'.$row->cityName.'</option>';
			}
		}
		else
		{
			echo '<option value="">No City</option>';
		}
	}


	function checkPwd()
	{
		$data = $this->Customer_Model->checkCustomer($this->input->post('custId'));

		if(isset($data))
		{
			$customer['item'] = "enable";
		}
		else
		{
			$customer['item'] = "disable";
		}

		echo json_encode($customer);
		
	}

	function updatePwd()
	{
		$this->Customer_Model->updatePwd();
		header("Location:".$this->page);
	}


} ?>