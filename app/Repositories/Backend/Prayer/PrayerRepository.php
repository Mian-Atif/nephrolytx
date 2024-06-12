<?php

namespace App\Repositories\Backend\Prayer;

use DB;
use Carbon\Carbon;
use App\Models\Prayer\Prayer;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PrayerRepository.
 */
class PrayerRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Prayer::class;

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
                config('module.prayers.table').'.id',
                config('module.prayers.table').'.created_at',
                config('module.prayers.table').'.updated_at',
            ]);
    }

}
