<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialities')->truncate();

        $specialities = [
            [
                'name'                  => 'Pediatrics',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Anesthesiology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Assisted Living Facility',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Dialysis Center',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Emergency medicine',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Family Medicine',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'General surgery',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Geriatrics',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Hematology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Hospital',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'House Called',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Internal medicine',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Multispecialty',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Neurology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Nursing Home',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Obstetrics and gynecology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Other (Please Specify)',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pain Management',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pathology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Psychiatry',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Radiology',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Rehabilitation Center',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Surgery Center',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Urgent Care',
                'model_type'                   => 'Practice',
                'created_at'            => Carbon::now(),
            ],

            [
                'name'                  => 'Allergy',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Allergy',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Anaesthesia',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Audiovestibular medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Behavioral Health',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Cardiology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Chemical pathology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Chiropractor',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Community sexual and reproductive health',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Dermatology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Dietition/Nutritional',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'DME',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Emergency medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Endocrinology and diabetes',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Forensic psychiatry',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],

            [
                'name'                  => 'Gastroenterology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'General surgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Genitourinary medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Geriatric medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Haematology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Histopathology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Immunology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Intensive care medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Internal medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Microbiology and virology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Nephrology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Neurosurgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Nuclear Medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Nurse Practitioner',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Obstetrics and gynaecology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Occupational medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Occupational Therapy',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Oncology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Ophthalmology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Oral and maxillofacial surgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Otorhinolaryngology (ear, nose and throat surgery)',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Paediatrics',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],

            [
                'name'                  => 'Pain Management',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Palliative medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pathology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pediatrics',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pharmaceutical medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Physcian Assistant',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Physical Therapy',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Plastic surgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Psychiatry',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Public Health',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Pulmonology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Rheumatology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Sport and exercise medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Trauma and orthopaedic surgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Tropical medicine',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Urology',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Vascular surgery',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
            [
                'name'                  => 'Other (Please Specify)',
                'model_type'                   => 'Provider',
                'created_at'            => Carbon::now(),
            ],
        ];

        DB::table('specialities')->insert($specialities);

    }
}
