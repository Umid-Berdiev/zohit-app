<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
  /**
   * Farmer list
   *
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function index()
  {
    $response = Farmer::with('region', 'district')->get();
    return view('pages/Admin/Farmer/index', compact('response'));
  }

  public function show()
  {
    $response = Farmer::with('region', 'district', 'contours')->get();
    return view('pages/Admin/Farmer/show', compact('response'));
  }
}
