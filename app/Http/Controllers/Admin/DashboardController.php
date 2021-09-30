<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\District;
use App\Models\Admin\Farmer;
use App\Models\Admin\FarmerContour;
use App\Models\Admin\Region;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
      $farmer = Farmer::all()->count();
      $farmer_contour = FarmerContour::all();
      $contour = $farmer_contour->count();
      $crop_area = $farmer_contour->sum('crop_area');
      return view('pages/Admin/Dashboard/dashboard-v2', compact('farmer', 'contour', 'crop_area'));
    }
}
