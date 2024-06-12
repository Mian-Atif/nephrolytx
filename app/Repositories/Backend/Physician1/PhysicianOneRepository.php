<?php

namespace App\Repositories\Backend\Physician1;

use DB;
use Carbon\Carbon;
use App\Models\Physician1\PhysicianOne;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhysicianOneRepository.
 */
class PhysicianOneRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PhysicianOne::class;

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
                config('module.physicianones.table').'.id',
                config('module.physicianones.table').'.created_at',
                config('module.physicianones.table').'.updated_at',
            ]);
    }

}
