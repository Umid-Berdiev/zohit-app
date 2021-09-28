<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ContourHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
  public function index()
  {
    $response = ContourHistory::with('region', 'district', 'matrix','farmerContour', 'farmer')->get();
    return view('pages/Admin/History/index', compact('response'));
  }
}
