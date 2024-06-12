<?php

namespace App\Repositories\Backend\AgingSummary;

use DB;
use Carbon\Carbon;
use App\Models\AgingSummary\AgingSummary;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AgingSummaryRepository.
 */
class AgingSummaryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = AgingSummary::class;

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
                config('module.agingsummaries.table').'.id',
                config('module.agingsummaries.table').'.created_at',
                config('module.agingsummaries.table').'.updated_at',
            ]);
    }

}
