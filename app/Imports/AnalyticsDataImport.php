<?php

namespace App\Imports;

use App\AnalyticData;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnalyticsDataImport implements ToModel, WithHeadingRow
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new
        AnalyticData([
            'provider' => $row['billing_provider'],
            'Rendering_Provider' =>  !is_null($row['rendering_provider'])? $row['rendering_provider'] : null,
            'Service_Location' => !is_null($row['service_location'])?$row['service_location']:null,
            'account_nbr' => !is_null($row['ac'])?$row['ac']:null,
            'Patient_Name' => !is_null($row['patient_name'])?$row['patient_name']:null,
            'Date_of_Service' => (!empty($row['date_of_service'])) && (false !== strtotime($row['date_of_service']))? Carbon::createFromFormat('m/d/Y', $row['date_of_service'])->format('Y-m-d') : Carbon::now()->format('m/d/Y'),
            'Claim_BillDate' => (!empty($row['claim_bill_date']))  && (false !== strtotime($row['claim_bill_date']))? Carbon::createFromFormat('m/d/Y', $row['claim_bill_date'])->format('Y-m-d') : Carbon::now()->format('m/d/Y'),//$row[6],// \Carbon\Carbon::parse($row[6])->format('Y/m/d') ,
            'icd_1' => $row['icd_1'],
            'icd_2' => $row['icd_2'],
            'icd_3' => $row['icd_3'],
            'icd_4' => $row['icd_4'],
            'icd_5' => $row['icd_5'],
            'icd_6' => $row['icd_6'],
            'icd_7' => $row['icd_7'],
            'icd_8' => $row['icd_8'],
            'pos' => $row['pos'],
            'cptCode' => $row['cpt_code'],
            'Modifier' => $row['modifier'],
            'units' => $row['units'],
            'Billed_Amount' => $row['billed_amount'],
            'Primary_Insurance_Name' => $row['primary_insurance_name'],
            'Secondary_Insurance_Name' => $row['secondary_insurance_name'],
            'Primary_Insurance_Allowance' => $row['primary_insurance_allowance'],
            'Primary_Insurance_Payment' => $row['primary_insurance_payment'],
            'Primary_Contractual_Adjustment' => $row['contractual_adjustment'],
            'Primary_PaymentDate_CheckDate' => (!empty($row['payment_datecheck_date'])) && (false !== strtotime($row['payment_datecheck_date']))? Carbon::createFromFormat('m/d/Y', $row['payment_datecheck_date'])->format('Y-m-d') : Carbon::now()->format('m/d/Y'),
            'Primary_CheckNo_ReferenceNo' => $row['check_noreference_no'],
            'Secondary_Insurance_Payment' => $row['secondary_payment'],
            'Secondary_Contractual_Adjustment' => $row['secondary_contractual_adjustment'],
            'Secondary_PaymentDate' => (!empty($row['payment_date'])) && (false !== strtotime($row['payment_date'])) ? Carbon::createFromFormat('m/d/Y', $row['payment_date'])->format('Y-m-d') : Carbon::now()->format('m/d/Y'),
            'Secondary_CheckNo' => $row['check_no'],
            'Patient_Payment' => $row['patient_payment'],
            'Patient_PaymentDate' => (!empty($row['Patient_PaymentDate'])) && (false !== strtotime($row['Patient_PaymentDate']))? Carbon::createFromFormat('m/d/Y', $row['Patient_PaymentDate'])->format('Y-m-d') : null,
            'Insurance_Balance' => $row['insurance_balance'],
            'Patient_Balance' => $row['patient_balance'],
            'Write_off' => $row['write_off'],
            'dateofbirth' => (!empty($row['date_of_birth'])) && (false !== strtotime($row['date_of_birth'])) ? Carbon::createFromFormat('m/d/Y', $row['date_of_birth'])->format('Y-m-d') : Carbon::now()->format('m/d/Y'),
            'practice_id' => $this->data,//\Illuminate\Support\Facades\Auth::user()->id,

        ]);
    }
}
