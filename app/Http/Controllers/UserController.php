<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

use Log;


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
        if ($id != Auth::id()){
            return redirect('/');
        }

        $user = User::findOrFail($id);

        return view('user/show', compact('user'));

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
        if ($id != Auth::id()){
            return redirect('/');
        }

        $user = User::findOrFail($id);

        return view('user/edit', compact('user'));
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
        if ($id != Auth::id()){
            return redirect('/');
        }

        $rules = [
            'name' => 'required|max:255',
            'detail' => 'nullable|max:1000'
        ];
        $validated = $request->validate($rules);

        $file = $request->file('avatar');
        if (!is_null($file)){
            $filename = sprintf('%s.%s', uniqid(), pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            $file->storeAs('public/avatar', $filename, ['disk'=>'s3', 'ACL' => 'public-read']);
            $url = Storage::disk('s3')->url('public/avatar/'.$filename);
            $validated['icon_path'] = $url;

            $user_data = User::findOrFail($id);
            if (!is_null($user_data['icon_path'])){
                $old_filename = pathinfo($user_data['icon_path'], PATHINFO_BASENAME);
                Storage::disk('s3')->delete('public/avatar/'.$old_filename);
            }
        }

        DB::beginTransaction();
        try{
            User::where('id', $id)->update($validated);
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = $e->getMessage();
            return redirect()->back()->withInput()->withErrors(['error' => $error_msg]);
        }

        return redirect(route('user.show', ['id' => $id]));

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

    public function token()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $user->tokens()->delete();

        $token = $user->createToken($user->name)->plainTextToken;

        return view('user/token', compact('token'));
    }
}
