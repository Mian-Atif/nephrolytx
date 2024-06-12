<?php

namespace App\Http\Controllers\Backend\PracticeUser;

use App\Models\Practice\Practice;
use App\Models\PracticeLocations\PracticeLocation;
use App\Models\PracticeUser\Practiceuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PracticeUser\CreateResponse;
use App\Http\Responses\Backend\PracticeUser\EditResponse;
use App\Repositories\Backend\PracticeUser\PracticeuserRepository;
use App\Http\Requests\Backend\PracticeUser\ManagePracticeuserRequest;
use App\Http\Requests\Backend\PracticeUser\CreatePracticeuserRequest;
use App\Http\Requests\Backend\PracticeUser\StorePracticeuserRequest;
use App\Http\Requests\Backend\PracticeUser\EditPracticeuserRequest;
use App\Http\Requests\Backend\PracticeUser\UpdatePracticeuserRequest;
use App\Http\Requests\Backend\PracticeUser\DeletePracticeuserRequest;

/**
 * PracticeusersmanagementController
 */
class PracticeusersController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeuserRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeuserRepository $repository ;
     */
    public function __construct(PracticeuserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\PracticeUser\ManagePracticeuserRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeuserRequest $request, $id)
    {
        $practice = Practice::find($id);
        return new ViewResponse('backend.practiceusers.index', compact('practice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreatePracticeuserRequestNamespace $request
     * @return \App\Http\Responses\Backend\PracticeUser\CreateResponse
     */
    public function create(CreatePracticeuserRequest $request)
    {
        return new CreateResponse('backend.practiceusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePracticeuserRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePracticeuserRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.practiceusers.index'), ['flash_success' => trans('alerts.backend.practiceusers.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\PracticeUser\Practiceuser $practiceuser
     * @param EditPracticeuserRequestNamespace $request
     * @return \App\Http\Responses\Backend\PracticeUser\EditResponse
     */
    public function edit(Practiceuser $practiceuser, EditPracticeuserRequest $request)
    {
        return new EditResponse($practiceuser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePracticeuserRequestNamespace $request
     * @param App\Models\PracticeUser\Practiceuser $practiceuser
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePracticeuserRequest $request, Practiceuser $practiceuser)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update($practiceuser, $input);
        //return with successfull message
        return new RedirectResponse(route('admin.practiceusers.index'), ['flash_success' => trans('alerts.backend.practiceusers.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeletePracticeuserRequestNamespace $request
     * @param App\Models\PracticeUser\Practiceuser $practiceuser
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Practiceuser $practiceuser, DeletePracticeuserRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($practiceuser);
        //returning with successfull message
        return new RedirectResponse(route('admin.practiceusers.index'), ['flash_success' => trans('alerts.backend.practiceusers.deleted')]);
    }

    public function savePracticeUser(Request $request)
    {
//        if($request->has('location_id')){
        $this->repository->savePracticeUser($request);
        return redirect('admin/practiceusers/' . $request->practice_id)->with('message', 'Practice User Created Successfully !');;
        /*    }else{
                return back()->with('error','please add Selected Doctors');
            }*/
    }

    public function getDoctorByLocation($id)
    {
        $location = PracticeLocation::find($id);
        $doctors = $location->doctors;

        $returnHTML = view("backend.practiceusers.doctors", compact('doctors', 'location'))->render();
        return response()->json(array('code' => 1, 'message' => 'Operation Successful !', 'html' => $returnHTML));
    }

    public function updateStatus($id)
    {
        $this->repository->updateStatus($id);
        return back()->with('message', 'Operation Successful !');
    }


}
