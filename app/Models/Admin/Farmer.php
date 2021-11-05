<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Farmer extends Model
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

    public function contours()
    {
      return $this->hasMany(FarmerContour::class);
    }

    public function quality_indicators()
    {
      return $this->contours()->with('quality_indicators');
    }

    public function contour_histories()
    {
      return $this->contours()->with('contour_histories');
    }

    public static function findOrCreate($farmer_id, $farmer_name, $crop_area, $region_id, $district_id, $contour_number)
    {
      $obj = static::find($farmer_id);
      if ($obj == null)
      {
        $obj = new Farmer;
        $obj->id = $farmer_id;
        $obj->name = $farmer_name;
        $obj->crop_area = $crop_area;
        $obj->region_id = $region_id;
        $obj->district_id = $district_id;
        $obj->save();
      }
      elseif (FarmerContour::where(['farmer_id' => $farmer_id, 'contour_number' => $contour_number])->first() == null)
      {
        $obj->update(['crop_area' => $obj->crop_area+$crop_area, 'name' => $farmer_name]);
      }
      return $obj->id;
    }

    public static function updateName($id, $name)
    {
      $farmer = Farmer::find($id);
      $farmer->update(['name' => $name]);
    }

    public static function destroyFarmer($id)
    {
      $farmer = Farmer::find($id);
      $farmer->delete();
    }

    public static function getPortalInfo()
    {
      $crops = [
        'cotton' => "Paxta",
        'wheat' => "G'alla",
        '' => 'null'
      ];

      $crop = $crops[request('crop')];
      $farmer_id = request('farmer');
      $ratio = request('ratio');
      $year = date("Y",strtotime("-".$ratio." year"));

      // Barcha kerakli ma'lumotlarni bazadan olish ($ratio ga qarab yillar soni o'zgaradi)
      $farmer =   DB::select(
        "select farmers.id, farmers.crop_area as total_area, r.name as region, d.name as district, farmers.name as farmer, farmers.region_id, farmers.district_id, ch.array_id,
        fc.contour_number, fc.crop_area, ch.year, ch.crop_name, st_asgeojson(ash.geometry) as geometry,
        (select quality_indicator from quality_indicators qi where qi.year = (date_part('year', CURRENT_DATE)-1) and fc.id = qi.farmer_contour_id)
        from farmers
        left join districts d on d.id = farmers.district_id
        left join regions r on r.id = farmers.region_id
        left join farmer_contours fc on farmers.id = fc.farmer_id
        left join contour_histories ch on fc.id = ch.farmer_contour_id
        left join area_shapes ash on fc.contour_number = ash.contour_number
        where farmers.id = $farmer_id and ch.year >= $year
        order by quality_indicator desc, ch.year"
      );

      $response=[];
      $contours=[];
      $total_area=0;

      foreach ($farmer as $item)
      {
        $contours[$item->contour_number]['properties'] = [
          'id' => $item->id,
          'region' => $item->region,
          'district' => $item->district,
          'farmer' => $item->farmer,
          'contour_number' => $item->contour_number,
          'crop_area' => $item->crop_area,
          'crop_name' => $item->crop_name,
          'quality_indicator' => $item->quality_indicator,
          'color' => self::setColor($item->quality_indicator),
        ];
        $contours[$item->contour_number]['crops'][$item->year] =  $item->crop_name;
        $contours[$item->contour_number]['geometry'] = json_decode($item->geometry);
        $contours[$item->contour_number]['type'] = 'Feature';
        $total_area = $item->total_area;
      }

      $area=0;
      $required_area = request('area');
      if (request('unit')=='percent' and $required_area!=null){
        $required_area = ($total_area * request('area'))/100;
      }

      // Ekin turiga tekshirish
      foreach ($contours as $key => $item)
      {
        $crop_names = array_count_values($item['crops']);
        if (isset($crop_names[$crop])){
            if ($crop_names[$crop]<request('ratio')){
              $response[$key]=$item;
              $area += $item['properties']['crop_area'];
            }
        }
        else{
          $response[$key]=$item;
          $area += $item['properties']['crop_area'];
        }
        if ($area>=$required_area and $required_area!=null){
          break;
        }
      }
      return ["type" => "FeatureCollection", 'features' => array_values($response), 'required_area' => $area, 'total_area' => $total_area];

    }

    public static function setColor($indicator)
    {
      switch ($indicator)
      {
        case ($indicator>=80): return 'green'; break;
        case ($indicator>=60): return 'orange'; break;
        case ($indicator>=40): return 'yellow'; break;
        default: return 'red';
      }
    }
}
