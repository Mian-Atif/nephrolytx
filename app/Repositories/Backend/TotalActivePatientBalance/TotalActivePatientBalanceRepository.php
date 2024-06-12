<?php

namespace App\Repositories\Backend\TotalActivePatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\TotalActivePatientBalance\TotalActivePatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalActivePatientBalanceRepository.
 */
class TotalActivePatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = TotalActivePatientBalance::class;

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
                config('module.totalactivepatientbalances.table').'.id',
                config('module.totalactivepatientbalances.table').'.created_at',
                config('module.totalactivepatientbalances.table').'.updated_at',
            ]);
    }

}
