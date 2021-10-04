<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContourHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function region()
    {
      return $this->belongsTo(Region::class);
    }

    public function district()
    {
      return $this->belongsTo(District::class);
    }

    public function matrix()
    {
      return $this->belongsTo(Matrix::class, 'array_id');
    }

    public function farmerContour()
    {
      return $this->belongsTo(FarmerContour::class);
    }

    public function farmer()
    {
      return $this->farmerContour()->with('farmer');
    }

    public static function findOrCreate($region_id, $district_id, $array_id, $farmer_contour_id, $year, $crop_name)
    {
        $obj = ContourHistory::where(['region_id' => $region_id, 'district_id' => $district_id, 'array_id' => $array_id, 'farmer_contour_id' => $farmer_contour_id, 'year' => $year])->first();
        if ($obj == null){
          $obj = new ContourHistory;
        }
        $obj->region_id = $region_id;
        $obj->district_id = $district_id;
        $obj->array_id = $array_id;
        $obj->farmer_contour_id = $farmer_contour_id;
        $obj->year = $year;
        $obj->crop_name = $crop_name;
        $obj->save();
    }

    public static function filterResponse($response)
    {
      if(request('region')) {
        $response->where('region_id', request('region'));
      }
      if(request('district')) {
        $response->where('district_id', request('district'));
      }
      if(request('farmer')) {
        $response->whereHas('farmerContour', function($q)
        {
          $q->where('farmer_id', request('farmer'));
        });
      }
      if(request('year')) {
        $response->where('year', request('year'));
      }
      return $response;
    }

    public static function getHistories()
    {
      $response = ContourHistory::with('region', 'district', 'matrix','farmerContour', 'farmer');
      $response = ContourHistory::filterResponse($response);
      return $response->paginate(50);
    }
}
