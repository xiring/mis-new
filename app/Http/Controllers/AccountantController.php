<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use App\Models\School;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountantController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $system_settings = School::where('user_id', Auth::user()->id)->first();
            view()->share('system_settings', $system_settings);

            return $next($request);

        });
    }

    public function index()
    {
        $page = 'Accountants';

        $accountants = Accountant::where('school_id', Auth::user()->school->id)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.accountant.index', compact('accountants', 'page')) ;
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('admin123');
        $user->user_type = 6;
        $user->save();

        $accountant = new Accountant();
        $accountant->school_id = $request->school_id;
        $accountant->user_id = $user->id;

        if($accountant->save()):
            flash('Accountant  ' .$accountant->user->name . ' was added successfully.','success');
            return redirect()->back();
        endif;

    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->update();

        if($user->save()):
            flash('Accountant  ' .$user->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->is_active = 0;

        if($user->update()):
            flash('Accountant  ' .$user->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $user = User::find($id);
        $user->is_active = 1;

        if($user->update()):
            flash('Accountant  ' .$user->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
