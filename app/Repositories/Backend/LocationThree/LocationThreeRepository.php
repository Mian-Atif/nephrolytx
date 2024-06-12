<?php

namespace App\Repositories\Backend\LocationThree;

use DB;
use Carbon\Carbon;
use App\Models\LocationThree\LocationThree;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationThreeRepository.
 */
class LocationThreeRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LocationThree::class;

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
                config('module.locationthrees.table').'.id',
                config('module.locationthrees.table').'.created_at',
                config('module.locationthrees.table').'.updated_at',
            ]);
    }

}
