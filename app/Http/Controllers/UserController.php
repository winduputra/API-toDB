<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }

    public function list()
    {
        $users  = User::orderBy('id', 'desc')->get();
        return view('user.list', compact('users'));
    }

    public function formAdd()
    {
        return view('user.add');
    }

    public function add()
    {
        $this->validate($this->request, [
            'name'  => ['required'],
            'username'  => ['required', 'unique:users'],
            'password'  => ['required'],
            'role_id'   => ['required'],
        ]);

        $payloads   = $this->request->only(['name', 'username', 'password', 'role_id']);
        $payloads['password']   = bcrypt($payloads['password']);
        if( !isset($payloads['role_id']) ) {
            $payloads['role_id'] = 2;
        }

        $user       = User::create($payloads);

        return redirect( route('user.list') )->with('success', 'Tambah User');
    }

    public function formUpdate($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update($id)
    {
        $user   = User::find($id);

        $this->validate($this->request, [
            'name'  => ['required'],
            'username'  => ['required'],
            'role_id'   => ['required'],
        ]);

        if( $this->request->username != $user->username ) {
            $exist  = User::where('username', 'like', $this->request->username)->first();
            if( $exist ) {
                return redirect( route('user.update', ['id' => $id]) )->withErrors(['username' => 'Username \'' . $this->request->username . '\' sudah digunakan']);
            }
        }

        $payloads   = $this->request->only(['name', 'nip', 'username', 'group_id', 'rank_id', 'position_id', 'role_id']);

        if( $this->request->password ) {
            $payloads['password']   = bcrypt($this->request->password);
        }

        $user->update($payloads);

        $user   = $user->refresh();

        return redirect( route('user.list') )->with('success', 'Berhasil Update ' . $user->name);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('user.list'))->with('success', 'Hapus User');
    }
}
