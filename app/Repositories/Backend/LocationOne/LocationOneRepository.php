<?php

namespace App\Repositories\Backend\LocationOne;

use DB;
use Carbon\Carbon;
use App\Models\LocationOne\LocationOne;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationOneRepository.
 */
class LocationOneRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LocationOne::class;

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
                config('module.locationones.table').'.id',
                config('module.locationones.table').'.created_at',
                config('module.locationones.table').'.updated_at',
            ]);
    }

}
