<?php

use App\Models\CptCodeRvu\CptCodeRvu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CptCodeRvuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1,
                'cptcode' => '90935',
                'description' => 'Hemodialysis Procedure W/ Phys/Qhp Evalu',
                'workRVU' => 1.48,
                'practiceRVU' => 0.48,
                'malpracticeRVU' => 0.08,
                'totalRVU' => 2.04,
            ], [
                'id' => 2,
                'cptcode' => '90937',
                'description' => 'Hemodialysis Px Repeat Eval W/Wo Revj Di',
                'workRVU' => 2.11,
                'practiceRVU' => 0.71,
                'malpracticeRVU' => 0.12,
                'totalRVU' => 2.94,
            ], [
                'id' => 3,
                'cptcode' => '90945',
                'description' => 'Dialysis Other/Than Hemodialysis 1 Phys/',
                'workRVU' => 1.56,
                'practiceRVU' => 0.77,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.42,
            ], [
                'id' => 4,
                'cptcode' => '90947',
                'description' => 'Dialysis Oth/Thn Hemodialy Repeat Phys/Q',
                'workRVU' => 2.52,
                'practiceRVU' => 0.83,
                'malpracticeRVU' => 0.15,
                'totalRVU' => 3.50,
            ], [
                'id' => 5,
                'cptcode' => '90960',
                'description' => 'Esrd Related Svc Monthly 20&/> Yr Old 4/',
                'workRVU' => 5.18,
                'practiceRVU' => 2.52,
                'malpracticeRVU' => 0.30,
                'totalRVU' => 8.00,
            ], [
                'id' => 6,
                'cptcode' => '90961',
                'description' => 'Esrd Related Svc Monthly 20/>yr Old 2/3',
                'workRVU' => 4.26,
                'practiceRVU' => 2.21,
                'malpracticeRVU' => 0.25,
                'totalRVU' => 6.72,
            ], [
                'id' => 7,
                'cptcode' => '90962',
                'description' => 'Esrd Related Svc Monthly 20&/>yr Old 1 V',
                'workRVU' => 3.15,
                'practiceRVU' => 1.85,
                'malpracticeRVU' => 0.18,
                'totalRVU' => 5.18,
            ], [
                'id' => 8,
                'cptcode' => '90963',
                'description' => 'Esrd Svc Home Dialysis Full Month',
                'workRVU' => 10.56,
                'practiceRVU' => 4.19,
                'malpracticeRVU' => 0.63,
                'totalRVU' => 15.38,
            ], [
                'id' => 9,
                'cptcode' => '90964',
                'description' => 'Esrd Svc Home Dialysis Full Month 2-11 Y',
                'workRVU' => 9.14,
                'practiceRVU' => 3.75,
                'malpracticeRVU' => 0.56,
                'totalRVU' => 13.45,
            ], [
                'id' => 10,
                'cptcode' => '90965',
                'description' => 'Esrd Svc Home Dialysis Full Month 12-19',
                'workRVU' => 8.69,
                'practiceRVU' => 3.59,
                'malpracticeRVU' => 0.52,
                'totalRVU' => 12.8,
            ], [
                'id' => 11,
                'cptcode' => '90966',
                'description' => 'Esrd Svc Home Dialysis Full Month 20 Yr',
                'workRVU' => 4.26,
                'practiceRVU' => 2.2,
                'malpracticeRVU' => 0.24,
                'totalRVU' => 6.7,
            ], [
                'id' => 12,
                'cptcode' => '97802',
                'description' => 'Medical Nutrition Assmt&ivntj Indiv Each',
                'workRVU' => 0.53,
                'practiceRVU' => 0.51,
                'malpracticeRVU' => 0.02,
                'totalRVU' => 1.06,
            ], [
                'id' => 13,
                'cptcode' => '97803',
                'description' => 'Medical Nutrition Re-Assmt&ivntj Indiv E',
                'workRVU' => 0.45,
                'practiceRVU' => 0.45,
                'malpracticeRVU' => 0.02,
                'totalRVU' => 0.92,
            ], [
                'id' => 14,
                'cptcode' => '97804',
                'description' => 'Medical nutrition therapy; group (2 or more individual(s)), each 30 minutes',
                'workRVU' => 0.25,
                'practiceRVU' => 0.22,
                'malpracticeRVU' => 0.01,
                'totalRVU' => 0.48,
            ], [
                'id' => 15,
                'cptcode' => '98966',
                'description' => 'Telephone assessment and management service within the next 24 hours',
                'workRVU' => 0.25,
                'practiceRVU' => 0.1,
                'malpracticeRVU' => 0.2,
                'totalRVU' => 0.55,
            ], [
                'id' => 16,
                'cptcode' => '99201',
                'description' => 'Office Outpatient New',
                'workRVU' => 0.48,
                'practiceRVU' => 0.71,
                'malpracticeRVU' => 0.05,
                'totalRVU' => 1.24,
            ], [
                'id' => 17,
                'cptcode' => '99202',
                'description' => 'Office Outpatient New',
                'workRVU' => 0.93,
                'practiceRVU' => 1.1,
                'malpracticeRVU' => 0.08,
                'totalRVU' => 2.11,
            ], [
                'id' => 18,
                'cptcode' => '99203',
                'description' => 'Office Outpatient New',
                'workRVU' => 1.42,
                'practiceRVU' => 1.48,
                'malpracticeRVU' => 0.15,
                'totalRVU' => 3.05,
            ], [
                'id' => 19,
                'cptcode' => '99204',
                'description' => 'Office Outpatient New',
                'workRVU' => 2.43,
                'practiceRVU' => 1.98,
                'malpracticeRVU' => 0.22,
                'totalRVU' => 4.63,
            ], [
                'id' => 20,
                'cptcode' => '99205',
                'description' => 'Office Outpatient New',
                'workRVU' => 3.17,
                'practiceRVU' => 2.37,
                'malpracticeRVU' => 0.29,
                'totalRVU' => 5.83,
            ], [
                'id' => 21,
                'cptcode' => '99211',
                'description' => 'Office Outpatient Visit',
                'workRVU' => 0.18,
                'practiceRVU' => 0.38,
                'malpracticeRVU' => 0.01,
                'totalRVU' => 0.57,
            ], [
                'id' => 22,
                'cptcode' => '99212',
                'description' => 'Office Outpatient Visit',
                'workRVU' => 0.48,
                'practiceRVU' => 0.71,
                'malpracticeRVU' => 0.04,
                'totalRVU' => 1.23,
            ], [
                'id' => 23,
                'cptcode' => '99213',
                'description' => 'Office Outpatient Visit',
                'workRVU' => 0.97,
                'practiceRVU' => 1.02,
                'malpracticeRVU' => 0.07,
                'totalRVU' => 2.06,
            ], [
                'id' => 24,
                'cptcode' => '99214',
                'description' => 'Office Outpatient Visit',
                'workRVU' => 1.5,
                'practiceRVU' => 1.43,
                'malpracticeRVU' => 0.1,
                'totalRVU' => 3.03,
            ], [
                'id' => 25,
                'cptcode' => '99215',
                'description' => 'Office Outpatient Visit',
                'workRVU' => 2.11,
                'practiceRVU' => 1.82,
                'malpracticeRVU' => 0.15,
                'totalRVU' => 4.08,
            ], [
                'id' => 26,
                'cptcode' => '99217',
                'description' => 'Observation Care Discharge Management',
                'workRVU' => 1.28,
                'practiceRVU' => 0.69,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.06,
            ], [
                'id' => 27,
                'cptcode' => '99218',
                'description' => 'Initial Observation Care/Day',
                'workRVU' => 1.92,
                'practiceRVU' => 0.75,
                'malpracticeRVU' => 0.15,
                'totalRVU' => 2.82,
            ], [
                'id' => 28,
                'cptcode' => '99219',
                'description' => 'Initial Observation Care/Day',
                'workRVU' => 2.6,
                'practiceRVU' => 1.06,
                'malpracticeRVU' => 0.18,
                'totalRVU' => 3.84,
            ], [
                'id' => 29,
                'cptcode' => '99220',
                'description' => 'Initial Observation Care/Day',
                'workRVU' => 3.56,
                'practiceRVU' => 1.45,
                'malpracticeRVU' => 0.24,
                'totalRVU' => 5.25,
            ], [
                'id' => 30,
                'cptcode' => '99221',
                'description' => 'Initial Hospital Care/Day',
                'workRVU' => 1.92,
                'practiceRVU' => 0.76,
                'malpracticeRVU' => 0.19,
                'totalRVU' => 2.87,
            ], [
                'id' => 31,
                'cptcode' => '99222',
                'description' => 'Initial Hospital Care/Day',
                'workRVU' => 2.61,
                'practiceRVU' => 1.05,
                'malpracticeRVU' => 0.21,
                'totalRVU' => 3.87,
            ], [
                'id' => 32,
                'cptcode' => '99223',
                'description' => 'Initial Hospital Care/Day',
                'workRVU' => 3.86,
                'practiceRVU' => 1.58,
                'malpracticeRVU' => 0.29,
                'totalRVU' => 5.73,
            ], [
                'id' => 33,
                'cptcode' => '99224',
                'description' => 'Sbsq Observation Care/Day',
                'workRVU' => 0.76,
                'practiceRVU' => 0.31,
                'malpracticeRVU' => 0.06,
                'totalRVU' => 1.13,
            ], [
                'id' => 34,
                'cptcode' => '99225',
                'description' => 'Sbsq Observation Care/Day',
                'workRVU' => 1.39,
                'practiceRVU' => 0.58,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.06,
            ], [
                'id' => 35,
                'cptcode' => '99226',
                'description' => 'Sbsq Observation Care/Day',
                'workRVU' => 2,
                'practiceRVU' => 0.84,
                'malpracticeRVU' => 0.13,
                'totalRVU' => 2.97,
            ], [
                'id' => 36,
                'cptcode' => '99231',
                'description' => 'Sbsq Hospital Care/Day',
                'workRVU' => 0.76,
                'practiceRVU' => 0.29,
                'malpracticeRVU' => 0.06,
                'totalRVU' => 1.11,
            ], [
                'id' => 37,
                'cptcode' => '99232',
                'description' => 'Sbsq Hospital Care/Day',
                'workRVU' => 1.39,
                'practiceRVU' => 0.56,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.04,
            ], [
                'id' => 38,
                'cptcode' => '99233',
                'description' => 'Sbsq Hospital Care/Day',
                'workRVU' => 2,
                'practiceRVU' => 0.81,
                'malpracticeRVU' => 0.14,
                'totalRVU' => 2.95,
            ], [
                'id' => 39,
                'cptcode' => '99234',
                'description' => 'Observation/Inpatient Hospital Care',
                'workRVU' => 2.56,
                'practiceRVU' => 1.01,
                'malpracticeRVU' => 0.2,
                'totalRVU' => 3.77,
            ], [
                'id' => 40,
                'cptcode' => '99235',
                'description' => 'Observation/Inpatient Hospital Care',
                'workRVU' => 3.24,
                'practiceRVU' => 1.31,
                'malpracticeRVU' => 0.23,
                'totalRVU' => 4.78,
            ], [
                'id' => 41,
                'cptcode' => '99236',
                'description' => 'Observation/Inpatient Hospital Care',
                'workRVU' => 4.2,
                'practiceRVU' => 1.67,
                'malpracticeRVU' => 0.29,
                'totalRVU' => 6.16,
            ], [
                'id' => 42,
                'cptcode' => '99238',
                'description' => 'Hospital Discharge Day Management',
                'workRVU' => 1.28,
                'practiceRVU' => 0.69,
                'malpracticeRVU' => 0.08,
                'totalRVU' => 2.05,
            ], [
                'id' => 43,
                'cptcode' => '99239',
                'description' => 'Hospital Discharge Day Management >',
                'workRVU' => 1.9,
                'practiceRVU' => 1.02,
                'malpracticeRVU' => 0.12,
                'totalRVU' => 3.04,
            ], [
                'id' => 44,
                'cptcode' => '99241',
                'description' => 'Office Consultation New/Estab Patient',
                'workRVU' => 0.64,
                'practiceRVU' => 0.66,
                'malpracticeRVU' => 0.04,
                'totalRVU' => 1.34,
            ], [
                'id' => 45,
                'cptcode' => '99242',
                'description' => 'Office Consultation New/Estab Patient',
                'workRVU' => 1.34,
                'practiceRVU' => 1.1,
                'malpracticeRVU' => 0.08,
                'totalRVU' => 2.52,
            ], [
                'id' => 46,
                'cptcode' => '99243',
                'description' => 'Office Consultation New/Estab Patient',
                'workRVU' => 1.88,
                'practiceRVU' => 1.46,
                'malpracticeRVU' => 0.11,
                'totalRVU' => 3.45,
            ], [
                'id' => 47,
                'cptcode' => '99244',
                'description' => 'Office Consultation New/Estab Patient',
                'workRVU' => 3.02,
                'practiceRVU' => 1.96,
                'malpracticeRVU' => 0.18,
                'totalRVU' => 5.16,
            ], [
                'id' => 48,
                'cptcode' => '99245',
                'description' => 'Office Consultation New/Estab Patient',
                'workRVU' => 3.77,
                'practiceRVU' => 2.3,
                'malpracticeRVU' => 0.22,
                'totalRVU' => 6.29,
            ], [
                'id' => 49,
                'cptcode' => '99251',
                'description' => 'Initial Inpatient Consult New/Estab Pt 2',
                'workRVU' => 1,
                'practiceRVU' => 0.32,
                'malpracticeRVU' => 0.06,
                'totalRVU' => 1.38,
            ], [
                'id' => 50,
                'cptcode' => '99252',
                'description' => 'Initial Inpatient Consult New/Estab Pt 4',
                'workRVU' => 1.5,
                'practiceRVU' => 0.52,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.11,
            ], [
                'id' => 51,
                'cptcode' => '99253',
                'description' => 'Initial Inpatient Consult New/Estab Pt 5',
                'workRVU' => 2.27,
                'practiceRVU' => 0.84,
                'malpracticeRVU' => 0.13,
                'totalRVU' => 3.24,
            ], [
                'id' => 52,
                'cptcode' => '99254',
                'description' => 'Initial Inpatient Consult New/Estab Pt 8',
                'workRVU' => 3.29,
                'practiceRVU' => 1.23,
                'malpracticeRVU' => 0.19,
                'totalRVU' => 4.71,
            ], [
                'id' => 53,
                'cptcode' => '99255',
                'description' => 'Initial Inpatient Consult New/Estab Pt 1',
                'workRVU' => 4,
                'practiceRVU' => 1.44,
                'malpracticeRVU' => 0.24,
                'totalRVU' => 5.68,
            ], [
                'id' => 54,
                'cptcode' => '99291',
                'description' => 'Critical care, evaluation and management of the critically ill or critically injured patient; first 30-74 minutes',
                'workRVU' => 4.5,
                'practiceRVU' => 2.99,
                'malpracticeRVU' => 0.4,
                'totalRVU' => 7.89,
            ], [
                'id' => 55,
                'cptcode' => '99335',
                'description' => 'Domiciliary or rest home visit for the evaluation and management of an established patient, which requires at least 2 of these 3 key components',
                'workRVU' => 1.72,
                'practiceRVU' => 0.88,
                'malpracticeRVU' => 0.09,
                'totalRVU' => 2.69,
            ], [
                'id' => 56,
                'cptcode' => '99490',
                'description' => 'Chronic care management services, at least 20 minutes of clinical staff time directed by a physician',
                'workRVU' => 0.61,
                'practiceRVU' => 0.51,
                'malpracticeRVU' => 0.05,
                'totalRVU' => 1.17,
            ], [
                'id' => 57,
                'cptcode' => 'G0506',
                'description' => 'Comprehensive assessment of and care planning for patients requiring chronic care management services (list separately in addition to primary monthly care management service)',
                'workRVU' => 0.87,
                'practiceRVU' => 0.83,
                'malpracticeRVU' => 0.06,
                'totalRVU' => 1.76,
            ]

        ];
        DB::table(config('access.cptcodeandrvu_table'))->insert($data);
        //
    }
}
