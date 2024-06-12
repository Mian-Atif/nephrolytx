<?php

namespace App\Http\Controllers\Backend\Physician1;

use App\Models\Physician1\PhysicianOne;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Physician1\CreateResponse;
use App\Http\Responses\Backend\Physician1\EditResponse;
use App\Repositories\Backend\Physician1\PhysicianOneRepository;
use App\Http\Requests\Backend\Physician1\ManagePhysicianOneRequest;

/**
 * PhysicianOnesController
 */
class PhysicianOnesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianOneRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PhysicianOneRepository $repository;
     */
    public function __construct(PhysicianOneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Physician1\ManagePhysicianOneRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePhysicianOneRequest $request)
    {
        return new ViewResponse('backend.physicianones.index');
    }
    
}
