<?php

namespace App\Http\Controllers\Backend\Revenue;

use App\Models\Revenue\Revenue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Revenue\CreateResponse;
use App\Http\Responses\Backend\Revenue\EditResponse;
use App\Repositories\Backend\Revenue\RevenueRepository;
use App\Http\Requests\Backend\Revenue\ManageRevenueRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * RevenuesController
 */
class RevenuesController extends Controller
{
    /**
     * variable to store the repository object
     * @var RevenueRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param RevenueRepository $repository;
     */
    public function __construct(RevenueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Revenue\ManageRevenueRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index($type=null)
    {
        $practice_id= Auth::user()->practice_id ;
        $patientLists = DB::select('call patient_list(?,?)',[$practice_id,$type]);


        if($type == 'active'){
            $page_title = 'Active Patients List';
        }elseif($type == 'new'){
            $page_title = 'New Patients List';
        }elseif($type == 'ckd'){
            $page_title = 'Non-ESRD Patients List';
        }elseif($type == 'esrd'){
            $page_title = 'ESRD Patients List';
        }elseif($type == 'early'){
            $page_title = 'Early Stage CKD Patients List';
        }elseif($type == 'late'){
            $page_title = 'Late Stage CKD Patients List';
        }elseif($type == 'all'){
            $page_title = 'Patients List';
        }elseif($type == 'noinsurance'){
            $page_title = 'Patients With No Insurance';
        }elseif($type == 'early_this_year'){
            $page_title = 'CKD Patients Comparison (Early-Stage This Year)';
        }elseif($type == 'early_prior_year'){
            $page_title = 'CKD Patients Comparison (Early-Stage Prior Year)';
        }elseif($type == 'late_this_year'){
            $page_title = 'CKD Patients Comparison (Late-Stage This Year)';
        }elseif($type == 'late_prior_year'){
            $page_title = 'CKD Patients Comparison (Late-Stage Prior Year)';
        }elseif($type == 'esrd_this_year'){
            $page_title = 'CKD Patients Comparison (ESRD This Year)';
        }elseif($type == 'esrd_prior_year'){ // Below
            $page_title = 'CKD Patients Comparison (ESRD Prior Year)';
        }elseif($type == 'bmi_below_practice_id86'){
            $page_title = 'CKD Patient/BMI (18.6)';
        }elseif($type == 'bmi_rng_practice_id86_249'){
            $page_title = 'CKD Patient/BMI (18.6-24.9)';
        }elseif($type == 'bmi_rng_250_299'){
            $page_title = 'CKD Patient/BMI (25.0-29.0)';
        }elseif($type == 'bmi_equal_above_300'){
            $page_title = 'CKD Patient/BMI (30.0 & Above)';
        }
        $clinical_slugs = array('early','late');    
        if(in_array($type, $clinical_slugs)){
            return new ViewResponse('backend.clinical.table',compact('patientLists','page_title'));
        }else{
            return new ViewResponse('backend.revenues.index',compact('patientLists','page_title'));
        }
    }
    public function patientDetail($id){

        
        $practice_id= Auth::user()->practice_id ;
        $patientSearch = DB::select('call patient_search(?,?)',[$practice_id,$id]);
        $patientSearch = $patientSearch[0];

        
        $patientVisitHistory = DB::select('call patient_visit_history(?,?)',[$practice_id,$id]);

        $patientLabHistory = DB::select('call patient_lab_history(?,?)',[$practice_id,$id]);
        

        return new ViewResponse('backend.patients.detail',compact('patientSearch','patientVisitHistory','patientLabHistory'));
    }
}
