<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use App\Mail\VerifyEmail;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\Settings\Setting;
use App\Repositories\Frontend\Pages\PagesRepository;
use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return redirect('admin/dashboard');
        $settingData = Setting::first();
        $google_analytics = $settingData->google_analytics;

        return view('frontend.index', compact('google_analytics', $google_analytics));
    }

    /**
     * show page by $page_slug.
     */
    public function showPage($slug, PagesRepository $pages)
    {
        $result = $pages->findBySlug($slug);

        return view('frontend.pages.index')
            ->withpage($result);
    }

    public function createConfigApp()
    {
        if (User::count() == 0) {
            return view('backend.config-app');
        }

        return abort('404');
    }


    public function registerAdminUserOnLocal(Request $request)
    {

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:256',
                'last_name' => 'required|max:256',
                'email' => 'required|email|unique:users',
            ]);

            if ($validator->fails()) {
                $errorString = implode(" <br> ", $validator->messages()->all());
                return back()->withErrors([$errorString])->withInput();
            }

            $input = $request->all();
            $confirmation_code = md5(uniqid(mt_rand()));

            $person = Person::create([
                'name' => $input['first_name'] . ' ' .$input['last_name'],
                'email' => $input['email'],
            ]);

            $user = User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => null,
                'confirmation_code' => $confirmation_code,
                'confirmed' => true,
                'person_id' => $person->id,
            ]);


            $role = RoleUser::create([
                'role_id' => 1,
                'user_id' => $user['id'],
            ]);
            DB::commit();
            $sendEmail = new VerifyEmail($user);
            Mail::to($user->email)->send($sendEmail);

            return view('backend.app-config-message');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
    public function verifyEmail($code){
        $user = User::where('confirmation_code',$code)->first();
        if($user){
            return new ViewResponse('backend.welcome-page',compact('user'));
        }else{
            abort(401);
        }

    }

    public function verifyPassword(Request $request){
//        $validator = Validator::make($request->all(), [
//            'password' => 'min:12|required_with:confirm_password|same:confirm_password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
//        ]);
        abort(401);
    }
}
