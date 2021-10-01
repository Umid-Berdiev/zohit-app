<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QualityIndicatorsExport;
use App\Http\Controllers\Controller;
use App\Imports\QualityIndicatorsImport;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IndicatorController extends Controller
{
  public function index()
  {
    $region = Region::all();
    $response = QualityIndicator::getIndicators();
    return view('pages/Admin/Indicator/index', compact('response', 'region'));
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'import_file' => 'required'
    ]);
    Excel::import(new QualityIndicatorsImport, request()->file('import_file'));

    return back()->with('success', 'Imported Successfully.');
  }

  public function exportExcel($type)
  {
    return \Excel::download(new QualityIndicatorsExport, 'quality_indicator.'.$type);
  }
}
