<?php

namespace App\Http\Controllers\Backend\Practice;

use App\Http\Responses\Backend\Practice\ShowResponse;
use App\Models\Practice\Practice;
use App\Models\PracticeProviderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Practice\CreateResponse;
use App\Http\Responses\Backend\Practice\EditResponse;
use App\Repositories\Backend\Practice\PracticeRepository;
use App\Http\Requests\Backend\Practice\ManagePracticeRequest;
use App\Http\Requests\Backend\Practice\CreatePracticeRequest;
use App\Http\Requests\Backend\Practice\StorePracticeRequest;
use App\Http\Requests\Backend\Practice\EditPracticeRequest;
use App\Http\Requests\Backend\Practice\UpdatePracticeRequest;
use App\Http\Requests\Backend\Practice\DeletePracticeRequest;
use Illuminate\Support\Facades\Auth;

/**
 * PracticesController
 */
class PracticesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeRepository $repository;
     */
    public function __construct(PracticeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Practice\ManagePracticeRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeRequest $request)
    {
        return new ViewResponse('backend.practices.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePracticeRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Practice\CreateResponse
     */
    public function create(CreatePracticeRequest $request)
    {

        return new CreateResponse('backend.practices.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePracticeRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */

    public function store(StorePracticeRequest $request)
    {
        $data=$request->all();
        //Create the model using repository create method
        $this->repository->createPractices($request);
        //return with successfull message
        return new RedirectResponse(route('admin.practices.index'), ['flash_success' =>'Practice Have Been Created Successfully !']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Practice\Practice  $practice
     * @param  EditPracticeRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Practice\EditResponse
     */

    public function edit(Practice $practice, EditPracticeRequest $request)
    {
        return new EditResponse($practice);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePracticeRequestNamespace  $request
     * @param  App\Models\Practice\Practice  $practice
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePracticeRequest $request, Practice $practice)
    {

        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $practice, $input );
        //return with successfull message
//        return new RedirectResponse(route('admin.practices.index'), ['flash_success' => trans('alerts.backend.practices.updated')]);
        return redirect()->back()->withFlashSuccess('Practice Have Been Edited Successfully !');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePracticeRequestNamespace  $request
     * @param  App\Models\Practice\Practice  $practice
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Practice $practice, DeletePracticeRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($practice);
        //returning with successfull message
        return new RedirectResponse(route('admin.practices.index'), ['flash_success' => trans('alerts.backend.practices.deleted')]);
    }
    /**
     * @param \App\Models\Access\User\User                           $user
     * @param \App\Http\Requests\Backend\Access\User\ShowUserRequest $request
     *
     * @return \App\Http\Responses\Backend\Access\User\ShowResponse
     */
    public function show(Practice $practice)
    {
        return new ShowResponse($practice);
    }

    public function saveBillingManager(Request $request)
    {
        try {
            $this->repository->saveBillingManager($request);
//        return back()->with('message','Billing Manager  Save Successfully !');

            return response()->json([
                'status' => true,
                'message' => 'Billing Manager Save Successfully!!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }


    public function userManagement($id){
        $practice = Practice::find($id);
        $practiceUsers =  $this->repository->users($id);
        return  view('backend.practices.user_management',compact('practiceUsers','practice'));
    }

    public  function deleteBillingUser($id){
        $this->repository->deleteBillingUser($id);
        return response()
            ->json(['code' => 1, 'message' => 'Billing Manager Deleted Successfully !']);
    }
    public  function deleteDoctorUser($id){
        $this->repository->deleteDoctorUser($id);
        return response()
            ->json(['code' => 1, 'message' => 'Doctor Deleted Successfully !']);
    }




}

