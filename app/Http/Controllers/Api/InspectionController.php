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
use App\Jobs\ProcessPodcast;
use Illuminate\Support\Facades\Log;



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
        $checkedSchools = $request->all();
        $insertData = [];
        //iterating through each data and appending it to the $insertData[] array.
        foreach ($checkedSchools as $schoolData) {
            $insertData[] = [
                'dist_id' => (int)$schoolData['district'],
                'block_id' => (int)$schoolData['block'],
                'cluster_id' => (int)$schoolData['cluster'],
                'school_id' => (int)$schoolData['schoolId'],
                'total_inspection' => (int)$schoolData['inspection']
            ];
        }
        DB::table('esk_apidb.s_inspection')->insert($insertData);
        return response()->json(['message' => 'Data stored successfully']);
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
        $cacheData = Redis::get('districtList');
        // Check if the data exists in Redis cache
        if ($cacheData) {
            return response()->json(json_decode($cacheData));
        }
        // If data doesn't exist in cache, fetch it from the database
        $list = DB::table('esk_master.districts')->get();
        Redis::set(json_encode($list));
        return response()->json($list);
    }




    public function getBlock(Request $request)
    {
        $cacheKey = 'district_' . $request['id'];
        $cachedData = Redis::get($cacheKey);
        // Check if the data exists in Redis cache
        if ($cachedData) {
            return response()->json(json_decode($cachedData));
        }
        // If data doesn't exist in cache, fetch it from the database
        $districtId = $request->id;
        $list = DB::table('esk_master.blocks')->where('districtId', $districtId)->get();
        Redis::set($cacheKey, json_encode($list));
        return response()->json($list);
    }




    public function getCluster(Request $request)
    {
        $cacheKey = 'block_' . $request['id'];
        $cacheData = Redis::get($cacheKey);
        // Check if the data exists in Redis cache
        if ($cacheData) {
            return response()->json(json_decode($cacheData));
        }
        // If data doesn't exist in cache, fetch it from the database
        $blockId = $request->id;
        $list = DB::table('esk_master.clusters')->where('blockId', $blockId)->get();
        Redis::set($cacheKey, json_encode($list));
        return response()->json($list);
    }




    public function getSchool(Request $request)
    {
        //creating key of Redis cache
        $cacheKey = 'cluster_' . $request['id'];
        $cacheData = Redis::get($cacheKey);
        // Check if the data exists in Redis cache
        if ($cacheData) {
            return response()->json(json_decode($cacheData));
        }
        // If data doesn't exist in cache, fetch it from the database
        $clusterId = $request->id;
        $list = DB::table('esk_school.school')->where('clusterId', $clusterId)->get();
        Redis::set($cacheKey, json_encode($list));
        return response()->json($list);
    }

    public function que()
    {
        $a = "vivek";
        // Log::info('This is test log');

        // return response()->json($a);

        // ProcessPodcast::dispatch($a);
        dispatch(new ProcessPodcast($a));
        return "data dispatch successfully";
    }

    public function test($r)
    {

        // Log::channel('customlog')->info('Queue Executed Successfully');
        // sleep(5);
        DB::table('esk_apidb.version')->update([
            'createdOn' => now()
        ]);
    }
}
