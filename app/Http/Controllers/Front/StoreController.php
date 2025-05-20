<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreController extends Controller
{
    public function index($subdomain)
    {
        dd(Store::whereSubdomain($subdomain)->first());
    }
}
