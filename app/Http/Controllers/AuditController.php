<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\AuditTrail;
use App\Models\User;

class AuditController extends Controller
{
    //
    public function __construct()
    {
//        $this->middleware(['auth','isAdmin']);
        $this->middleware(['auth','isAdmin']);
    }

    public function index()
    {

//        $audits = AuditTrail::find(1)->toJson();
        $audits = AuditTrail::all();
//        dd($audits);

//        $payment = Payment::find(2);
        return view('admin.layout.backend.audits.index',compact('audits'));
//        dd($audit);
    }

    /**
     * Auditable Model audits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
}