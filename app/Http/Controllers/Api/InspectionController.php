<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use LDAP\Result;


class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getDistrict()
    {
        $list = DB::table('esk_master.districts')->get();
        return response()->json($list);
    }
    public function getBlock(Request $request)
    {
        $districtId = $request->id;
        $list = DB::table('esk_master.blocks')->where('districtId', $districtId)->get();
        return response()->json($list);
    }
    public function getCluster(Request $request)
    {
        $blockId = $request->id;
        $list = DB::table('esk_master.clusters')->where('blockId', $blockId)->get();
        return response()->json($list);
    }
    public function getSchool(Request $request)
    {
        $clusterId = $request->id;
        $list = DB::table('esk_school.school')->where('clusterId', $clusterId)->get();
        return response()->json($list);
    }
}
