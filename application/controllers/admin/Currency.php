<?php
class Currency extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('Currency_Model','Country_Model'));

		$this->page = $this->config->item("base_url")."/admin/currency";

		if($this->session->userdata('userdata') == NULL)
		{
			header("Location:".$this->config->item("base_url_admin"));
		}
	
	}

	function check()
	{
		$data = $this->State_Model->alldatas();
		echo '<pre>'; print_r($data); echo '</pre>';
	}


	function index()
	{
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/currency/table','','admin');
	}

	function fetch()
	{
		$permission = $this->permission->setRights($this->session->userdata('roleId'),6);

		$fetch_data = $this->Currency_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->currencyCode;
			$sub_array[] = $row->currencyName;
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
						$status = '<a href ="'.base_url('admin/currency').'/status/activate/'.$row->currencyId.'" type="submit" name="delete" id="'.$row->currencyId.'" class="update" ><i class="fa fa-check-square"></i></a>';
					}
					else
					{
						$status = '<a href ="'.base_url('admin/currency').'/status/deactivate/'.$row->currencyId.'" type="submit" name="delete" id="'.$row->currencyId.'" class="update" ><i class="fa fa-check"></i></a>';
					}
				}
				else
				{
					$status = '';
				}

				if(isset($permission['update']))
				{
					$update = '<a href ="'.base_url('admin/currency').'/edit/'.$row->currencyId.'" type="submit" name="edit" id="'.$row->currencyId.'" class="edit" ><i class="fa fa-edit"></i></a>';
				}
				else
				{
					$update = '';
				}

				if(isset($permission['delete']))
				{
					$delete = '<a href ="'.base_url('admin/currency').'/delete/'.$row->currencyId.'" type="submit" name="edit" id="'.$row->currencyId.'" class="edit" ><i class="fa fa-trash"></i></a>';
				}
				else
				{
					$delete = '';
				}

				$sub_array[] = '<div align="center">'.$status.'&nbsp&nbsp'.$update.'&nbsp&nbsp'.$delete.'</div>';
			}
			else
			{
				$sub_array[] = '<div align="center">NO ACTIONS</div>';
			}

			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->Currency_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->Currency_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['country'] = $this->Country_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/currency/form',$data,'admin');
	}

	function save()
	{
		$this->Currency_Model->save();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->Currency_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['currency'] = $this->Currency_Model->get();
		$data['countries'] = $this->Country_Model->getall();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/currency/form',$data,'admin');
	}

	function update()
	{
		$this->Currency_Model->update();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->Currency_Model->delete();
		header("Location:".$this->page);
	}

	function checkCode()
	{
		$data = $this->Currency_Model->checkCode();

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