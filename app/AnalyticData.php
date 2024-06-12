<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalyticData extends Model
{

    protected $table = "analytic_data";
    protected $fillable = [
        'provider',
        'Rendering_Provider',
        'Service_Location',
        'account_nbr',
        'Patient_Name',
        'Date_of_Service',
        'Claim_BillDate',
        'icd_1',
        'icd_2',
        'icd_3',
        'icd_4',
        'icd_5',
        'icd_6',
        'icd_7',
        'icd_8',
        'pos',
        'cptCode',
        'Modifier',
        'units',
        'Billed_Amount',
        'Primary_Insurance_Name',
        'Secondary_Insurance_Name',
        'Primary_Insurance_Allowance',
        'Primary_Insurance_Payment',
        'Primary_Contractual_Adjustment',
        'Primary_PaymentDate_CheckDate',
        'Primary_CheckNo_ReferenceNo',
        'Secondary_Insurance_Payment',
        'Secondary_Contractual_Adjustment',
        'Secondary_PaymentDate',
        'Secondary_CheckNo',
        'Patient_Payment',
        'Patient_PaymentDate',
        'Insurance_Balance',
        'Patient_Balance',
        'Write_off',
        'dateofbirth',
        'practice_id'
    ]; 
}
