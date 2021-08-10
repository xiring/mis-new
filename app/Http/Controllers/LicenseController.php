<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{

    private function  generateKey()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%^&*()_+=~,><?/|{}[]-';
        $charactersLength = strlen($characters);
        $length = 15;
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key.= $characters[rand(0, $charactersLength - 1)];
        }
        return $key;
    }

    public function index()
    {
        $licenses = License::orderBy('created_at', 'ASC')->get();

        return view('master.license.index', compact('licenses'));

    }

    public function store(Request $request)
    {
        $license = new License();

        $license->name = $request->name;
        $license->number_of_user = $request->number_of_user;
        $license->key = $this->generateKey();

        if($license->save()):
            flash('License  ' .$license->name . ' was created successfully.','success');
            return redirect()->back();
        endif;

    }

    public function update(Request $request)
    {
        $license = License::find($request->id);

        $license->name = $request->name;
        $license->number_of_user = $request->number_of_user;

        if($license->update()):
            flash('License  ' .$license->name . ' was updated successfully.','success');
            return redirect()->back();
        endif;

    }

    public function delete($id)
    {
        $license = License::findOrFail($id);

        $license->is_active = 0;

        if($license->update()):
            flash('License  ' .$license->name . ' was deleted successfully.','warning');
            return redirect()->back();
        endif;
    }

    public function restore($id)
    {
        $license = License::findOrFail($id);

        $license->is_active = 1;

        if($license->update()):
            flash('License  ' .$license->name . ' was restored successfully.','success');
            return redirect()->back();
        endif;
    }
}
