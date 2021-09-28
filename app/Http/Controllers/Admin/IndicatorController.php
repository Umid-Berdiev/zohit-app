<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\QualityIndicator;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
  public function index()
  {
    $response = QualityIndicator::with('region', 'district', 'matrix','farmerContour', 'farmer')->get();
    return view('pages/Admin/Indicator/index', compact('response'));
  }
}
