<?php

namespace App\Repositories\Backend\Procedure;

use DB;
use Carbon\Carbon;
use App\Models\Procedure\Procedure;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProcedureRepository.
 */
class ProcedureRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Procedure::class;

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
                config('module.procedures.table').'.id',
                config('module.procedures.table').'.created_at',
                config('module.procedures.table').'.updated_at',
            ]);
    }

}
