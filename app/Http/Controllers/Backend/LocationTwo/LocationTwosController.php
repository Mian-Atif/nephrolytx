<?php

namespace App\Http\Controllers\Backend\LocationTwo;

use App\Models\LocationTwo\LocationTwo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\LocationTwo\CreateResponse;
use App\Http\Responses\Backend\LocationTwo\EditResponse;
use App\Repositories\Backend\LocationTwo\LocationTwoRepository;
use App\Http\Requests\Backend\LocationTwo\ManageLocationTwoRequest;

/**
 * LocationTwosController
 */
class LocationTwosController extends Controller
{
    /**
     * variable to store the repository object
     * @var LocationTwoRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param LocationTwoRepository $repository;
     */
    public function __construct(LocationTwoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\LocationTwo\ManageLocationTwoRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageLocationTwoRequest $request)
    {
        return new ViewResponse('backend.locationtwos.index');
    }
    
}
