<?php

namespace App\Http\Controllers\Backend\UploadReportsData;

use App\AnalyticData;
use App\Imports\AnalyticsDataImport;
use App\Models\UploadReportsData\UploadReportsDatum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\UploadReportsData\CreateResponse;
use App\Http\Responses\Backend\UploadReportsData\EditResponse;
use App\Repositories\Backend\UploadReportsData\UploadReportsDatumRepository;
use App\Http\Requests\Backend\UploadReportsData\ManageUploadReportsDatumRequest;
use App\Http\Requests\Backend\UploadReportsData\CreateUploadReportsDatumRequest;
use App\Http\Requests\Backend\UploadReportsData\StoreUploadReportsDatumRequest;
use App\Http\Requests\Backend\UploadReportsData\EditUploadReportsDatumRequest;
use App\Http\Requests\Backend\UploadReportsData\UpdateUploadReportsDatumRequest;
use App\Http\Requests\Backend\UploadReportsData\DeleteUploadReportsDatumRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function GuzzleHttp\Promise\all;
use Response;

/**
 * UploadReportsDataController
 */
class UploadReportsDataController extends Controller
{
    /**
     * variable to store the repository object
     * @var UploadReportsDatumRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param UploadReportsDatumRepository $repository;
     */
    public function __construct(UploadReportsDatumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManageUploadReportsDatumRequest $request
     * @return ViewResponse
     */
    public function index(ManageUploadReportsDatumRequest $request)
    {
        return new ViewResponse('backend.uploadreportsdata.index');
    }

    /**
     * @param Request $request
     * @return CreateResponse
     */
    public function create(Request $request)
    {
        
        //Load CSV Here
        //self::loadCSVonLoad();
        //
        
        return new CreateResponse('backend.uploadreportsdata.create');
    }
    
    public function loadSingle(Request $request){
        
            $chunkSize = 250;
            $skip = (int) $request->input('skip');
        
            ini_set('MAX_EXECUTION_TIME', 36000);
            $practice_id = $request->input('practice_id');
            if($skip === 0 || $skip == 0){
                AnalyticData::where('practice_id', $practice_id)->delete();
                $firstline = true;
            }else{
                $firstline = false;
            }
            $file_path = storage_path('final_qa_test.csv');
                        
                        
            $csv = array_map('str_getcsv', file($file_path));
            $rows = array_slice($csv, $skip, $chunkSize);
            $records = collect($rows);
            $datas = [];
            if($records){
            // Process the chunk of records
            foreach($records as $row) {
                if (!$firstline) {
                
                    $data = [ 
                            'provider' => $row[0],
                            'Rendering_Provider' => $row[1],
                            'Service_Location' => $row[2],
                            'account_nbr' => $row[3],
                            'Patient_Name' => $row[4],
                            'dateofbirth' => self::changeDateFormat($row[5]),
                            'Date_of_Service' => self::changeDateFormat($row[6]),
                            'Claim_BillDate' => self::changeDateFormat($row[7]),
                            'icd_1' => $row[8],
                            'icd_2' => $row[9],
                            'icd_3' => $row[10],
                            'icd_4' => $row[11],
                            'icd_5' => $row[12],
                            'icd_6' => $row[13],
                            'icd_7' => $row[14],
                            'icd_8' => $row[15],
                            'pos' => $row[16],
                            'cptcode' => $row[17],
                            'MODIFIER' => $row[18],
                            'units' => $row[19],
                            'Billed_Amount' => $row[20],
                            'Primary_Insurance_Name' => $row[21],
                            'Secondary_Insurance_Name' => $row[22],
                            'Primary_Insurance_Allowance' => $row[23],
                            'Primary_Insurance_Payment' => $row[24],
                            'Primary_Contractual_Adjustment' => $row[25],
                            'Primary_PaymentDate_CheckDate' => self::changeDateFormat($row[26]),
                            'Primary_CheckNo_ReferenceNo' => $row[27],
                            'Secondary_Insurance_Payment' => $row[28],
                            'Secondary_Contractual_Adjustment' => $row[29],
                            'Secondary_PaymentDate' => self::changeDateFormat($row[30]),
                            'Secondary_CheckNo' => $row[31],
                            'Patient_Payment' => $row[32],
                            'Patient_PaymentDate' => self::changeDateFormat($row[33]),
                            'Insurance_Balance' => $row[34],
                            'Patient_Balance' => $row[35],
                            'Write_off' => $row[36],
                            'address' => $row[37],
                            'city' => $row[38],
                            'state' => $row[39],
                            'ZIPCode' => $row[40],
                            'phone' => $row[41],
                            'cptcode_description' => $row[42],
                            'work_RVU' => $row[43],
                            'practice_RVU' => $row[44],
                            'malpractice_RVU' => $row[45],
                            'total_RVU' => $row[46],
                            'practice_id' => $practice_id
                        ];
                        
                        
                    //$inserted = DB::table('analytic_data')->insert($data);
                        
                    $datas[] = $data;
                
                }
                $firstline = false;
            }
            }
            // $cca = 0; 
            // do {
            //     echo $cca.'<br>';
            //     $cca++;
            // } while (count($rows) > 0);
            

                
                if(!empty($datas)){
                    $inserted = DB::table('analytic_data')->insert($datas);
                }
                
            if ($inserted) {
            } else {
                dd("Insert operation failed");
            }

            $skip += $chunkSize;
            $resp = array(
                    'total' => count($csv),
                    'skip' => $skip
                );
            return Response::json($resp);
        
        // $practice_id = 1;
        //  DB::select("CALL update_practice_payers($practice_id)");

        //         //procedure call for align data record
        //         DB::select("CALL update_cptcode_prices($practice_id)");

        //         DB::select("CALL update_practice_locations($practice_id)");

        //         DB::select("CALL update_practice_providers($practice_id)");

        //         //patch added by atif for post upload csv

        //         DB::select("update analytic_data set account_nbr_nbr=convert(account_nbr,unsigned),appointment_date=date_of_service");

        //         DB::select("CALL proc_update_analytic_rows($practice_id)");

        //         DB::select("CALL proc_update_ckd_visit_interval($practice_id)");

        //         DB::select("CALL proc_update_wait_time_weeks($practice_id)");

        //         DB::select("CALL proc_update_hospitalization_followup($practice_id)");

        //         DB::select("CALL proc_update_first_dialysis_ind($practice_id)");

        //         DB::select("CALL proc_update_hosp_p30_dialysis_ind($practice_id)");

        //         DB::select("CALL proc_update_offc_p180_dialysis_ind($practice_id)");

        //         DB::select("CALL proc_update_yearly_stages_wrapepr($practice_id)");

        //         DB::select("CALL proc_update_yearly_expected_visits($practice_id)");

        //         DB::select("CALL proc_update_offc_p365_dialysis_ind($practice_id)");

        //         DB::select("CALL proc_update_active_late_stage($practice_id)");

        //         DB::select("CALL proc_update_yearly_new_late_esrd_convert_wrapepr($practice_id)");

        //         DB::select("CALL proc_update_active_late_stage($practice_id)");

        //         DB::select("CALL proc_update_hospitalization_office_followup_weeks($practice_id)");

        //         DB::select("update analytic_data set provider_fte=1");

        //         DB::select("update analytic_data set cptcode_office_level=substr(cptcode,5,1)");

        //         DB::select("CALL proc_update_rehospitalization_ind($practice_id)");

        //         DB::select("CALL proc_update_tcm_post_discharge_ind($practice_id)");   
        
    }

    public function changeDateFormat($dataf){
        
        $timestamp = strtotime($dataf);
        $formattedDate = date('Y-m-d', $timestamp);
        
        return $formattedDate;
        
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required',
                'practice' => 'required',
            ]);
            set_time_limit(0);
            ini_set('MAX_EXECUTION_TIME', 36000);
            $practice_id = $request->get('practice');

            $extension = $request->file('file')->getClientOriginalExtension();

            if ($extension === 'xlsx' || $extension === 'csv') {

                AnalyticData::where('practice_id', $practice_id)->delete();
                $rows = $this->csvToArray($request->file('file'));
                $rowsCollection = collect($rows);
                $records = $rowsCollection->splice(1, $rowsCollection->count());

                $countRow = 0;
                $firstline = true;
                foreach ($records->chunk(100)->toArray() as $responseChunk) {
                    $data = [];
                    $sql = "insert into analytic_data (provider,Rendering_Provider,Service_Location,account_nbr,Patient_Name,dateofbirth,Date_of_Service,Claim_BillDate,icd_1,icd_2,icd_3,icd_4,icd_5,icd_6,icd_7,icd_8,pos,cptcode,MODIFIER,units,Billed_Amount,Primary_Insurance_Name,Secondary_Insurance_Name,Primary_Insurance_Allowance,Primary_Insurance_Payment,Primary_Contractual_Adjustment,Primary_PaymentDate_CheckDate,Primary_CheckNo_ReferenceNo,Secondary_Insurance_Payment,Secondary_Contractual_Adjustment,Secondary_PaymentDate,Secondary_CheckNo,Patient_Payment,Patient_PaymentDate,Insurance_Balance,Patient_Balance,Write_off,address,city,state,ZIPCode,phone,cptcode_description,work_RVU,practice_RVU,malpractice_RVU,total_RVU,practice_id) values";
                    foreach ($responseChunk as $row) {
                        if (!$firstline) {

                            $row = str_replace("'", '', $row);
                            $provider = $row[0];
                            $renderingProvider = !is_null($row[1]) ? "'" . $row[1] . "'" : null;
                            $serviceLocation = !is_null($row[2]) ? "'" . $row[2] . "'" : null;
                            $patientAccount = !is_null($row[3]) ? "'" . $row[3] . "'" : null;
                            $patientName = !is_null($row[4]) ? "'" . $row[4] . "'" : null;
                            $dateofbirth = (!empty($row[5])) && (false !== strtotime($row[5])) ? "'" . self::change_dateformat($row[5]) . "'" :"null";

                            $Date_of_Service = (!empty($row[6])) && (false !== strtotime($row[6])) ? "'" . Carbon::createFromFormat('m/d/Y', $row[6])->format('Y-m-d') . "'" :"null";
                            $Claim_BillDate =  (!empty($row[7]))  && (false !== strtotime($row[7])) ? "'" . Carbon::createFromFormat('m/d/Y', $row[7])->format('Y-m-d') . "'" :"null";
                            $icd_1 = $row[8];
                            $icd_2 = $row[9];
                            $icd_3 = $row[10];
                            $icd_4 = $row[11];
                            $icd_5 = $row[12];
                            $icd_6 = $row[13];
                            $icd_7 = $row[14];
                            $icd_8 = $row[15];
                            $pos = isset($row[16]) && !empty($row[16]) ? "'".$row[16]."'" : "''";
                            $cptCode = isset($row[17]) && !empty($row[17]) ? "'".$row[17]."'" : "''";
                            // $cptCode = $row[16];
                            // $Modifier = $row[17];
                            $Modifier = isset($row[18]) && !empty($row[18]) ? "'".$row[18]."'" : "''";
                            // $units = $row[18];
                            $units = isset($row[19]) && !empty($row[19]) ? "'".$row[19]."'" : "0";
                            // $Billed_Amount = $row[19];
                            $Billed_Amount = isset($row[20]) && !empty($row[20]) ? "'".$row[20]."'" : "0";
                            // $Primary_Insurance_Name = $row[20];
                            $Primary_Insurance_Name = isset($row[21]) && !empty($row[21]) ? "'".$row[21]."'" : "''";
                            // $Secondary_Insurance_Name = $row[21];
                            $Secondary_Insurance_Name = isset($row[22]) && !empty($row[22]) ? "'".$row[22]."'" : "''";
                            // $Primary_Insurance_Allowance = $row[22];
                            $Primary_Insurance_Allowance = isset($row[23]) ? "".$row[23]."" : "0";
                            // $Primary_Insurance_Payment = $row[23];
                            $Primary_Insurance_Payment = isset($row[24]) && !empty($row[24]) ? "'".$row[24]."'" : "0";
                            // $Primary_Contractual_Adjustment = $row[24];
                            $Primary_Contractual_Adjustment = isset($row[25]) && !empty($row[25]) ? "'".$row[25]."'" : "0";
                            $Primary_PaymentDate_CheckDate = (!empty($row[26])) && (false !== strtotime($row[26])) ? "'" . self::change_dateformat($row[26])  . "'" :"null";
                            // $Primary_CheckNo_ReferenceNo = $row[26];
                            $Primary_CheckNo_ReferenceNo = isset($row[27]) && !empty($row[27]) ? "'".$row[27]."'" : "''";
                            // $Secondary_Insurance_Payment = $row[27];
                            $Secondary_Insurance_Payment = isset($row[28]) && !empty($row[28]) ? "'".$row[28]."'" : "0";
                            // $Secondary_Contractual_Adjustment = $row[28];
                            $Secondary_Contractual_Adjustment = isset($row[29]) && !empty($row[29]) ? "'".$row[29]."'" : "0";
                            $Secondary_PaymentDate = (!empty($row[30])) && (false !== strtotime($row[30])) ? "'" . self::change_dateformat($row[30]) . "'" :"null";
                            // $Secondary_CheckNo = $row[30];
                            $Secondary_CheckNo = isset($row[31]) && !empty($row[31]) ? "'".$row[31]."'" : "''";
                            // $Patient_Payment = $row[31];
                            $Patient_Payment = isset($row[32]) && !empty($row[32]) ? "'".$row[32]."'" : "0";
                            $Patient_PaymentDate = (!empty($row[33])) && (false !== strtotime($row[33])) ? "'" .self::change_dateformat($row[33]) . "'" :"null";
                            // $Insurance_Balance = $row[33];
                            $Insurance_Balance = isset($row[34]) && !empty($row[34]) ? "'".$row[34]."'" : "0";
                            // $Patient_Balance = $row[34];
                            $Patient_Balance = isset($row[35]) && !empty($row[35]) ? "'".$row[35]."'" : "0";
                            // $Write_off = $row[35];
                            $Write_off = isset($row[36]) && !empty($row[36]) ? "'".$row[36]."'" : "0";
                            $address = isset($row[37]) && !empty($row[37]) ? "'".$row[37]."'" : "null";
                            $city = isset($row[38]) && !empty($row[38]) ? "'".$row[38]."'" : "null";
                            $state = isset($row[39]) && !empty($row[39]) ? "'".$row[39]."'" : "null";
                            $zip = isset($row[40]) && !empty($row[40]) ? "'".$row[40]."'" : "null";
                            $phone = isset($row[41]) && !empty($row[41]) ? "'".$row[41]."'" : "null";
                            $cptdescription = isset($row[42]) && !empty($row[42]) ? "'".$row[42]."'" : "null";
                            $workrvu = isset($row[43]) && !empty($row[43]) ? "'".$row[43]."'" : "null";
                            $practicervu = isset($row[44]) && !empty($row[44]) ? "'".$row[44]."'" : "null";
                            $malpraticervu = isset($row[45]) && !empty($row[45]) ? "'".$row[45]."'" : "null";
                            $totalrvu = isset($row[46]) && !empty($row[46]) ? "'".$row[46]."'" : "null";
                            $practice_id = $practice_id; 
                          

                            $sql .= "('" . $provider . "'," . $renderingProvider . "," . $serviceLocation . "," . $patientAccount . "," . $patientName . "," . $dateofbirth. "," . $Date_of_Service;
                            $sql .=  "," . $Claim_BillDate . ",'" . $icd_1 . "','" . $icd_2 . "','" . $icd_3 . "','" . $icd_4 . "','" . $icd_5 . "','" . $icd_6 . "','" . $icd_7 . "','" . $icd_8;
                            $sql .=  "'," . $pos . "," . $cptCode . "," . $Modifier . "," . $units . "," . $Billed_Amount . "," . $Primary_Insurance_Name . "," . $Secondary_Insurance_Name;
                            $sql .=  "," . $Primary_Insurance_Allowance . "," . $Primary_Insurance_Payment . "," . $Primary_Contractual_Adjustment ."," . $Primary_PaymentDate_CheckDate;
                            $sql .=  "," . $Primary_CheckNo_ReferenceNo . "," . $Secondary_Insurance_Payment . "," . $Secondary_Contractual_Adjustment . "," . $Secondary_PaymentDate;
                            $sql .=  "," . $Secondary_CheckNo . "," . $Patient_Payment . "," . $Patient_PaymentDate . "," . $Insurance_Balance  . "," . $Patient_Balance  . "," . $Write_off;
                            $sql .=  "," . $address . "," . $city . "," . $state . "," . $zip  . "," . $phone  . "," . $cptdescription;
                            $sql .=  "," . $workrvu . "," . $practicervu . "," . $malpraticervu . "," . $totalrvu;
                            $sql .=  "," . $practice_id . "),";
                        }
                        $firstline = false;
                    }

                    //DB::enableQueryLog(); // Enable query log

                    //
                    if ($countRow = 40) {
                        // DB::table("analytic_data")->insert(substr($sql,0,strlen($sql)-1));

                    
                    //  DB::select(substr($sql, 0, strlen($sql) - 1));
                        // DB::query(substr($sql, 0, strlen($sql) - 1));
                        $countRow = 0;
                    }
                    $countRow++;
                    //dd(DB::getQueryLog()); // Show results of log
                    dd($sql);
                    // print_r($sql);
                    // die;
                }
                // DB::query(substr($sql, 0, strlen($sql) - 1));
                DB::select("CALL update_practice_payers($practice_id)");

                //procedure call for align data record
                DB::select("CALL update_cptcode_prices($practice_id)");

                DB::select("CALL update_practice_locations($practice_id)");

                DB::select("CALL update_practice_providers($practice_id)");

                //patch added by atif for post upload csv

                DB::select("update analytic_data set account_nbr_nbr=convert(account_nbr,unsigned),appointment_date=date_of_service");

                DB::select("CALL proc_update_analytic_rows($practice_id)");

                DB::select("CALL proc_update_ckd_visit_interval($practice_id)");

                DB::select("CALL proc_update_wait_time_weeks($practice_id)");

                DB::select("CALL proc_update_hospitalization_followup($practice_id)");

                DB::select("CALL proc_update_first_dialysis_ind($practice_id)");

                DB::select("CALL proc_update_hosp_p30_dialysis_ind($practice_id)");

                DB::select("CALL proc_update_offc_p180_dialysis_ind($practice_id)");

                DB::select("CALL proc_update_yearly_stages_wrapepr($practice_id)");

                DB::select("CALL proc_update_yearly_expected_visits($practice_id)");

                DB::select("CALL proc_update_offc_p365_dialysis_ind($practice_id)");

                DB::select("CALL proc_update_active_late_stage($practice_id)");

                DB::select("CALL proc_update_yearly_new_late_esrd_convert_wrapepr($practice_id)");

                DB::select("CALL proc_update_active_late_stage($practice_id)");

                DB::select("CALL proc_update_hospitalization_office_followup_weeks($practice_id)");

                DB::select("update analytic_data set provider_fte=1");

                DB::select("update analytic_data set cptcode_office_level=substr(cptcode,5,1)");

                DB::select("CALL proc_update_rehospitalization_ind($practice_id)");

                DB::select("CALL proc_update_tcm_post_discharge_ind($practice_id)");                


                return response()->json([
                    'status' => true,
                    'message' => 'Your CSV file data successfully updated!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File not valid.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function loadCSVonLoad(){
        
        
            set_time_limit(0);
            ini_set('MAX_EXECUTION_TIME', 36000);
            $practice_id = 1;
            
                //AnalyticData::where('practice_id', $practice_id)->delete();
                $file_path = storage_path('filecsv_new.csv');
                $fileCSV = file($file_path,FILE_IGNORE_NEW_LINES);
                $rows = $fileCSV;
                $rowsCollection = collect($rows);
                $records = $rowsCollection->splice(1, $rowsCollection->count());

                $countRow = 0;
                $firstline = true;
                foreach ($records->chunk(100)->toArray() as $responseChunk) {
                    //dd($responseChunk);
                    $data = [];
                    $sql = "insert into analytic_data (provider,Rendering_Provider,Service_Location,account_nbr,Patient_Name,dateofbirth,Date_of_Service,Claim_BillDate,icd_1,icd_2,icd_3,icd_4,icd_5,icd_6,icd_7,icd_8,pos,cptcode,MODIFIER,units,Billed_Amount,Primary_Insurance_Name,Secondary_Insurance_Name,Primary_Insurance_Allowance,Primary_Insurance_Payment,Primary_Contractual_Adjustment,Primary_PaymentDate_CheckDate,Primary_CheckNo_ReferenceNo,Secondary_Insurance_Payment,Secondary_Contractual_Adjustment,Secondary_PaymentDate,Secondary_CheckNo,Patient_Payment,Patient_PaymentDate,Insurance_Balance,Patient_Balance,Write_off,address,city,state,ZIPCode,phone,cptcode_description,work_RVU,practice_RVU,malpractice_RVU,total_RVU,practice_id) values";
                    foreach ($responseChunk as $row) {
                        if (!$firstline) {
                            $row = str_replace("'", '', $row);
                            $row = explode(',',$row);
                            $provider = $row[0];
                            $renderingProvider = !is_null($row[1]) ? "'" . $row[1] . "'" : null;
                            $serviceLocation = !is_null($row[2]) ? "'" . $row[2] . "'" : null;
                            $patientAccount = !is_null($row[3]) ? "'" . $row[3] . "'" : null;
                            $patientName = !is_null($row[4]) ? "'" . $row[4] . "'" : null;
                            $dateofbirth = (!empty($row[5])) && (false !== strtotime($row[5])) ? "'" . self::change_dateformat($row[5]) . "'" :"null";

                            $Date_of_Service = (!empty($row[6])) && (false !== strtotime($row[6])) ? "'" . self::change_dateformat($row[6]) . "'" :"null";
                            $Claim_BillDate =  (!empty($row[7]))  && (false !== strtotime($row[7])) ? "'" . self::change_dateformat($row[7]) . "'" :"null";
                            $icd_1 = $row[8];
                            $icd_2 = $row[9];
                            $icd_3 = $row[10];
                            $icd_4 = $row[11];
                            $icd_5 = $row[12];
                            $icd_6 = $row[13];
                            $icd_7 = $row[14];
                            $icd_8 = $row[15];
                            $pos = isset($row[16]) && !empty($row[16]) ? "'".$row[16]."'" : "''";
                            $cptCode = isset($row[17]) && !empty($row[17]) ? "'".$row[17]."'" : "''";
                            // $cptCode = $row[16];
                            // $Modifier = $row[17];
                            $Modifier = isset($row[18]) && !empty($row[18]) ? "'".$row[18]."'" : "''";
                            // $units = $row[18];
                            $units = isset($row[19]) && !empty($row[19]) ? "'".$row[19]."'" : "0";
                            // $Billed_Amount = $row[19];
                            $Billed_Amount = isset($row[20]) && !empty($row[20]) ? "'".$row[20]."'" : "0";
                            // $Primary_Insurance_Name = $row[20];
                            $Primary_Insurance_Name = isset($row[21]) && !empty($row[21]) ? "'".$row[21]."'" : "''";
                            // $Secondary_Insurance_Name = $row[21];
                            $Secondary_Insurance_Name = isset($row[22]) && !empty($row[22]) ? "'".$row[22]."'" : "''";
                            // $Primary_Insurance_Allowance = $row[22];
                            $Primary_Insurance_Allowance = isset($row[23]) ? "".$row[23]."" : "0";
                            // $Primary_Insurance_Payment = $row[23];
                            $Primary_Insurance_Payment = isset($row[24]) && !empty($row[24]) ? "'".$row[24]."'" : "0";
                            // $Primary_Contractual_Adjustment = $row[24];
                            $Primary_Contractual_Adjustment = isset($row[25]) && !empty($row[25]) ? "'".$row[25]."'" : "0";
                            $Primary_PaymentDate_CheckDate = (!empty($row[26])) && (false !== strtotime($row[26])) ? "'" . self::change_dateformat($row[26])  . "'" :"null";
                            // $Primary_CheckNo_ReferenceNo = $row[26];
                            $Primary_CheckNo_ReferenceNo = isset($row[27]) && !empty($row[27]) ? "'".$row[27]."'" : "''";
                            // $Secondary_Insurance_Payment = $row[27];
                            $Secondary_Insurance_Payment = isset($row[28]) && !empty($row[28]) ? "'".$row[28]."'" : "0";
                            // $Secondary_Contractual_Adjustment = $row[28];
                            $Secondary_Contractual_Adjustment = isset($row[29]) && !empty($row[29]) ? "'".$row[29]."'" : "0";
                            $Secondary_PaymentDate = (!empty($row[30])) && (false !== strtotime($row[30])) ? "'" . self::change_dateformat($row[30]) . "'" :"null";
                            // $Secondary_CheckNo = $row[30];
                            $Secondary_CheckNo = isset($row[31]) && !empty($row[31]) ? "'".$row[31]."'" : "''";
                            // $Patient_Payment = $row[31];
                            $Patient_Payment = isset($row[32]) && !empty($row[32]) ? "'".$row[32]."'" : "0";
                            $Patient_PaymentDate = (!empty($row[33])) && (false !== strtotime($row[33])) ? "'" .self::change_dateformat($row[33]) . "'" :"null";
                            // $Insurance_Balance = $row[33];
                            $Insurance_Balance = isset($row[34]) && !empty($row[34]) ? "'".$row[34]."'" : "0";
                            // $Patient_Balance = $row[34];
                            $Patient_Balance = isset($row[35]) && !empty($row[35]) ? "'".$row[35]."'" : "0";
                            // $Write_off = $row[35];
                            $Write_off = isset($row[36]) && !empty($row[36]) ? "'".$row[36]."'" : "0";
                            $address = isset($row[37]) && !empty($row[37]) ? "'".$row[37]."'" : "null";
                            $city = isset($row[38]) && !empty($row[38]) ? "'".$row[38]."'" : "null";
                            $state = isset($row[39]) && !empty($row[39]) ? "'".$row[39]."'" : "null";
                            $zip = isset($row[40]) && !empty($row[40]) ? "'".$row[40]."'" : "null";
                            $phone = isset($row[41]) && !empty($row[41]) ? "'".$row[41]."'" : "null";
                            $cptdescription = isset($row[42]) && !empty($row[42]) ? "'".$row[42]."'" : "null";
                            $workrvu = isset($row[43]) && !empty($row[43]) ? "'".$row[43]."'" : "null";
                            $practicervu = isset($row[44]) && !empty($row[44]) ? "'".$row[44]."'" : "null";
                            $malpraticervu = isset($row[45]) && !empty($row[45]) ? "'".$row[45]."'" : "null";
                            $totalrvu = isset($row[46]) && !empty($row[46]) ? "'".$row[46]."'" : "null";
                            $practice_id = $practice_id; 
                          

                            $sql .= "('" . $provider . "'," . $renderingProvider . "," . $serviceLocation . "," . $patientAccount . "," . $patientName . "," . $dateofbirth. "," . $Date_of_Service;
                            $sql .=  "," . $Claim_BillDate . ",'" . $icd_1 . "','" . $icd_2 . "','" . $icd_3 . "','" . $icd_4 . "','" . $icd_5 . "','" . $icd_6 . "','" . $icd_7 . "','" . $icd_8;
                            $sql .=  "'," . $pos . "," . $cptCode . "," . $Modifier . "," . $units . "," . $Billed_Amount . "," . $Primary_Insurance_Name . "," . $Secondary_Insurance_Name;
                            $sql .=  "," . $Primary_Insurance_Allowance . "," . $Primary_Insurance_Payment . "," . $Primary_Contractual_Adjustment ."," . $Primary_PaymentDate_CheckDate;
                            $sql .=  "," . $Primary_CheckNo_ReferenceNo . "," . $Secondary_Insurance_Payment . "," . $Secondary_Contractual_Adjustment . "," . $Secondary_PaymentDate;
                            $sql .=  "," . $Secondary_CheckNo . "," . $Patient_Payment . "," . $Patient_PaymentDate . "," . $Insurance_Balance  . "," . $Patient_Balance  . "," . $Write_off;
                            $sql .=  "," . $address . "," . $city . "," . $state . "," . $zip  . "," . $phone  . "," . $cptdescription;
                            $sql .=  "," . $workrvu . "," . $practicervu . "," . $malpraticervu . "," . $totalrvu;
                            $sql .=  "," . $practice_id . "),";
                        }
                        $firstline = false;
                    }

                    //DB::enableQueryLog(); // Enable query log

                    //
                    if ($countRow = 40) {
                    
                        //DB::select(substr($sql, 0, strlen($sql) - 1));
                        $countRow = 0;
                        //sleep(1);
                    }
                    $countRow++;
                    // print_r($sql);
                    // die;
                }
                
                // // DB::query(substr($sql, 0, strlen($sql) - 1));
                // DB::select("CALL update_practice_payers($practice_id)");

                // //procedure call for align data record
                // DB::select("CALL update_cptcode_prices($practice_id)");

                // DB::select("CALL update_practice_locations($practice_id)");

                // DB::select("CALL update_practice_providers($practice_id)");

                // //patch added by atif for post upload csv

                // DB::select("update analytic_data set account_nbr_nbr=convert(account_nbr,unsigned),appointment_date=date_of_service");

                // DB::select("CALL proc_update_analytic_rows($practice_id)");

                // DB::select("CALL proc_update_ckd_visit_interval($practice_id)");

                // DB::select("CALL proc_update_wait_time_weeks($practice_id)");

                // DB::select("CALL proc_update_hospitalization_followup($practice_id)");

                // DB::select("CALL proc_update_first_dialysis_ind($practice_id)");

                // DB::select("CALL proc_update_hosp_p30_dialysis_ind($practice_id)");

                // DB::select("CALL proc_update_offc_p180_dialysis_ind($practice_id)");

                // DB::select("CALL proc_update_yearly_stages_wrapepr($practice_id)");

                // DB::select("CALL proc_update_yearly_expected_visits($practice_id)");

                // DB::select("CALL proc_update_offc_p365_dialysis_ind($practice_id)");

                // DB::select("CALL proc_update_active_late_stage($practice_id)");

                // DB::select("CALL proc_update_yearly_new_late_esrd_convert_wrapepr($practice_id)");

                // DB::select("CALL proc_update_active_late_stage($practice_id)");

                // DB::select("CALL proc_update_hospitalization_office_followup_weeks($practice_id)");

                // DB::select("update analytic_data set provider_fte=1");

                // DB::select("update analytic_data set cptcode_office_level=substr(cptcode,5,1)");

                // DB::select("CALL proc_update_rehospitalization_ind($practice_id)");

                // DB::select("CALL proc_update_tcm_post_discharge_ind($practice_id)");    
        
    }
    

    public function change_dateformat($originalDate){

        $newDate = date("Y-m-d", strtotime($originalDate));
        return $newDate;
    }


    /**
     * @param UploadReportsDatum $uploadreportsdatum
     * @param EditUploadReportsDatumRequest $request
     * @return EditResponse
     */
    public function edit(UploadReportsDatum $uploadreportsdatum, EditUploadReportsDatumRequest $request)
    {
        return new EditResponse($uploadreportsdatum);
    }

    /**
     * @param UpdateUploadReportsDatumRequest $request
     * @param UploadReportsDatum $uploadreportsdatum
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateUploadReportsDatumRequest $request, UploadReportsDatum $uploadreportsdatum)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update($uploadreportsdatum, $input);
        //return with successfull message
        return new RedirectResponse(route('admin.uploadreportsdata.index'), ['flash_success' => trans('alerts.backend.uploadreportsdata.updated')]);
    }

    /**
     * @param UploadReportsDatum $uploadreportsdatum
     * @param DeleteUploadReportsDatumRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(UploadReportsDatum $uploadreportsdatum, DeleteUploadReportsDatumRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($uploadreportsdatum);
        //returning with successfull message
        return new RedirectResponse(route('admin.uploadreportsdata.index'), ['flash_success' => trans('alerts.backend.uploadreportsdata.deleted')]);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
