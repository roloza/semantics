<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(50);
        return view('pages.admin.users.index', ['users' => $users]);
    }
}