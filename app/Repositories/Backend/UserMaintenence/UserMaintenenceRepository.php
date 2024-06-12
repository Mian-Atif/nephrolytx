<?php

namespace App\Repositories\Backend\UserMaintenence;

use DB;
use Carbon\Carbon;
use App\Models\UserMaintenence\UserMaintenence;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMaintenenceRepository.
 */
class UserMaintenenceRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = UserMaintenence::class;

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
                config('module.usermaintenences.table').'.id',
                config('module.usermaintenences.table').'.created_at',
                config('module.usermaintenences.table').'.updated_at',
            ]);
    }

}
