<?php

namespace App\Repositories\Backend\PerformanceReport;

use DB;
use Carbon\Carbon;
use App\Models\PerformanceReport\PerformanceReport;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PerformanceReportRepository.
 */
class PerformanceReportRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PerformanceReport::class;

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
                config('module.performancereports.table').'.id',
                config('module.performancereports.table').'.created_at',
                config('module.performancereports.table').'.updated_at',
            ]);
    }

}
