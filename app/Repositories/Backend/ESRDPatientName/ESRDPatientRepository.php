<?php

namespace App\Repositories\Backend\ESRDPatientName;

use DB;
use Carbon\Carbon;
use App\Models\ESRDPatientName\ESRDPatient;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ESRDPatientRepository.
 */
class ESRDPatientRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ESRDPatient::class;

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
                config('module.esrdpatients.table').'.id',
                config('module.esrdpatients.table').'.created_at',
                config('module.esrdpatients.table').'.updated_at',
            ]);
    }

}
