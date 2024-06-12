<?php

namespace App\Repositories\Backend\PatientDeductible;

use DB;
use Carbon\Carbon;
use App\Models\PatientDeductible\PatientDeductible;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientDeductibleRepository.
 */
class PatientDeductibleRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PatientDeductible::class;

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
                config('module.patientdeductibles.table').'.id',
                config('module.patientdeductibles.table').'.created_at',
                config('module.patientdeductibles.table').'.updated_at',
            ]);
    }

}
