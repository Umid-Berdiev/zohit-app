<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContourHistoriesExport;
use App\Exports\TemplateHistoriesExport;
use App\Http\Controllers\Controller;
use App\Imports\ContourHistoriesImport;
use App\Models\Admin\ContourHistory;
use App\Models\Admin\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
{
    public function index()
    {
      $response = ContourHistory::getHistories();
      $region = Region::all();
      return view('pages/Admin/History/index', compact('response', 'region'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
          'import_file' => 'required'
        ]);
      Excel::import(new ContourHistoriesImport, request()->file('import_file'));
      Session::flash('success','Успешно импорт');
      return back();
    }

    public function exportExcel($type)
    {
      return \Excel::download(new ContourHistoriesExport, 'contour_histories.'.$type);
    }

    public function templateExportExcel($type)
    {
      return \Excel::download(new TemplateHistoriesExport, 'contour_histories.'.$type);
    }
}
