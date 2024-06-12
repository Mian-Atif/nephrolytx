<?php

namespace App\Repositories\Backend\TransactionAnalysis;

use DB;
use Carbon\Carbon;
use App\Models\TransactionAnalysis\TransactionAnalysi;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionAnalysiRepository.
 */
class TransactionAnalysiRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = TransactionAnalysi::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.transactionanalysis.table').'.id',
                config('module.transactionanalysis.table').'.created_at',
                config('module.transactionanalysis.table').'.updated_at',
            ]);
    }

}
