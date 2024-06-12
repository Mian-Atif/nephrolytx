<?php

namespace App\Http\Controllers\Backend\UserMaintenence;

use App\Models\UserMaintenence\UserMaintenence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\UserMaintenence\CreateResponse;
use App\Http\Responses\Backend\UserMaintenence\EditResponse;
use App\Repositories\Backend\UserMaintenence\UserMaintenenceRepository;
use App\Http\Requests\Backend\UserMaintenence\ManageUserMaintenenceRequest;

/**
 * UserMaintenencesController
 */
class UserMaintenencesController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserMaintenenceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param UserMaintenenceRepository $repository;
     */
    public function __construct(UserMaintenenceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\UserMaintenence\ManageUserMaintenenceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageUserMaintenenceRequest $request)
    {
        return new ViewResponse('backend.usermaintenences.index');
    }
    
}
