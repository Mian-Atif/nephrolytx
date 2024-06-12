<?php

namespace App\Repositories\Backend\NewCKDPatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\NewCKDPatientBalance\NewCKDPatientbalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewCKDPatientbalanceRepository.
 */
class NewCKDPatientbalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = NewCKDPatientbalance::class;

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
                config('module.newckdpatientbalances.table').'.id',
                config('module.newckdpatientbalances.table').'.created_at',
                config('module.newckdpatientbalances.table').'.updated_at',
            ]);
    }

}
