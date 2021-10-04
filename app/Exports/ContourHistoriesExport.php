<?php

namespace App\Exports;

use App\Models\Admin\ContourHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContourHistoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ContourHistory::with('region', 'district', 'matrix','farmerContour', 'farmer')->get();
    }

    public function headings(): array
    {
        return [
          'Region',
          'Region ID',
          'District',
          'District ID',
          'Massiv',
          'Massiv ID',
          'Farmer',
          'Farmer ID',
          'Contour number',
          'Crop area',
          'Year',
          'Crop name'
        ];
    }

    public function map($history): array
    {
        return [
          $history->region->name,
          $history->region->id,
          $history->district->name,
          $history->district->id,
          $history->matrix->name,
          $history->matrix->id,
          $history->farmer->farmer->name,
          $history->farmer->farmer->id,
          $history->farmerContour->contour_number,
          $history->farmerContour->crop_area,
          $history->year,
          $history->crop_name
        ];
    }
}
