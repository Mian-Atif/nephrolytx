<?php

namespace App\Http\Controllers\Backend\Patient;

use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Patient\CreateResponse;
use App\Http\Responses\Backend\Patient\EditResponse;
use App\Repositories\Backend\Patient\PatientRepository;
use App\Http\Requests\Backend\Patient\ManagePatientRequest;

/**
 * PatientsController
 */
class PatientsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PatientRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PatientRepository $repository;
     */
    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Patient\ManagePatientRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePatientRequest $request)
    {
        return new ViewResponse('backend.patients.index');
    }
    
}
