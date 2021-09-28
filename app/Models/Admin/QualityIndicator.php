<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class QualityIndicator extends Model
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
}
