<?php

namespace App\Models\SSO;

class AppLoginResponseDTO
{
	private $username;
    private $employee_record_id;
    private $office_id;
    private $designation;
    private $office_unit_id;
    private $incharge_label;
    private $office_unit_organogram_id;
    private $office_name_eng;
    private $office_name_bng;
    private $office_ministry_id;
    private $office_ministry_name_eng;
    private $office_ministry_name_bng;
    private $unit_name_eng;
    private $unit_name_bng;
    private $landing_page_url;    

	public function getUserName(){return $this->username;}
    public function getEmployeeRecordId(){return $this->employee_record_id;}
    public function getOfficeId(){return $this->office_id;}
    public function getDesignation(){return $this->designation;}
    public function getOfficeUnitId(){return $this->office_unit_id;}
    public function getInchargeLabel(){return $this->incharge_label;}
    public function getOfficeUnitOrganogramId(){return $this->office_unit_organogram_id;}
    public function getOfficeNameEng(){return $this->office_name_eng;}
    public function getOfficeNameBng(){return $this->office_name_bng;}
    public function getOfficeMinistryId(){return $this->office_ministry_id;}
    public function getOfficeMinistryNameEng(){return $this->office_ministry_name_eng;}
    public function getOfficeMinistryNameBng(){return $this->office_ministry_name_bng;}
    public function getUnitNamEng(){return $this->unit_name_eng;}
    public function getUnitNameBng(){return $this->unit_name_bng;}
    public function getLandingPageUrl(){return $this->landing_page_url;}

	public function setUserName($username){$this->username = $username;}
    public function setEmployeeRecordId($employee_record_id){$this->employee_record_id = $employee_record_id;}
    public function setOfficeId($office_id){$this->office_id = $office_id;}
    public function setDesignation($designation){$this->designation = $designation;}
    public function setOfficeUnitId($office_unit_id){$this->office_unit_id = $office_unit_id;}
    public function setInchargeLabel($incharge_label){$this->incharge_label = $incharge_label;}
    public function setOfficeUnitOrganogramId($office_unit_organogram_id){$this->office_unit_organogram_id = $office_unit_organogram_id;}
    public function setOfficeNameEng($office_name_eng){$this->office_name_eng = $office_name_eng;}
    public function setOfficeNameBng($office_name_bng){$this->office_name_bng = $office_name_bng;}
    public function setOfficeMinistryId($office_ministry_id){$this->office_ministry_id = $office_ministry_id;}
    public function setOfficeMinistryNameEng($office_ministry_name_eng){$this->office_ministry_name_eng = $office_ministry_name_eng;}
    public function setOfficeMinistryNameBng($office_ministry_name_bng){$this->office_ministry_name_bng = $office_ministry_name_bng;}
    public function setUnitNameEng($unit_name_eng){$this->unit_name_eng = $unit_name_eng;}
    public function setUnitNameBng($unit_name_bng){$this->unit_name_bng = $unit_name_bng;}
    public function setLandingPageUrl($landing_page_url){$this->landing_page_url = $landing_page_url;}

}