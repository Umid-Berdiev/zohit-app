<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TemplateHistoriesExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return [];
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
}
