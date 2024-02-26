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

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = Redis::get('user_list');
        if (!$userList) {
            $list = DB::table('esk_apidb.f_link_master')->get();
            $userList = [];
            foreach ($list as $li) {
                $userList[] = array(
                    'linkId' => $li->intLinkId,
                    'linkName' => $li->vchLinkName,
                    'slugName' => $li->vchSlugName,
                    'className' => $li->vchClassName,
                    'serialNo' => $li->intSerialNo,
                    'publishStatus' => $li->tinPublishStatus,
                    'linkType' => $li->vchLinkType,
                    'microServiceName' => $li->vchMicroServiceName,
                    'controllerName' => $li->vchControllerName,
                    'createdOn' => date('d-M-Y h:i a', strtotime($li->stmCreatedOn))
                );
            }

            Redis::set('user_list', json_encode($userList));
        } else {
            $userList = json_decode($userList, true);
        }

        return $userList;
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
    public function show(Request $request)
    {
        $status = false;
        $msg = "";
        $accessToken = "";
        $expireIn = time();
        if (Redis::exists('loginData_' . $request['email'] . '')) {
            $uData =  Redis::get('loginData_' . $request['email'] . '');
        } else {
            $query = DB::table('esk_apidb.users')
                ->where('email', $request['email'])
                ->get();
            if ($query->isNotEmpty()) {
                Redis::set('loginData_' . $request['email'] . '', $query);
                $uData =  Redis::get('loginData_' . $request['email'] . '');
            } else {

                $status = false;
                $msg = "User not found";
                return response()->json([
                    'status' => $status,
                    'msg' => $msg,
                    // 'accessToken' => $accessToken,
                    'expireIn' => $expireIn
                ]);
            }
        }

        $uData = collect(json_decode($uData))[0];

        if (Hash::check($request['password'],  $uData->password)) {
            $status = true;
            $msg = "Login success";
            $accessToken = Crypt::encryptString($request['email']);
            $expireIn = time();
        } else {
            $msg = "Incorrect Password";
        }
        $linkData = $this->index();
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'accessToken' => $accessToken,
            'expireIn' => $expireIn,
            'linkData' => $linkData
        ]);
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
}
