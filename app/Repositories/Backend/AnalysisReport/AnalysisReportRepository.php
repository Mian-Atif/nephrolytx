<?php

namespace App\Repositories\Backend\AnalysisReport;

use DB;
use Carbon\Carbon;
use App\Models\AnalysisReport\AnalysisReport;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AnalysisReportRepository.
 */
class AnalysisReportRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = AnalysisReport::class;

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
                config('module.analysisreports.table').'.id',
                config('module.analysisreports.table').'.created_at',
                config('module.analysisreports.table').'.updated_at',
            ]);
    }

}
