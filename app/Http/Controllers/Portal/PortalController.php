<?php

namespace App\Http\Controllers\Portal;

use App\Exports\PortalExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContourHistory;
use App\Models\Admin\Farmer;
use App\Models\Admin\Region;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PortalController extends Controller
{
    public function index(Request $request)
    {
      $request->flash();
      $response = [];
      if (\request('district')){
        $response = Farmer::getPortalInfo($request->all());
      }
//      if (\request('view_type')=='table')
//      {
//        $response = $this->paginate(Farmer::getPortalInfo()['features'],50);
//      }
      $region = Region::all();
      return view('pages/Portal/index', compact('response', 'region'));
    }


    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

  public function exportExcel(Request $request, $type)
  {
    $data = $request->data;
    $data['farmer'] = $data['farmer'] ?? null;
    $data['area'] = $data['area'] ?? null;
    return \Excel::download(new PortalExport($data), 'portal.'.$type);
  }
}
