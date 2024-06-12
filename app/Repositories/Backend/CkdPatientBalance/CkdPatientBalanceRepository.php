<?php

namespace App\Repositories\Backend\CkdPatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\CkdPatientBalance\CkdPatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CkdPatientBalanceRepository.
 */
class CkdPatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = CkdPatientBalance::class;

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
                config('module.ckdpatientbalances.table').'.id',
                config('module.ckdpatientbalances.table').'.created_at',
                config('module.ckdpatientbalances.table').'.updated_at',
            ]);
    }

}
