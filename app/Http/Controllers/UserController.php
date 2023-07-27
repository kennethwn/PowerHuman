<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index(Request $request, $id) {
        return "ini user: " . $id;
    }

    public function findNameByCurrentUser(Request $request) {
        return 'John Doe';
    }
}
