<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContourHistoriesExport;
use App\Http\Controllers\Controller;
use App\Imports\ContourHistoriesImport;
use App\Models\Admin\ContourHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
{
    public function index()
    {
      $response = ContourHistory::with('region', 'district', 'matrix','farmerContour', 'farmer')->paginate(10);
      return view('pages/Admin/History/index', compact('response'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
          'import_file' => 'required'
        ]);
        Excel::import(new ContourHistoriesImport, request()->file('import_file'));

        return back()->with('success', 'Imported Successfully.');
    }

    public function exportExcel($type)
    {
      return \Excel::download(new ContourHistoriesExport, 'contour_histories.'.$type);
    }
}
