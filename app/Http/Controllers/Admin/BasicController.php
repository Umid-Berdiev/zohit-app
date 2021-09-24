<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasicController extends Controller
{
  public function getRegions()
  {
    return view('pages/Admin/Basic/Region/index');
  }

  public function getDistricts()
  {
    return view('pages/Admin/Basic/District/index');
  }
}
