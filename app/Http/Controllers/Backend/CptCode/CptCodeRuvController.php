<?php

namespace App\Http\Controllers\Backend\CptCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CptCode\CreateCptCodeRequest;
use App\Http\Requests\Backend\CptCode\ManageCptCodeRequest;
use App\Http\Requests\Backend\CptCode\StoreCptCodeRequest;
use App\Http\Responses\Backend\CptCode\CreateResponse;
use App\Http\Responses\ViewResponse;
use App\Imports\CptCodePrice;
use App\Models\BillingManager\BillingManager;
use App\Models\CptCode\CptCode;
use App\Models\CptCodeRvu\CptCodeRvu;
use App\Models\Practice\Practice;
use App\Repositories\Backend\CptCode\CptCodeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CptCodeRuvController extends Controller
{

    /**
     * variable to store the repository object
     * @var CptCodeRepository
     */
    protected $repository;

    /**
     * CptCodeRuvController constructor.
     * @param CptCodeRepository $repository
     */
    public function __construct(CptCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return ViewResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $practices = Practice::get();

            $cptCodes = DB::table('cptcodeandrvu')->get();

            return new ViewResponse('backend.cptcodeandrvu.index', compact('cptCodes',  'practices'));
        } catch
        (\Exception $e) {
            return back()->with('message', 'Some thing went wrong');
        }
    }

    /**
     * @param CreateCptCodeRequest $request
     * @return CreateResponse
     */
    public function create(CreateCptCodeRequest $request)
    {

        return view('backend.cptcodeandrvu.create');
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
            $extension = $request->file('file')->getClientOriginalExtension();
            $practice_id = $request->get('practice');

            if ($extension === 'txt' || $extension === 'csv') {
                $cptCodeData = CptCode::where('practice_id', $practice_id)->delete();

                Excel::import(new CptCodePrice($practice_id), $request->file('file'));
                return response()->json([
                    'status' => true,
                    'message' => 'You CSV file data successfully updated!'
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


    public function save(Request $request)
    {
        try {
//            $this->repository->addCptCode($request);

            $validatedData = $request->validate([
//            'cpt_code' => 'required|unique:cptcode_prices,cpt_code,'.Auth::user()->practice_id.',practice_id',
                'cpt_code' => 'required',
                'par_amount' => 'required',
            ]);
            $practiceId = Auth::user()->practice_id;
            $cptCode = $request['cpt_code'];
            $validate = CptCode::where('practice_id', $practiceId)->where('cpt_code', $cptCode)->get();//dd(count($validate)>0);
            if (count($validate) > 0) {
                return response()->json(['status' => false, 'message' => 'You Already take this CPT code']);
            }
            $cptInsuranceArray = [
                'practice_id' => $request['practice'],
                'cpt_code' => $request['cpt_code'],
                'par_amount' => $request['par_amount'],
                'state' => $request['state'],
            ];
            $cptCode = CptCode::create($cptInsuranceArray);
            $practiceId = $request['practice'];////Illuminate\Support\Facades\Auth::user()->practice_id;
            $cptCode->cptCodePrice()->associate($practiceId)->save();
            return response()->json(['status' => true, 'message' => 'CptCode Price Added Successfully !!']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ]);
        }

    }






    public function destroy($id)
    {
        try {
            $cptcodervu = CptCodeRvu::find($id);
            $name = $cptcodervu->cptcode;
            if (!is_null($cptcodervu)) {
                $cptcodervu->delete();
                return response()->json([
                    'status' => true,
                    'message' => $name . ' deleted successfully!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }




//
}
