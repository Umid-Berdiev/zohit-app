<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerContour extends Model
{
    use HasFactory;

    public function farmer()
    {
      return $this->belongsTo(Farmer::class);
    }
}
