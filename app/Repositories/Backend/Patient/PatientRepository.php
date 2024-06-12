<?php

namespace App\Repositories\Backend\Patient;

use DB;
use Carbon\Carbon;
use App\Models\Patient\Patient;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientRepository.
 */
class PatientRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Patient::class;

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
                config('module.patients.table').'.id',
                config('module.patients.table').'.created_at',
                config('module.patients.table').'.updated_at',
            ]);
    }

}
