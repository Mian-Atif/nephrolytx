<?php

namespace App\Http\Controllers\Backend\Prayer;

use App\Models\Prayer\Prayer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Prayer\CreateResponse;
use App\Http\Responses\Backend\Prayer\EditResponse;
use App\Repositories\Backend\Prayer\PrayerRepository;
use App\Http\Requests\Backend\Prayer\ManagePrayerRequest;

/**
 * PrayersController
 */
class PrayersController extends Controller
{
    /**
     * variable to store the repository object
     * @var PrayerRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PrayerRepository $repository;
     */
    public function __construct(PrayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Prayer\ManagePrayerRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePrayerRequest $request)
    {
        return new ViewResponse('backend.prayers.index');
    }
    
}
