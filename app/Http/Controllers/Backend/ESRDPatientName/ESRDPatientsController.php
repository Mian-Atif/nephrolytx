<?php

namespace App\Http\Controllers\Backend\ESRDPatientName;

use App\Models\ESRDPatientName\ESRDPatient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\ESRDPatientName\CreateResponse;
use App\Http\Responses\Backend\ESRDPatientName\EditResponse;
use App\Repositories\Backend\ESRDPatientName\ESRDPatientRepository;
use App\Http\Requests\Backend\ESRDPatientName\ManageESRDPatientRequest;

/**
 * ESRDPatientsController
 */
class ESRDPatientsController extends Controller
{
    /**
     * variable to store the repository object
     * @var ESRDPatientRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ESRDPatientRepository $repository;
     */
    public function __construct(ESRDPatientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\ESRDPatientName\ManageESRDPatientRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageESRDPatientRequest $request)
    {
        return new ViewResponse('backend.esrdpatientbalances.index');
    }
    
}
