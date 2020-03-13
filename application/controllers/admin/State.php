<?php
class State extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model(array('State_Model','Country_Model','Excel_Model'));

		$this->load->library(array('Layouts','Excel'));

		$this->page = $this->config->item("base_url")."/admin/state";
	
	}

	function check()
	{
		$data = $this->State_Model->alldatas();
		echo '<pre>'; print_r($data); echo '</pre>';
	}


	function index()
	{
		$this->layouts->title('State Table');
		$this->layouts->view('pages/admin/state/table','','admin');
	}

	function fetch()
	{
		$fetch_data = $this->State_Model->fetch_data();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
			$sub_array = array(); 
			$sub_array[] = $i;   
			$sub_array[] = $row->stateCode;
			$sub_array[] = $row->stateName;
			$sub_array[] = $row->countryName;

			if($row->active_status == 1)
			{
				$sub_array[] = '<span class="badge badge-danger">In-Active</span>';
				$status = '<a href ="'.base_url('admin/state').'/status/activate/'.$row->stateId.'" type="submit" name="delete" id="'.$row->stateId.'" class="update" ><i class="fa fa-check-square"></i></a>';
			}
			else
			{
				$sub_array[] = '<span class="badge badge-success">Active</span>'; 
				$status = '<a href ="'.base_url('admin/state').'/status/deactivate/'.$row->stateId.'" type="submit" name="delete" id="'.$row->stateId.'" class="update" ><i class="fa fa-check"></i></a>';
			}


			$sub_array[] = '<div align="center">
			'.$status.'&nbsp&nbsp
			<a href ="'.base_url('admin/state').'/edit/'.$row->stateId.'" type="submit" name="edit" id="'.$row->stateId.'" class="edit" ><i class="fa fa-edit"></i></a>
			&nbsp&nbsp
			<a href ="'.base_url('admin/state').'/delete/'.$row->stateId.'" type="submit" name="edit" id="'.$row->stateId.'" class="edit" ><i class="fa fa-trash"></i></a>
			</div>';   
			$data[] = $sub_array;  
			$i++;

		}  
		$output = array(  
			"draw"                  =>     intval($_POST["draw"]),  
			"recordsTotal"          =>     $this->State_Model->get_all_data(),  
			"recordsFiltered"     	=>     $this->State_Model->get_filtered_data(),  
			"data"                  =>     $data  
			);  
		echo json_encode($output);
	}

	function add()
	{
		$data['country'] = $this->Country_Model->getall();

		$this->layouts->title('Add');
		$this->layouts->view('pages/admin/state/form',$data,'admin');
	}

	function save()
	{
		$this->State_Model->save();
		header("Location:".$this->page);
	}


	function status()
	{
		$this->State_Model->status();
		header("Location:".$this->page);

	}

	function edit()
	{
		$data['edit'] = $this->uri->segment(3);
		$data['state'] = $this->State_Model->get();
		$data['countrys'] = $this->Country_Model->getall();

		// echo '<pre>'; print_r($data); echo '</pre>';exit();

		$this->layouts->title('Edit');
		$this->layouts->view('pages/admin/state/form',$data,'admin');
	}

	function update()
	{
		$this->State_Model->update();
		header("Location:".$this->page);
	}

	function delete()
	{
		$this->State_Model->delete();
		header("Location:".$this->page);
	}


	function checkCode()
	{
		$data = $this->State_Model->checkCode();

		if($data)
		{
			echo "Already Exists";
		}
		else
		{
			echo "";
		}

	}



	function formexcel()
	{
		$this->load->view('pages/formexcel');
	}



	function importExcel()
	{
		if(isset($_FILES["excelfile"]["tmp_name"]))
		{
			$path = $_FILES["excelfile"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow =$worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();


				for($row=2; $row <= $highestRow; $row++)
				{

					$countryCode = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
					$countryName = $worksheet->getCellByColumnAndRow(1,$row)->getValue();

					if($countryCode != "" && $countryName != "")
					{
						$countryStatus = $this->Excel_Model->countryCheck($countryCode,$countryName);
					}
					

					if(isset($countryStatus))
					{
						$this->Excel_Model->countryInsert($countryCode,$countryName);
						$countryStatus = $this->Excel_Model->countryGet($countryCode);

					}


					$stateCode = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
					$stateName = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
					$stateStatus = $this->Excel_Model->stateCheck($countryStatus->countryId,$stateCode,$stateName);


					if(!$stateStatus)
					{
						$this->Excel_Model->stateInsert($countryStatus->countryId,$stateCode,$stateName);
						$stateStatus = $this->Excel_Model->stateGet($countryStatus->countryId,$stateCode);
						
					}


					$cityCode = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
					$cityName = $worksheet->getCellByColumnAndRow(5,$row)->getValue();
					$cityStatus = $this->Excel_Model->cityCheck($stateStatus->countryId,$stateStatus->stateId,$cityCode);

					if(!$cityStatus)
					{
						$this->Excel_Model->cityInsert($stateStatus->countryId,$stateStatus->stateId,$cityCode,$cityName);
						$cityStatus = $this->Excel_Model->cityGet($stateStatus->countryId,$stateStatus->stateId,$cityCode);
						
					}
					

				}

				
				
			}

			header("Location: ".$this->page);
		}
		else
		{
			echo "no file";
		}
	}


	public function download()
	{
		$this->load->helper('download');
		$file = 'forms/CSC/PlaceForm.xlsx';

		force_download($file,NULL);
	}

	public function hai()
	{
		$num ="haii";
		if(isset($num))
		{
			echo "haii";
		}
		else
		{
			echo "not";
		}
	}

} ?>