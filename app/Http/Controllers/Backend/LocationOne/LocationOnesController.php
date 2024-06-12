<?php

namespace App\Http\Controllers\Backend\LocationOne;

use App\Models\LocationOne\LocationOne;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\LocationOne\CreateResponse;
use App\Http\Responses\Backend\LocationOne\EditResponse;
use App\Repositories\Backend\LocationOne\LocationOneRepository;
use App\Http\Requests\Backend\LocationOne\ManageLocationOneRequest;

/**
 * LocationOnesController
 */
class LocationOnesController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationOneRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param LocationOneRepository $repository;
     */
    public function __construct(LocationOneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\LocationOne\ManageLocationOneRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageLocationOneRequest $request)
    {
        return new ViewResponse('backend.locationones.index');
    }
    
}
