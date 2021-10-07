<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AreaShape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Shapefile\ShapefileReader;
use ZipArchive;

class ShapefileController extends Controller
{
    public function index()
    {
      $response = AreaShape::with('farmer', 'crop_area')->paginate(50);
      return view('pages/Admin/Shapefile/index', compact('response'));
    }

    public function importShapeFile(Request $request)
    {
        $request->validate([
          'import_file' => 'required'
        ]);
        $file = $request->file('import_file');
        try {
          $zip = new ZipArchive;
          $zip->open($file);
          $zip->extractTo(public_path('/zip'));
          $filename = str_replace('.zip', '', $file->getClientOriginalName());
          $files = scandir(public_path('zip/' . $filename));
          $hasShapefile = false;
          foreach ($files as $item) {
            if (strpos($item, '.shp') !== false && strpos($item, '.shp.') !== true) {
              $shpfile = $item;
              $hasShapefile = true;
              break;
            }
          }
          if ($hasShapefile) {
            $shapefile = new ShapefileReader(public_path('zip/' . $filename . '/' . $shpfile));
            // Read all the records
            while ($geometry = $shapefile->fetchRecord()) {
              // Skip the record if marked as "deleted"
              if ($geometry->isDeleted()) {
                continue;
              }
  //            dd($geometry);
              $geom = $geometry->getWKT();
  //            $geom = str_replace(' 0 0,', ',', $geom);
  //            $geom = str_replace(' 0 0)', ')', $geom);
  //            $geom = str_replace('ZM', '', $geom);
              $raw = DB::connection('pgsql')
                ->select("SELECT ST_AsText(ST_Multi(ST_GeomFromText('$geom')));");
              $geom = $raw[0]->st_astext;
  //            $raw = DB::connection('pgsql')->select("
  //                              SELECT ST_AsText(ST_Transform(ST_GeomFromText('$geom',2597),4326)) As wgs_geom;
  //                              ");
  //            $geom = $raw[0]->wgs_geom;
  //            dd($geom);
              $data = $geometry->getDataArray();
              $model = AreaShape::firstOrNew([
                'contour_number' => (int) $data['KONTUR_RAQ']
              ]);
              $model->geometry = $geom;
              $model->shape_leng = (float) $data['SHAPE_LENG'];
              $model->shape_area = (float) $data['SHAPE_AREA'];
              $model->save();
            }
            File::deleteDirectory(public_path("zip/$filename"));
            Session::flash('success','Успешно импортировано.');
            return back();
          } else {
            Session::flash('danger','Shape файл не найден.');
            return back();
          }
        } catch (Throwable $e) {
          File::deleteDirectory(public_path("zip/$filename"));
          return $e->getMessage() . " Kadastr raqamlari to'g'ri ekanini tekshiring";
        }
    }
}
