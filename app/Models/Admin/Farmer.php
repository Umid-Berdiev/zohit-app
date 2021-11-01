<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Farmer extends Model
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

    public function contours()
    {
      return $this->hasMany(FarmerContour::class);
    }

    public function quality_indicators()
    {
      return $this->contours()->with('quality_indicators');
    }

    public function contour_histories()
    {
      return $this->contours()->with('contour_histories');
    }

    public static function findOrCreate($farmer_id, $farmer_name, $crop_area, $region_id, $district_id, $contour_number)
    {
      $obj = static::find($farmer_id);
      if ($obj == null)
      {
        $obj = new Farmer;
        $obj->id = $farmer_id;
        $obj->name = $farmer_name;
        $obj->crop_area = $crop_area;
        $obj->region_id = $region_id;
        $obj->district_id = $district_id;
        $obj->save();
      }
      elseif (FarmerContour::where(['farmer_id' => $farmer_id, 'contour_number' => $contour_number])->first() == null)
      {
        $obj->update(['crop_area' => $obj->crop_area+$crop_area, 'name' => $farmer_name]);
      }
      return $obj->id;
    }

    public static function updateName($id, $name)
    {
      $farmer = Farmer::find($id);
      $farmer->update(['name' => $name]);
    }

    public static function destroyFarmer($id)
    {
      $farmer = Farmer::find($id);
      $farmer->delete();
    }

    public static function getPortalInfo()
    {
      $crops = [
        'cotton' => "Paxta",
        'wheat' => "G'alla"
      ];
      $crop = $crops[request('crop')];
      $farmer_id = request('farmer');
      $farmer =   DB::select(
        "select farmers.id, r.name as region, d.name as district, farmers.name as farmer, farmers.region_id, farmers.district_id, ch.array_id,
        fc.contour_number, fc.crop_area, ch.year, ch.crop_name, ash.geometry
        from farmers
        left join districts d on d.id = farmers.district_id
        left join regions r on r.id = farmers.region_id
        left join farmer_contours fc on farmers.id = fc.farmer_id
        left join contour_histories ch on fc.id = ch.farmer_contour_id
        left join area_shapes ash on fc.contour_number = ash.contour_number
        where farmers.id = $farmer_id
        order by ch.year desc"
      );
      $year = [
        'one' => date("Y",strtotime("-1 year")),
        'two' => date("Y",strtotime("-2 year")),
        'three' => date("Y",strtotime("-3 year"))
      ];
//      foreach ($farmer as $item)
//      {
//        if (request('ratio') == "one"){
//          if ($item->year >= $year[request('ratio')]){
//
//          }
//        }
//      }
      return $farmer;

//      $farmer = Farmer::where('id', request('farmer'));
//      if (request('ratio') == 'one'){
//        $farmer->whereHas('contour_histories', function($q) use($crop) {
//          $q->whereHas('contour_histories', function($q) use($crop) {
//            $q->where('crop_name', '!=', $crop)
//              ->where('year', date("Y",strtotime("-1 year")));
//          });
//        });
//      }
    }
}
