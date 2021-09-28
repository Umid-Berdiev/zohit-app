<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QualityIndicatorsExport;
use App\Http\Controllers\Controller;
use App\Imports\QualityIndicatorsImport;
use App\Models\Admin\QualityIndicator;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
  public function index()
  {
    $response = QualityIndicator::with('region', 'district', 'matrix','farmerContour', 'farmer')->get();
    return view('pages/Admin/Indicator/index', compact('response'));
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'import_file' => 'required'
    ]);
    \Excel::import(new QualityIndicatorsImport,$request->import_file);

    \Session::put('success', 'Your file is imported successfully in database.');

    return back();
  }

  public function exportExcel($type)
  {
    return \Excel::download(new QualityIndicatorsExport, 'quality_indicator.'.$type);
  }
}
