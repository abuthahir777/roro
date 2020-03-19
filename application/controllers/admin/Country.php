<?php
class Country extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->model(array('Country_Model'));

		$this->page = $this->config->item("base_url_admin")."country";

		$this->permission = $this->permission->setRights($this->session->userdata('roleId'),1);

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

		$this->layouts->title('Applications');
		$this->layouts->view('pages/admin/country/table',$data,'admin');
	}

	function fetch()
	{

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

				if(isset($this->permission['update']))
				{
					$update = '<a href ="'.base_url('admin/country').'/edit/'.$row->countryId.'" type="submit" name="edit" id="'.$row->countryId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($this->permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/country').'/delete/'.$row->countryId.'" type="submit" name="edit" id="'.$row->countryId.'" class="edit" ><i class="fa fa-trash"></i></a>';
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
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Country_Model->status();
		header("Location:".$this->page);

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
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->Country_Model->delete();
		header("Location:".$this->page);
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