<?php

namespace App\Repositories\Backend\ChargeAndCollectionSummary;

use DB;
use Carbon\Carbon;
use App\Models\ChargeAndCollectionSummary\ChargeAndCollectionSummary;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargeAndCollectionSummaryRepository.
 */
class ChargeAndCollectionSummaryRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ChargeAndCollectionSummary::class;

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
                config('module.chargeandcollectionsummaries.table').'.id',
                config('module.chargeandcollectionsummaries.table').'.created_at',
                config('module.chargeandcollectionsummaries.table').'.updated_at',
            ]);
    }

}
