<?php

namespace App\Http\Controllers\Backend\PracticeLocations;

use App\Models\Practice\Practice;
use App\Models\PracticeDoctors\PracticeDoctor;
use App\Models\PracticeLocations\PracticeLocation;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PracticeLocations\CreateResponse;
use App\Http\Responses\Backend\PracticeLocations\EditResponse;
use App\Repositories\Backend\PracticeLocations\PracticeLocationRepository;
use App\Http\Requests\Backend\PracticeLocations\ManagePracticeLocationRequest;
use App\Http\Requests\Backend\PracticeLocations\CreatePracticeLocationRequest;
use App\Http\Requests\Backend\PracticeLocations\StorePracticeLocationRequest;
use App\Http\Requests\Backend\PracticeLocations\EditPracticeLocationRequest;
use App\Http\Requests\Backend\PracticeLocations\UpdatePracticeLocationRequest;
use App\Http\Requests\Backend\PracticeLocations\DeletePracticeLocationRequest;
use phpDocumentor\Reflection\Location;


/**
 * PracticeLocationsController
 */
class PracticeLocationsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PracticeLocationRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PracticeLocationRepository $repository ;
     */
    public function __construct(PracticeLocationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\PracticeLocations\ManagePracticeLocationRequest $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePracticeLocationRequest $request)
    {
        return new ViewResponse('backend.practicelocations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreatePracticeLocationRequestNamespace $request
     * @return \App\Http\Responses\Backend\PracticeLocations\CreateResponse
     */
    public function create(CreatePracticeLocationRequest $request)
    {
        return new CreateResponse('backend.practicelocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePracticeLocationRequestNamespace $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePracticeLocationRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.practicelocations.index'), ['flash_success' => trans('alerts.backend.practicelocations.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param App\Models\PracticeLocations\PracticeLocation $practicelocation
     * @param EditPracticeLocationRequestNamespace $request
     * @return \App\Http\Responses\Backend\PracticeLocations\EditResponse
     */
    public function edit(PracticeLocation $practicelocation, EditPracticeLocationRequest $request)
    {
        return new EditResponse($practicelocation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePracticeLocationRequestNamespace $request
     * @param App\Models\PracticeLocations\PracticeLocation $practicelocation
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePracticeLocationRequest $request, PracticeLocation $practicelocation)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update($practicelocation, $input);
        //return with successfull message
        return new RedirectResponse(route('admin.practicelocations.index'), ['flash_success' => trans('alerts.backend.practicelocations.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeletePracticeLocationRequestNamespace $request
     * @param App\Models\PracticeLocations\PracticeLocation $practicelocation
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PracticeLocation $practicelocation, DeletePracticeLocationRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($practicelocation);
        //returning with successfull message
        return new RedirectResponse(route('admin.practicelocations.index'), ['flash_success' => trans('alerts.backend.practicelocations.deleted')]);
    }




    public function saveLocations(Request $request)
    {
        try {
            //Calling the save locations method on repository
            $this->repository->saveLocations($request);
            /*   return response()
                   ->json(['code' => 1, 'message' => 'Operation Successful !']);*/
            return response()->json([
                'status' => true,
                'message' => 'Location Data Save Successfully!!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            //Calling the save locations method on repository
            $this->repository->updateLocation($request);
            return response()->json([
                'status' => true,
                'message' => 'Location Data Save Successfully!!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        /* return response()
             ->json(['code' => 1, 'message' => 'Operation Successful !']);*/
    }


    public function deleteLocation($id)
    {
        //Calling the delete Location method on repository
        $this->repository->deleteLocation($id);
        return back()->with('message', 'Operation Successful !');
    }

    public function editLocation($id)
    {

        $location = PracticeLocation::find($id);
        $practice=Practice::find($location->practice_id);
        $locationDetail = $location->address;
        $doctors = $location->practice->getDotorsdata;
        $states = State::get();

        $returnHTML = view("backend.practicelocations.editlocation", compact('states', 'locationDetail', 'location', 'doctors','practice'))->render();
        return response()->json(array('code' => 1, 'message' => 'Operation Successful !', 'html' => $returnHTML));

    }
    public function getLocationModal($id)
    {

        try {
            $practice=Practice::find($id);
            $states = State::get();
            $popup = view('backend.practicelocations.createLocation', compact('states','practice'))->render();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved!',
                'data' => $popup
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


}
