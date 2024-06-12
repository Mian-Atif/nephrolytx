<?php

namespace App\Repositories\Backend\LatePatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\LatePatientBalance\LatePatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LatePatientBalanceRepository.
 */
class LatePatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LatePatientBalance::class;

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
                config('module.latepatientbalances.table').'.id',
                config('module.latepatientbalances.table').'.created_at',
                config('module.latepatientbalances.table').'.updated_at',
            ]);
    }

}
