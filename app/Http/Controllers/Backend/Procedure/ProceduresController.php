<?php

namespace App\Http\Controllers\Backend\Procedure;

use App\Models\Procedure\Procedure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Procedure\CreateResponse;
use App\Http\Responses\Backend\Procedure\EditResponse;
use App\Repositories\Backend\Procedure\ProcedureRepository;
use App\Http\Requests\Backend\Procedure\ManageProcedureRequest;

/**
 * ProceduresController
 */
class ProceduresController extends Controller
{
    /**
     * variable to store the repository object
     * @var ProcedureRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ProcedureRepository $repository;
     */
    public function __construct(ProcedureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Procedure\ManageProcedureRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageProcedureRequest $request)
    {
        return new ViewResponse('backend.procedures.index');
    }
    
}
