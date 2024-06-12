<?php

namespace App\Http\Controllers\Backend\PhysicianTwo;

use App\Models\PhysicianTwo\PhysicianTwo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PhysicianTwo\CreateResponse;
use App\Http\Responses\Backend\PhysicianTwo\EditResponse;
use App\Repositories\Backend\PhysicianTwo\PhysicianTwoRepository;
use App\Http\Requests\Backend\PhysicianTwo\ManagePhysicianTwoRequest;

/**
 * PhysicianTwosController
 */
class PhysicianTwosController extends Controller
{
    /**
     * variable to store the repository object
     * @var PhysicianTwoRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PhysicianTwoRepository $repository;
     */
    public function __construct(PhysicianTwoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PhysicianTwo\ManagePhysicianTwoRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePhysicianTwoRequest $request)
    {
        return new ViewResponse('backend.physiciantwos.index');
    }
    
}
