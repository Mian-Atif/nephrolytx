<?php

namespace App\Http\Controllers\Backend\PracticeDoctors;

use App\Models\Practice\Practice;
use App\Models\PracticeDoctors\PracticeDoctor;
use App\Models\Person\Person;
use App\Models\PracticeLocations\PracticeLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PracticeDoctors\CreateResponse;
use App\Http\Responses\Backend\PracticeDoctors\EditResponse;
use App\Repositories\Backend\PracticeDoctors\PracticeDoctorRepository;
use App\Http\Requests\Backend\PracticeDoctors\ManagePracticeDoctorRequest;
use App\Http\Requests\Backend\PracticeDoctors\CreatePracticeDoctorRequest;
use App\Http\Requests\Backend\PracticeDoctors\StorePracticeDoctorRequest;
use App\Http\Requests\Backend\PracticeDoctors\EditPracticeDoctorRequest;
use App\Http\Requests\Backend\PracticeDoctors\UpdatePracticeDoctorRequest;
use App\Http\Requests\Backend\PracticeDoctors\DeletePracticeDoctorRequest;

/**
 * PracticeDoctorsController
 */
class PracticeDoctorsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeDoctorRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeDoctorRepository $repository;
     */
    public function __construct(PracticeDoctorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PracticeDoctors\ManagePracticeDoctorRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeDoctorRequest $request)
    {
        return new ViewResponse('backend.practicedoctors.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePracticeDoctorRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PracticeDoctors\CreateResponse
     */
    public function create(CreatePracticeDoctorRequest $request)
    {
        return new CreateResponse('backend.practicedoctors.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePracticeDoctorRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePracticeDoctorRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.practicedoctors.index'), ['flash_success' => trans('alerts.backend.practicedoctors.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\PracticeDoctors\PracticeDoctor  $practicedoctor
     * @param  EditPracticeDoctorRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PracticeDoctors\EditResponse
     */
    public function edit(PracticeDoctor $practicedoctor, EditPracticeDoctorRequest $request)
    {
        return new EditResponse($practicedoctor);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePracticeDoctorRequestNamespace  $request
     * @param  App\Models\PracticeDoctors\PracticeDoctor  $practicedoctor
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePracticeDoctorRequest $request, PracticeDoctor $practicedoctor)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $practicedoctor, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.practicedoctors.index'), ['flash_success' => trans('alerts.backend.practicedoctors.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePracticeDoctorRequestNamespace  $request
     * @param  App\Models\PracticeDoctors\PracticeDoctor  $practicedoctor
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PracticeDoctor $practicedoctor, DeletePracticeDoctorRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($practicedoctor);
        //returning with successfull message
        return new RedirectResponse(route('admin.practicedoctors.index'), ['flash_success' => trans('alerts.backend.practicedoctors.deleted')]);
    }


    public function saveDoctors(Request $request)
    {
        try {

            //Calling the save doctor method on repository
            $this->repository->saveDoctors($request);

//            return back()->with('message', 'Operation Successful !');
            return response()->json([
                'status' => true,
                'message' => 'Providers Data Save Successfully!!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }

    public function  updateDoctors(Request $request){
try{

   $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'npi' => 'required',
        'taxonomy_code' => 'required',
    ]);
        //Calling the save doctor method on repository
        $this->repository->updateDoctors($request);

        return response()->json([
            'status' => true,
            'message' => 'Providers Data Updated Successfully!!'
        ]);
//        return back()->with('message','Operation Successful !');
    }
catch (\Exception $e) {
    return response()->json([
        'status' => false,
        'message' => $e->errors()
    ]);
}
}



    public function deleteDoctor($id){
        //Calling the delete Doctor on repository
        $this->repository->deleteDoctor($id);
        return back()->with('message','Operation Successful !');
    }

    public function editDoctor($id){

        $doctor  = PracticeDoctor::find($id);
        $doctors  = $doctor->person;
        $locations = $doctor->locations()->pluck('id');
        $practicelocations = Practice::find($doctor->practice->id)->getLocationdata;
        $providers = Practice::find($doctor->practice->id)->getDotorsdata;

        $returnHTML = view("backend.practicedoctors.editdoctor",compact('providers','doctors','locations','practicelocations','doctor'))->render();
        return response()->json(array('code'=>1,'message' => 'Operation Successful !', 'html'=>$returnHTML));

    }
    public function getProviderModal($id)
    {
        try {
            $practice=Practice::find($id);
            $providersLocation = $practice->getDotorsdata;

            $popup = view('backend.practicedoctors.createdoctor', compact('providersLocation','practice'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
