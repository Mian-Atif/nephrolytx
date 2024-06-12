<?php

namespace App\Repositories\Backend\Payer;

use DB;
use Carbon\Carbon;
use App\Models\Payer\Payer;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PayerRepository.
 */
class PayerRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Payer::class;

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
                config('module.payers.table').'.id',
                config('module.payers.table').'.created_at',
                config('module.payers.table').'.updated_at',
            ]);
    }

}
