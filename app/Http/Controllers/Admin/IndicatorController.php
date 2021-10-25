<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QualityIndicatorsExport;
use App\Exports\TemplateIndicatorsExport;
use App\Http\Controllers\Controller;
use App\Imports\QualityIndicatorsImport;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class IndicatorController extends Controller
{

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
   */
  public function index()
  {
    $region = Region::all();
    $response = QualityIndicator::getIndicators();
    return view('pages/Admin/Indicator/index', compact('response', 'region'));
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function importExcel(Request $request)
  {
    $request->validate([
      'import_file' => 'required'
    ]);
    Excel::queueImport(new QualityIndicatorsImport, request()->file('import_file'));
    Session::flash('success','Успешно прошла валидацию! Данные скоро будут импортированы.');
    return back();
  }

  /**
   * @param $type
   * @return mixed
   */
  public function exportExcel($type)
  {
    return \Excel::download(new QualityIndicatorsExport, 'quality_indicator.'.$type);
  }

  /**
   * @param $type
   * @return mixed
   */
  public function templateExportExcel($type)
  {
    return \Excel::download(new TemplateIndicatorsExport, 'quality_indicator.'.$type);
  }
}
