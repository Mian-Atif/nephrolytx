<?php

namespace App\Repositories\Backend\ChequeReconciliationDetail;

use DB;
use Carbon\Carbon;
use App\Models\ChequeReconciliationDetail\ChequeReconciliationDetail;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChequeReconciliationDetailRepository.
 */
class ChequeReconciliationDetailRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ChequeReconciliationDetail::class;

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
                config('module.chequereconciliationdetails.table').'.id',
                config('module.chequereconciliationdetails.table').'.created_at',
                config('module.chequereconciliationdetails.table').'.updated_at',
            ]);
    }

}
