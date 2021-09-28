<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'arrays';

    public static function findOrCreate($id, $name)
    {
      $obj = Matrix::find($id);
      if ($obj == null)
      {
        $obj = new Matrix;
        $obj->id = $id;
        $obj->name = $name;
        $obj->save();
      }
      return $obj->id;
    }
}
