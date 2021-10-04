<?php

namespace App\Exports;

use App\Models\Admin\QualityIndicator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QualityIndicatorsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return QualityIndicator::with('region', 'district', 'matrix','farmerContour', 'farmer')->get();
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
        'Quality indicator'
      ];
    }

    public function map($quality_indicator): array
    {
      return [
        $quality_indicator->region->name,
        $quality_indicator->region->id,
        $quality_indicator->district->name,
        $quality_indicator->district->id,
        $quality_indicator->matrix->name,
        $quality_indicator->matrix->id,
        $quality_indicator->farmer->farmer->name,
        $quality_indicator->farmer->farmer->id,
        $quality_indicator->farmerContour->contour_number,
        $quality_indicator->farmerContour->crop_area,
        $quality_indicator->year,
        $quality_indicator->quality_indicator
      ];
    }
}
