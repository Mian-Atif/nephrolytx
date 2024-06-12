<?php

namespace App\Repositories\Backend\PhysicianThree;

use DB;
use Carbon\Carbon;
use App\Models\PhysicianThree\PhysicianThree;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhysicianThreeRepository.
 */
class PhysicianThreeRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PhysicianThree::class;

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
                config('module.physicianthrees.table').'.id',
                config('module.physicianthrees.table').'.created_at',
                config('module.physicianthrees.table').'.updated_at',
            ]);
    }

}
