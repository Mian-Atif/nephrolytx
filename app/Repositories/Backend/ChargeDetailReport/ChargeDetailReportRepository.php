<?php

namespace App\Repositories\Backend\ChargeDetailReport;

use DB;
use Carbon\Carbon;
use App\Models\ChargeDetailReport\ChargeDetailReport;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargeDetailReportRepository.
 */
class ChargeDetailReportRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ChargeDetailReport::class;

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
                config('module.chargedetailreports.table').'.id',
                config('module.chargedetailreports.table').'.created_at',
                config('module.chargedetailreports.table').'.updated_at',
            ]);
    }

}
