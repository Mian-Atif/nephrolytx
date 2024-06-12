<?php

namespace App\Http\Controllers\Backend\PracticeUserManagement;

use App\Models\Access\User\User;
use App\Models\Practice\Practice;
use App\Models\PracticeLocations\PracticeLocation;
use App\Models\PracticeUserManagement\PracticeUserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PracticeUserManagement\CreateResponse;
use App\Http\Responses\Backend\PracticeUserManagement\EditResponse;
use App\Repositories\Backend\PracticeUserManagement\PracticeUserManagementRepository;
use App\Http\Requests\Backend\PracticeUserManagement\ManagePracticeUserManagementRequest;
use App\Http\Requests\Backend\PracticeUserManagement\CreatePracticeUserManagementRequest;
use App\Http\Requests\Backend\PracticeUserManagement\StorePracticeUserManagementRequest;
use App\Http\Requests\Backend\PracticeUserManagement\EditPracticeUserManagementRequest;
use App\Http\Requests\Backend\PracticeUserManagement\UpdatePracticeUserManagementRequest;
use App\Http\Requests\Backend\PracticeUserManagement\DeletePracticeUserManagementRequest;

/**
 * PracticeUserManagementsController
 */
class PracticeUserManagementsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeUserManagementRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeUserManagementRepository $repository;
     */
    public function __construct(PracticeUserManagementRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PracticeUserManagement\ManagePracticeUserManagementRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeUserManagementRequest $request)
    {
        $users = Practice::find(Auth::user()->practice_id);
        return new ViewResponse('backend.practiceusermanagements.index',compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePracticeUserManagementRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PracticeUserManagement\CreateResponse
     */
    public function create(CreatePracticeUserManagementRequest $request)
    {
        return new CreateResponse('backend.practiceusermanagements.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePracticeUserManagementRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePracticeUserManagementRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.practiceusermanagements.index'), ['flash_success' => trans('alerts.backend.practiceusermanagements.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\PracticeUserManagement\PracticeUserManagement  $practiceusermanagement
     * @param  EditPracticeUserManagementRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PracticeUserManagement\EditResponse
     */
    public function edit(PracticeUserManagement $practiceusermanagement, EditPracticeUserManagementRequest $request)
    {
        return new EditResponse($practiceusermanagement);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePracticeUserManagementRequestNamespace  $request
     * @param  App\Models\PracticeUserManagement\PracticeUserManagement  $practiceusermanagement
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePracticeUserManagementRequest $request, PracticeUserManagement $practiceusermanagement)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $practiceusermanagement, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.practiceusermanagements.index'), ['flash_success' => trans('alerts.backend.practiceusermanagements.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePracticeUserManagementRequestNamespace  $request
     * @param  App\Models\PracticeUserManagement\PracticeUserManagement  $practiceusermanagement
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PracticeUserManagement $practiceusermanagement, DeletePracticeUserManagementRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($practiceusermanagement);
        //returning with successfull message
        return new RedirectResponse(route('admin.practiceusermanagements.index'), ['flash_success' => trans('alerts.backend.practiceusermanagements.deleted')]);
    }

    public  function savePracticeUser(Request $request){
//        if($request->has('location_id')){
            $this->repository->savePracticeUser($request);
            return redirect('admin/practiceusersmanagement')->with('message','Save Practice Successful !');
        /*}else{
            return back()->with('error','please add Selected Doctors');
        }*/
    }

    public function getDoctorByLocation($id){
        $location = PracticeLocation::find($id);
        $doctors = $location->doctors;
        $returnHTML = view("backend.practiceusers.doctors",compact('doctors','location'))->render();
        return response()->json(array('code'=>1,'message' => 'Operation Successful !', 'html'=>$returnHTML));
    }

    public  function userStatus($id){
        $this->repository->changeUserStatus($id);
        return back()->with('message','Operation Successful !');
    }
    
}
