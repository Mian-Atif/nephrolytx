<?php

namespace App\Repositories\Backend\UploadReportsData;

use DB;
use Carbon\Carbon;
use App\Models\UploadReportsData\UploadReportsDatum;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UploadReportsDatumRepository.
 */
class UploadReportsDatumRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = UploadReportsDatum::class;

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
                config('module.uploadreportsdata.table').'.id',
                config('module.uploadreportsdata.table').'.created_at',
                config('module.uploadreportsdata.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (UploadReportsDatum::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.uploadreportsdata.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param UploadReportsDatum $uploadreportsdatum
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(UploadReportsDatum $uploadreportsdatum, array $input)
    {
    	if ($uploadreportsdatum->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.uploadreportsdata.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param UploadReportsDatum $uploadreportsdatum
     * @throws GeneralException
     * @return bool
     */
    public function delete(UploadReportsDatum $uploadreportsdatum)
    {
        if ($uploadreportsdatum->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.uploadreportsdata.delete_error'));
    }
}
