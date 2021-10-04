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

  public function show(Farmer $farmer)
  {
      $response = Farmer::where('id', $farmer->id)->with('region', 'district', 'contours')->first();
      return view('pages/Admin/Farmer/show', compact('response'));
  }

  public function update(Request $request)
  {
    Farmer::updateName($request->get('id'), $request->get('name'));
    return back();
  }

  public function destroy(Request $request)
  {
    Farmer::destroyFarmer($request->get('id'));
    return back();
  }

  public function getFarmerList($district)
  {
    $response = Farmer::where('district_id', $district)->get();
    return $response;
  }
}
