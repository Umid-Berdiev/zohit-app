<?php

namespace App\Imports;

use App\Models\Admin\District;
use App\Models\Admin\Farmer;
use App\Models\Admin\FarmerContour;
use App\Models\Admin\Matrix;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Throwable;

class QualityIndicatorsImport implements ToModel, SkipsOnError
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      if (count($row)==12) {
        $farmer_contour = FarmerContour::findOrCreate($row[7], $row[8], $row[9]);
        if ($farmer_contour['is_created'])
        {
          Farmer::findOrCreate($row[7], $row[6], $row[9], $row[1], $row[3]);
        }
        Matrix::findOrCreate($row[5], $row[4]);
        Region::findOrCreate($row[1], $row[0]);
        District::findOrCreate($row[3], $row[2], $row[1]);

        return new QualityIndicator([
          'region_id' => $row[1],
          'district_id' => $row[3],
          'array_id' => $row[5],
          'farmer_contour_id' => $farmer_contour['id'],
          'year' => $row[10],
          'quality_indicator' => $row[11]
        ]);
      }
    }

    public function onError(Throwable $e)
    {
      // TODO: Implement onError() method.
    }
}
