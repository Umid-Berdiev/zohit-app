<?php

namespace App\Imports;

use App\Jobs\Admin\QualityIndicatorImport;
use App\Models\Admin\District;
use App\Models\Admin\Farmer;
use App\Models\Admin\FarmerContour;
use App\Models\Admin\Matrix;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class QualityIndicatorsImport implements ToCollection, SkipsOnError, WithHeadingRow
{
  /**
   * @param Collection $rows
   * @return QualityIndicator|void
   * @throws \Illuminate\Validation\ValidationException
   */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.region' => 'required',
            '*.region_id' => 'required|integer',
            '*.district' => 'required',
            '*.district_id' => 'required|integer',
            '*.massiv' => 'required',
            '*.massiv_id' => 'required|integer',
            '*.farmer' => 'required',
            '*.farmer_id' => 'required|integer',
            '*.contour_number' => 'required|integer',
            '*.crop_area' => 'required|numeric',
            '*.year' => 'required|date_format:Y',
            '*.quality_indicator' => 'required',
        ])->validate();

        QualityIndicatorImport::dispatch($rows)->delay(now()->addSeconds(5));;
//        foreach ($rows as $row) {
//            $farmer_contour = FarmerContour::findOrCreate($row['farmer_id'], $row['contour_number'], $row['crop_area']);
//            if ($farmer_contour['is_created'])
//            {
//              Farmer::findOrCreate($row['farmer_id'], $row['farmer'], $row['crop_area'], $row['region_id'], $row['district_id']);
//            }
//            Matrix::findOrCreate($row['massiv_id'], $row['massiv']);
//            Region::findOrCreate($row['region_id'], $row['region']);
//            District::findOrCreate($row['district_id'], $row['district'], $row['region_id']);
//            QualityIndicator::findOrCreate($row['region_id'], $row['district_id'], $row['massiv_id'], $farmer_contour['id'], $row['year'], $row['quality_indicator']);
//        }
    }

    public function onError(Throwable $e)
    {
      // TODO: Implement onError() method.
    }
}
