<?php

namespace App\Http\Controllers\Backend\TransactionAnalysis;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\TransactionAnalysis\TransactionAnalysiRepository;
use App\Http\Requests\Backend\TransactionAnalysis\ManageTransactionAnalysiRequest;

/**
 * Class TransactionAnalysisTableController.
 */
class TransactionAnalysisTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var TransactionAnalysiRepository
     */
    protected $transactionanalysi;

    /**
     * contructor to initialize repository object
     * @param TransactionAnalysiRepository $transactionanalysi;
     */
    public function __construct(TransactionAnalysiRepository $transactionanalysi)
    {
        $this->transactionanalysi = $transactionanalysi;
    }

    /**
     * This method return the data of the model
     * @param ManageTransactionAnalysiRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageTransactionAnalysiRequest $request)
    {
        return Datatables::of($this->transactionanalysi->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($transactionanalysi) {
                return Carbon::parse($transactionanalysi->created_at)->toDateString();
            })
            ->addColumn('actions', function ($transactionanalysi) {
                return $transactionanalysi->action_buttons;
            })
            ->make(true);
    }
}
