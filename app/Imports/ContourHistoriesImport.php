<?php

namespace App\Imports;

use App\Jobs\Admin\ContourHistoryJob;
use App\Models\Admin\ContourHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;


class ContourHistoriesImport implements ToCollection, SkipsOnError, WithHeadingRow
{
    /**
     * @param Collection $rows
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
          '*.crop_name' => 'required',
        ])->validate();
        ContourHistoryJob::dispatch($rows);
    }

    public function onError(Throwable $e)
    {
      // TODO: Implement onError() method.
    }
}
