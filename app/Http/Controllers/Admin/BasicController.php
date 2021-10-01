<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\District;
use App\Models\Admin\Matrix;
use App\Models\Admin\Region;
use Illuminate\Http\Request;

class BasicController extends Controller
{
  public function getRegions()
  {
    $response = Region::all();
    return view('pages/Admin/Basic/Region/index', compact('response'));
  }

  public function getDistricts()
  {
    $response = District::with('region')->get();
    return view('pages/Admin/Basic/District/index', compact('response'));
  }

  public function getMatrix()
  {
    $response = Matrix::with('district')->get();
    return view('pages/Admin/Basic/Matrix/index', compact('response'));
  }

  public function getDistrictList($region)
  {
    $response = District::where('region_id', $region)->get();
    return $response;
  }
}
