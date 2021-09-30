<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
