<?php
class City extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('State_Model','Country_Model','City_Model'));

		$this->page = $this->config->item("base_url_admin")."/city";

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

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),3);
	
	}


	function index()
	{
		if(isset($this->permission['create']))
		{
			$data['create'] = "Create";			
		}else{$data['NULL'] = "";}
		
		$data['country'] = $this->Country_Model->getall();
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/city/table',$data,'admin');
	}

	function fetch()
	{

		$fetch_data = $this->City_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->cityCode;
			$sub_array[] = $row->cityName;
			$sub_array[] = $row->stateName;
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
						$status = '<a href ="'.base_url('admin/city').'/status/activate/'.$row->cityId.'" type="submit" name="delete" id="'.$row->cityId.'" class="update" ><i class="fa fa-toggle-off"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/city').'/status/deactivate/'.$row->cityId.'" type="submit" name="delete" id="'.$row->cityId.'" class="update" ><i class="fa fa-toggle-on"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($this->permission['update']))
				{
					$update = '<a type="submit" name="edit" id="'.$row->cityId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/city').'/delete/'.$row->cityId.'" type="submit" name="edit" id="'.$row->cityId.'" class="edit" ><i class="fa fa-trash"></i></a>';
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
			"recordsTotal"          =>     $this->City_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->City_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function action()
	{
		if($this->input->post('action')=="save")
		{
			$this->City_Model->save();
			$this->session->set_flashdata('save','Saved');
		}
		else
		{
			$this->City_Model->update();
			$this->session->set_flashdata('update','Updated');
		}
		
		header("Location:".$this->page);
	}

	function status()
	{
		$this->City_Model->status();
		header("Location:".$this->page);

	}

	function delete()
	{
		$this->City_Model->delete();
		$this->session->set_flashdata('delete','Deleted');
		header("Location:".$this->page);
	}

	function getbyID()
	{
		$data = $this->City_Model->get($this->input->post("id"));

		$output['country'] = $data->countryId;
		$output['state'] = $data->stateId;
		$output['code'] = $data->cityName;
		$output['city'] = $data->cityCode;
		echo json_encode($output);
	}

	function checkCode()
	{
		$data = $this->City_Model->checkCode();

		if($data)
		{
			echo "Already Exists";
		}
		else
		{
			echo "";
		}

	}

} ?>