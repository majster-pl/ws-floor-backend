<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return "test";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        $user = User::find($id);
        // errors . newPassword
        if ($user->email === "demo@demo.com") {
            $error = [];
            $error["message"] = "This operation is not allowed for demo user!";
            return response()->json(
                $error,
                Response::HTTP_UNAUTHORIZED
            );
        }
        // sleep(3);
        // check if new password request sent...
        if (isset($request->newPassword)) {
            $request->validate([
                'newPassword' => [
                    Password::min(8)->letters()->numbers()->mixedCase()->symbols(),
                ],
                ['passwordConfirmation' => 'required|min:8']
            ]);
            if ($request->newPassword === $request->passwordConfirmation) {
                $user->password = Hash::make($request->newPassword);
            } else {
                $error["errors"]["dontMatch"] = ["Password doesn't match!"];
                return response()->json(
                    $error,
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $user->update($request->all());
        return $user;
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
