<?php

namespace App\Jobs\Admin;

use App\Models\Admin\District;
use App\Models\Admin\Farmer;
use App\Models\Admin\FarmerContour;
use App\Models\Admin\Matrix;
use App\Models\Admin\QualityIndicator;
use App\Models\Admin\Region;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QualityIndicatorImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rows;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      foreach ($this->rows as $row) {
        $farmer_contour = FarmerContour::findOrCreate($row['farmer_id'], $row['contour_number'], $row['crop_area']);
        if ($farmer_contour['is_created'])
        {
          Farmer::findOrCreate($row['farmer_id'], $row['farmer'], $row['crop_area'], $row['region_id'], $row['district_id']);
        }
        Matrix::findOrCreate($row['massiv_id'], $row['massiv']);
        Region::findOrCreate($row['region_id'], $row['region']);
        District::findOrCreate($row['district_id'], $row['district'], $row['region_id']);
        QualityIndicator::findOrCreate($row['region_id'], $row['district_id'], $row['massiv_id'], $farmer_contour['id'], $row['year'], $row['quality_indicator']);
      }
    }
}
