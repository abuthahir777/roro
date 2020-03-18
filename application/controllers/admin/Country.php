<?php
class Country extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('Country_Model'));

		$this->load->library(array('Layouts'));

		if($this->session->userdata('userdata') == NULL)
		{
			header("Location:".$this->config->item("base_url")."/admin");
		}
	
	}


	function index()
	{
		$this->layouts->title('Applications');
		$this->layouts->view('pages/admin/country/table','','admin');
	}

	function fetch()
	{
		$permission = $this->permission->setRights($this->session->userdata('roleId'),1);

		$fetch_data = $this->Country_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->countryCode;
			$sub_array[] = $row->countryName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';								
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 				
			}

			if(isset($permission))
			{
				if(isset($permission['view']))
				{
					$view = '';
				}
				else
				{
					$view = '';
				}

				if(isset($permission['status']))
				{
					if($row->active_status == 1)
					{
						$status = '<a href ="'.base_url('admin/country').'/status/activate/'.$row->countryId.'" type="submit" name="delete" id="'.$row->countryId.'" class="update" ><i class="fa fa-check-square"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/country').'/status/deactivate/'.$row->countryId.'" type="submit" name="delete" id="'.$row->countryId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($permission['update']))
				{
					$update = '<a href ="'.base_url('admin/country').'/edit/'.$row->countryId.'" type="submit" name="edit" id="'.$row->countryId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/airport').'/delete/'.$row->airportId.'" type="submit" name="edit" id="'.$row->airportId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}
			}


			$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';   
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->Country_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Country_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/country/form','','admin');
	}

	function save()
	{
		$this->Country_Model->save();
		header("Location:".$this->config->item("base_url")."/admin/country");
	}


	function status()
	{
		$this->Country_Model->status();
		header("Location:".$this->config->item("base_url")."/admin/country");

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['country'] = $this->Country_Model->get();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/country/form',$data,'admin');
	}

	function update()
	{
		$this->Country_Model->update();
		header("Location:".$this->config->item("base_url")."/admin/country");
	}

	function delete()
	{
		$this->Country_Model->delete();
		header("Location:".$this->config->item("base_url")."/admin/country");
	}


	function checkCode()
	{
		$data = $this->Country_Model->checkCode();

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