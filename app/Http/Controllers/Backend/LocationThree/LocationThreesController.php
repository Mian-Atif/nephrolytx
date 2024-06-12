<?php

namespace App\Http\Controllers\Backend\LocationThree;

use App\Models\LocationThree\LocationThree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\LocationThree\CreateResponse;
use App\Http\Responses\Backend\LocationThree\EditResponse;
use App\Repositories\Backend\LocationThree\LocationThreeRepository;
use App\Http\Requests\Backend\LocationThree\ManageLocationThreeRequest;

/**
 * LocationThreesController
 */
class LocationThreesController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationThreeRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param LocationThreeRepository $repository;
     */
    public function __construct(LocationThreeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\LocationThree\ManageLocationThreeRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageLocationThreeRequest $request)
    {
        return new ViewResponse('backend.locationthrees.index');
    }
    
}
