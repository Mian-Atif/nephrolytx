<?php

namespace App\Http\Controllers\Backend\PracticeManagement;

use App\Models\Practice\Practice;
use App\Models\Speciality;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use App\Repositories\Backend\PracticeManagement\PracticeManagementRepository;
use App\Http\Requests\Backend\PracticeManagement\ManagePracticeManagementRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * PracticeManagementsController
 */
class PracticeManagementsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeManagementRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeManagementRepository $repository;
     */
    public function __construct(PracticeManagementRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PracticeManagement\ManagePracticeManagementRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeManagementRequest $request)
    {

        $states = State::get();
        $practice  = Practice::find(Auth::user()->practice_id);
        $specialities=Speciality::where('model_type','practice')->get();
        $paraciteTypes=Config::get('constants.paracite_type')?Config::get('constants.paracite_type'):'';
        return new ViewResponse('backend.practicemanagements.index',compact('states','practice','specialities','paraciteTypes'));
    }

    public  function  updatePractice(Request $request){
        $this->repository->updatepractice($request);
        return back()->with('message','Update Practice Successfully !!');
    }


    
}
