<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Parents;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class ParentController extends Controller
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
        $page = 'Parents';

        $parents = Parents::where('school_id', Auth::user()->school->id)->orderBy('created_at', 'ASC')->get();

        return view('school_admin.parent.index', compact('parents', 'page')) ;
    }

    public function bulkImport()
    {
        $page = 'Parents';

        return view('school_admin.parent.import', compact('page')) ;
    }

    private function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.'@gmail.com';
    }

    public function bulkImportStore(Request $request)
    {

        $file  =   Input::file('file');
        $ext = $file->getClientOriginalExtension();
        $filename = basename($request->file('file')->getClientOriginalName(), '.' . $request->file('file')->getClientOriginalExtension()). "." . $ext;
        $dest = 'assets/uploads/import/';
        $file->move($dest, $filename);

        $csv = array_map('str_getcsv', file('assets/uploads/import/parent.csv'));
        $count = 1;
        $array_size = sizeof($csv);
        foreach ($csv as $row) {
            if ($count == 1) {
               $count++;
               continue;
            }

            $user = new User();
            $user->name = $row[0];
            $user->email = ($row[1]) ? $row[1] : $this->generateRandomString();
            $user->user_type = 4;
            $user->password = Hash::make('admin123');
            $user->save();

            $parent = new Parents();
            $parent->user_id = $user->id;
            $parent->school_id = Auth::user()->school->id;
            $parent->phone = $row[2];
            $parent->address = $row[3];
            $parent->profession = $row[4];
            $parent->save();

        }
        flash('Parent were imported successfully.','success');
        return redirect()->route('parent.index');
    }

    public  function  store(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 4;
        $user->password = Hash::make('admin123');

        $user->save();

        $parent = new Parents();
        $parent->user_id = $user->id;
        $parent->school_id = $request->school_id;
        $parent->phone = $request->phone;
        $parent->profession = $request->profession;
        $parent->address = $request->address;

        if($parent->save()):
            flash('Parent  ' .$parent->user->name . ' was added successfully.','success');
            return redirect()->back();
        endif;
    }

    public  function  update(Request $request)
    {
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->update();

        $parent = Parents::where('user_id', $user->id)->first();
        $parent->phone = $request->phone;
        $parent->profession = $request->profession;
        $parent->address = $request->address;

        if($parent->update()):
            flash('Parent  ' .$parent->user->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;
    }

    public function delete($id)
    {
        $parent = Parents::find($id);
        $parent->is_active = 0;

        $user = $parent->user;
        $user->is_active = 0;
        $user->update();

        if($parent->update()):
            flash('Teacher  ' .$parent->user->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $parent = Parents::find($id);
        $parent->is_active = 1;

        $user = $parent->user;
        $user->is_active = 1;
        $user->update();

        if($parent->update()):
            flash('Teacher  ' .$parent->user->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
