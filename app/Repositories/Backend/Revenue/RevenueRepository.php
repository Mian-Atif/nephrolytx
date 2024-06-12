<?php

namespace App\Repositories\Backend\Revenue;

use DB;
use Carbon\Carbon;
use App\Models\Revenue\Revenue;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RevenueRepository.
 */
class RevenueRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Revenue::class;

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
                config('module.revenues.table').'.id',
                config('module.revenues.table').'.created_at',
                config('module.revenues.table').'.updated_at',
            ]);
    }

}
