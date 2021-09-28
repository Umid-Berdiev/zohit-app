<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function region()
    {
      return $this->belongsTo(Region::class);
    }

    public static function findOrCreate($id, $name, $region_id)
    {
      $obj = District::find($id);
      if ($obj == null)
      {
        $obj = new District;
        $obj->id = $id;
        $obj->name = $name;
        $obj->region_id = $region_id;
        $obj->save();
      }
      return $obj->id;
    }
}
