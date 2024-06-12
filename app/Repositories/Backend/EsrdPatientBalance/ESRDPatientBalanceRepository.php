<?php

namespace App\Repositories\Backend\EsrdPatientBalance;

use DB;
use Carbon\Carbon;
use App\Models\EsrdPatientBalance\ESRDPatientBalance;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ESRDPatientBalanceRepository.
 */
class ESRDPatientBalanceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ESRDPatientBalance::class;

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
                config('module.esrdpatientbalances.table').'.id',
                config('module.esrdpatientbalances.table').'.created_at',
                config('module.esrdpatientbalances.table').'.updated_at',
            ]);
    }

}
