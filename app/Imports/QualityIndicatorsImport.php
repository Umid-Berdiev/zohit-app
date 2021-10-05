<?php

namespace App\Imports;

use App\Jobs\Admin\QualityIndicatorImport;
use App\Models\Admin\District;
use App\Models\Admin\Farmer;
use App\Models\Admin\FarmerContour;
use App\Models\Admin\Matrix;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class QualityIndicatorsImport implements ToCollection, SkipsOnError, WithHeadingRow, WithChunkReading, ShouldQueue
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

      dispatch(new QualityIndicatorImport($rows));
    }

    public function onError(Throwable $e)
    {
      // TODO: Implement onError() method.
    }

    public function chunkSize(): int
    {
      return 1000;
    }
}
