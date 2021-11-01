<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerContour extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function farmer()
    {
      return $this->belongsTo(Farmer::class);
    }

    public function quality_indicators()
    {
      return $this->hasMany(QualityIndicator::class);
    }

    public function contour_histories()
    {
      return $this->hasMany(ContourHistory::class);
    }

    public static function findOrCreate($farmer_id, $contour_number, $crop_area)
    {
        $obj = static::where(['farmer_id' => $farmer_id, 'contour_number' => $contour_number])->first();
        $is_created = false;
        if ($obj == null)
        {
            $obj = new FarmerContour;
            $obj->farmer_id = $farmer_id;
            $obj->contour_number = $contour_number;
            $obj->crop_area = $crop_area;
            $obj->save();
            $is_created = true;
        }
        return ['id' => $obj->id, 'is_created' => $is_created];
    }
}
