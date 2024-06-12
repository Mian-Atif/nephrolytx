<?php

namespace App\Http\Controllers\Backend\Payer;

use App\Models\Payer\Payer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Payer\CreateResponse;
use App\Http\Responses\Backend\Payer\EditResponse;
use App\Repositories\Backend\Payer\PayerRepository;
use App\Http\Requests\Backend\Payer\ManagePayerRequest;

/**
 * PayersController
 */
class PayersController extends Controller
{
    /**
     * variable to store the repository object
     * @var PayerRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PayerRepository $repository;
     */
    public function __construct(PayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Payer\ManagePayerRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePayerRequest $request)
    {
        return new ViewResponse('backend.payers.index');
    }
    
}
