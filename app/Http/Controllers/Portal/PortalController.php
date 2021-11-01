<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Admin\ContourHistory;
use App\Models\Admin\Farmer;
use App\Models\Admin\Region;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {
      $response = Farmer::getPortalInfo();
      $region = Region::all();
      return view('pages/Portal/index', compact('response', 'region'));
    }
}
