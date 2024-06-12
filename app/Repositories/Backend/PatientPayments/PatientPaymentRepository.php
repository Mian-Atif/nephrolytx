<?php

namespace App\Repositories\Backend\PatientPayments;

use DB;
use Carbon\Carbon;
use App\Models\PatientPayments\PatientPayment;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientPaymentRepository.
 */
class PatientPaymentRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PatientPayment::class;

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
                config('module.patientpayments.table').'.id',
                config('module.patientpayments.table').'.created_at',
                config('module.patientpayments.table').'.updated_at',
            ]);
    }

}
