<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaShape extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $postgisFields = [
      'geometry',
    ];

    protected $postgisTypes = [
      'geometry' => [
        'geomtype' => 'geography',
        'srid' => 4326
      ],
    ];

    public function farmer()
    {
      return $this->belongsToMany(Farmer::class, 'farmer_contours', 'contour_number','farmer_id', 'contour_number');
    }

    public function crop_area()
    {
      return $this->belongsTo(FarmerContour::class, 'contour_number', 'contour_number');
    }
}
