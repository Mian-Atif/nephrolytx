<?php

namespace App\Imports;

use App\Models\CptCode\CptCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CptCodePrice implements ToModel, WithHeadingRow
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new
        CptCode([
            'cpt_code' => !is_null($row['cpt_code'])? $row['cpt_code'] : null,
            'par_amount' =>  !is_null($row['par_amount'])? $row['par_amount'] : null,
            'state' => !is_null($row['state'])?$row['state']:null,
           'practice_id' => $this->data,
        ]);
    }

}
