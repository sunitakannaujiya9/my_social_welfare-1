<?php

namespace App\Http\Controllers\Ac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SportsScheme;

class AcSportsSchemeController extends Controller
{
    public function sportsSchemeApplicationList($status){

        $data =  DB::table('trans_sports_scheme AS t1')
                    ->select('t1.*','t2.category', 't4.sign_uploaded_live_certificate')
                    ->leftJoin('users AS t2', 't2.id', '=', 't1.created_by')
                    ->leftJoin('hayticha_form AS t4', 't2.id', '=', 't4.user_id')
                    ->where('t1.hod_status', '=', 1)
                    ->where('t1.ac_status', '=', $status)
                    ->whereNull('t1.deleted_at')
                    ->orderBy('t1.id', 'DESC')
                    ->get();

        return view('ac.sports_scheme.grid', compact('data', 'status'));
    }

    public function sportsSchemeApplicationView($id, $status){

        $data =  DB::table('trans_sports_scheme AS t1')
                    ->where('t1.ac_status', '=', $status)
                    ->where('t1.id', '=', $id)
                    ->whereNull('t1.deleted_at')
                    ->orderBy('t1.id', 'DESC')
                    ->first();

        $document = DB::table('trans_sports_scheme_documents AS t1')
                        ->select('t1.*', 't2.document_name')
                        ->leftJoin('document_type_msts AS t2', 't2.id', '=', 't1.document_id')
                        ->whereNull('t1.deleted_at')
                        ->where('t1.sports_id',$data->id)
                        ->get();

      return view('ac.sports_scheme.view', compact('data', 'document'));

    }


    public function rejectSportsSchemeApplication(request $request, $id){

        $update = [
            'ac_status' => 2,
            'ac_reject_reason' => $request->get('ac_reject_reason'),
            'ac_reject_date' => date("Y-m-d H:i:s"),
            'reject_by_ac' => Auth::user()->id,
        ];
        SportsScheme::where('id', $id)->update($update);
        return redirect('ac_sports_scheme_application_list/2')->with('message', 'Sports Scheme Application Rejected by AC Successfully');
    }

    public function approveSportsSchemeApplication(request $request, $id){

        $update = [
            'ac_status' => 1,
            'ac_approval_date' => date("Y-m-d H:i:s"),
            'ac_remark' => $request->get('remark'),
            'approve_by_ac' => Auth::user()->id,
        ];
        SportsScheme::where('id', $id)->update($update);
        return redirect('ac_sports_scheme_application_list/1')->with('message', 'Sports Scheme Application Approved by AC Successfully');
    }
}