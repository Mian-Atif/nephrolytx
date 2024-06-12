<?php

namespace App\Http\Controllers\Backend\TotalActivePatientBalance;

use App\Models\TotalActivePatientBalance\TotalActivePatientBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\TotalActivePatientBalance\CreateResponse;
use App\Http\Responses\Backend\TotalActivePatientBalance\EditResponse;
use App\Repositories\Backend\TotalActivePatientBalance\TotalActivePatientBalanceRepository;
use App\Http\Requests\Backend\TotalActivePatientBalance\ManageTotalActivePatientBalanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * TotalActivePatientBalancesController
 */
class TotalActivePatientBalancesController extends Controller
{
    /**
     * variable to store the repository object
     * @var TotalActivePatientBalanceRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param TotalActivePatientBalanceRepository $repository;
     */
    public function __construct(TotalActivePatientBalanceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\TotalActivePatientBalance\ManageTotalActivePatientBalanceRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageTotalActivePatientBalanceRequest $request)
    {
        try {
            $patient_id = Auth::user()->practice_id;
            $analysisReports = DB::select("call charge_payment_analysis($patient_id,'','','','')");
            return new ViewResponse('backend.totalactivepatientbalances.index', compact('analysisReports'));
        }catch (\Exception $e) {
            return back();
        }
    }


    public function store(Request $request){
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $payer= $request->get('payer');
            $provider = $request->get('provider');
            $location = $request->get('location');
            $analysisReports = DB::select('CALL charge_payment_analysis(?,?,?,?,?)', array($practice_id, $location, $provider,$payer, ''));
            $view = (string)view('backend.totalactivepatientbalances.partials.tableBody',  compact('analysisReports'));


            $activePatientStats=DB::select('CALL active_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $newPatientStats =DB::select('CALL new_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $esrdStats =DB::select('CALL ESRD_patients_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $nonEsrdStats =DB::select('CALL nonESRD_patient_count(?,?,?,?,?)',[$practice_id,$location,$provider,$payer,'']);
            $stat = (string) view('backend.partials.statsRow', compact('activePatientStats','newPatientStats','esrdStats','nonEsrdStats'
            ));
            return response()->json(['status' => true, 'view' => $view,'stat'=>$stat]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function csvimport(){

        return view('admin.users.csvimport');
    }

    public function savecsvusers(CsvUserRequest $request){
        $currentUser=Auth::user();
        $extension = $request->file('csvfile')->extension();
        // dd($extension);


        $data=array();
        $extension = $request->file('csvfile')->extension();
        if($extension==='txt' || $extension==='csv')
        {
            $path = $request->file('csvfile')->getRealPath();
            $data = array_map('str_getcsv', file($path));
        }
        else
        {
            $usersarray=array();
            $usersarray = Excel::toArray(new UsersImport, request()->file('csvfile'));
            $data=$usersarray[0];

        }

        for($i=0;$i<sizeof($data);$i++)
        {
            $userexist=User::where('email',$data[$i][2])->get();
            if(count($userexist)>0)
            {

            }
            else {

                $clientrole=array('2');
                $currentUser=Auth::user();
                if($currentUser->roles[0]->id==3)
                {
                    $created_by = $currentUser->id;
                }
                else{
                    $created_by = 0;
                }
                $random_password = mt_rand(100000, 999999);

                $user = new User();
                $user->first_name = $data[$i][0];
                $user->last_name = $data[$i][1];
                $user->email = $data[$i][2];
                $user->password = $random_password;
                $user->created_by = $created_by;
                $user->save();
                $user->roles()->sync($clientrole);
            }
        }

        return redirect()->route('admin.users.index')->with('success','CSV Users Import Successfully!');
    }

}
