<?php

namespace App\Http\Controllers;

use App\Models\LookupCode;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Alert;

class QrcodesController extends Controller
{
    //
    public function index()
    {
        try{
            $qr_codes = Qrcode::all();
            $camper_cats = LookupCode::RetrieveLookups(6);
            return view('admin.layout.backend.qrcodes.index', compact('qr_codes','camper_cats'));
        }
        catch (\Exception $ex){
            Alert::error('Some error occured!', 'Sorry');
            return  redirect()->back();
        }

    }

    public function generate(Request $request)
    {
        $this->validate($request,[
            'length'=>'required|numeric|max:20',
            'quantity'=>'required|numeric',
            'campercat'=>'required|numeric'
        ]);

        try{
            for ($a=1; $a <= (int)$request->quantity; $a++){
//            do{
//                $length = $request->length;
//                $qrcode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, $length);
//                $code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
//                $exist_qrcode = Qrcode::where('qrcode','=',$qrcode)->count();
//                $exist_code = Qrcode::where('code','=',$code)->count();
//                dd($request->all());
//            }
//            while ($exist_qrcode > 0 && $exist_code > 0 );
//            do{
                $length = (int)$request->length;
                $qrcode = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0, $length);
                $code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
                $exist_qrcode = Qrcode::where('qrcode','=',$qrcode)->count();
                $exist_code = Qrcode::where('code','=',$code)->count();
//            }
                if ($exist_qrcode == 0 && $exist_code == 0 ) {
                    Qrcode::updateOrCreate([
                        'qrcode'    =>  $qrcode,
                        'code'      =>  $code,
                    ],[
                        'camper_cat'    =>  (int)$request->campercat,
                        'create_app_user_id'    =>  \Auth::user()->id,
                        'update_app_user_id'    =>  \Auth::user()->id,
                    ]);

                }


            }
        }
        catch (\Exception $exception) {
            dd($exception->getMessage());
        }


        return back();
    }

    public function blockqrcode($id) {
        //Find a user with a given id and delete
        $qr = Qrcode::findOrFail($id);
//        dd($qr);
        $qr->update_app_user_id = \Auth::user()->id;
        $qr->active_flag = 10;
        $qr->save();

        Alert::success('QR Code blocked successfully!', 'Success');
        return  redirect()->back();
    }
}
