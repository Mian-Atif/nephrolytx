<?php

namespace App\Http\Controllers\Backend\PhysicianThree;

use App\Models\PhysicianThree\PhysicianThree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PhysicianThree\CreateResponse;
use App\Http\Responses\Backend\PhysicianThree\EditResponse;
use App\Repositories\Backend\PhysicianThree\PhysicianThreeRepository;
use App\Http\Requests\Backend\PhysicianThree\ManagePhysicianThreeRequest;

/**
 * PhysicianThreesController
 */
class PhysicianThreesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianThreeRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PhysicianThreeRepository $repository;
     */
    public function __construct(PhysicianThreeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PhysicianThree\ManagePhysicianThreeRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePhysicianThreeRequest $request)
    {
        return new ViewResponse('backend.physicianthrees.index');
    }
    
}
