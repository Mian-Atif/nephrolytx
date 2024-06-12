<?php

namespace App\Repositories\Backend\ActivePatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\ActivePatientBalance\ActivePatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivePatientBalanceRepository.
 */
class ActivePatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ActivePatientBalance::class;

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
                config('module.activepatientbalances.table').'.id',
                config('module.activepatientbalances.table').'.created_at',
                config('module.activepatientbalances.table').'.updated_at',
            ]);
    }

}
