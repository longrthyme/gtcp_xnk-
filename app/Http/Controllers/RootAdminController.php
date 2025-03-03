<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RootAdminController extends Controller
{
    public $templatePathAdmin;
    public function __construct()
    {
        $this->templatePathAdmin = 'admin::';
    }
}
