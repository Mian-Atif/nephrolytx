<?php

namespace App\Repositories\Backend\LocationTwo;

use DB;
use Carbon\Carbon;
use App\Models\LocationTwo\LocationTwo;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationTwoRepository.
 */
class LocationTwoRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LocationTwo::class;

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
                config('module.locationtwos.table').'.id',
                config('module.locationtwos.table').'.created_at',
                config('module.locationtwos.table').'.updated_at',
            ]);
    }

}
