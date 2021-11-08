<?php

namespace App\Exports;

use App\Models\Admin\Farmer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PortalExport implements FromArray, WithMapping,  WithHeadings, ShouldAutoSize, WithTitle
{
  public $request;
  public function __construct($request)
  {
    $this->request = $request;
  }

  public function array(): array
  {
    return Farmer::getPortalInfo($this->request)['features'];
  }

  public function headings(): array
  {
    return [
      'Область',
      'Район',
      'Фермер',
      'Номер контура',
      'Площадь посева',
      'Показатели качества прошлого года',
      'Урожай',
    ];
  }

  public function map($data): array
  {
    return [
      $data['properties']['region'],
      $data['properties']['district'],
      $data['properties']['farmer'],
      $data['properties']['contour_number'],
      $data['properties']['crop_area'],
      $data['properties']['quality_indicator'],
      $data['crops'],
    ];
  }

  public function title(): string
  {
    $crops = [
      'cotton' => "Paxta",
      'wheat' => "G'alla",
      '' => 'null'
    ];
    return $crops[$this->request['crop']];
  }
}
