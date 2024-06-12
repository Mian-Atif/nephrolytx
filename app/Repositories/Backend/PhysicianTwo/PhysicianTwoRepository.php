<?php

namespace App\Repositories\Backend\PhysicianTwo;

use DB;
use Carbon\Carbon;
use App\Models\PhysicianTwo\PhysicianTwo;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PhysicianTwoRepository.
 */
class PhysicianTwoRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PhysicianTwo::class;

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
                config('module.physiciantwos.table').'.id',
                config('module.physiciantwos.table').'.created_at',
                config('module.physiciantwos.table').'.updated_at',
            ]);
    }

}
