<?php

namespace App\Repositories\Backend\OverduePatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\OverduePatientBalance\OverDuePatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OverDuePatientBalanceRepository.
 */
class OverDuePatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = OverDuePatientBalance::class;

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
                config('module.overduepatientbalances.table').'.id',
                config('module.overduepatientbalances.table').'.created_at',
                config('module.overduepatientbalances.table').'.updated_at',
            ]);
    }

}
