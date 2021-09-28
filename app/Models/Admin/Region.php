<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function findOrCreate($id, $name)
    {
      $obj = Region::find($id);
      if ($obj == null)
      {
        $obj = new Region;
        $obj->id = $id;
        $obj->name = $name;
        $obj->save();
      }
      return $obj->id;
    }
}
