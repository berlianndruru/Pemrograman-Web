<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    private $User;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $token = session('token');
            $user = User::query()->where('token', $token)->first();
            if ($user == null) {
                return redirect()->route('login');
            }
            #$token ada
            $this->User = $user;
            return $next($request);
        });
    }

    public function getUserId()
    {
        return $this->User->id;
    }

    public function getUserEmail()
    {
        return $this->User->email;
    }

    public function getUserRole()
    {
        return $this->User->role;
    }

    public function superadminOnly()
    {

        if ($this->User->role != 'superadmin') {
            abort(403);
        }
    }

    public function adminAndSuperAdminOnly()
    {
        if ($this->User->role != 'superadmin' && $this->User->role != 'admin') {
            abort(403);
        }
    }
}