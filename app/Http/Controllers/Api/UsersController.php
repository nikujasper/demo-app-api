<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Request $req)
    {

        $status = false;
        $msg = "";
        $accessToken = "";
        $expireIn = time();
        $id = $req->input('email');
        try {
            $user = DB::table('esk_apidb.users')->where('email', $id)->first();

            if ($user) {
                if (Hash::check($req->input('password'), $user->password)) {
                    $status = true;
                    $msg = "Login success";
                    $accessToken = Crypt::encryptString($id);
                    $expireIn = time();
                } else {
                    $msg = "Incorrect Password";
                }
            } else {
                $msg = "User not found";
            }
        } catch (\Exception $e) {
            $msg = "An error occurred: " . $e->getMessage();
        }

        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'accessToken' => $accessToken,
            'expireIn' => $expireIn
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
