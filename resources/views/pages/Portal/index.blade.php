<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Smart Crop | Portal</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />

  <!-- ================== BEGIN BASE CSS STYLE ================== -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/default/app.min.css" rel="stylesheet" />
  <!-- ================== END BASE CSS STYLE ================== -->

  <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
  <link href="../assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="../assets/plugins/datatables.net-fixedcolumns-bs4/css/fixedcolumns.bootstrap4.min.css" rel="stylesheet" />
  <!-- ================== END PAGE LEVEL STYLE ================== -->
{{--  @yield('custom-styles')--}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>

  <style>
    #mapid {
      height: 600px;
    }
    .legend {
      line-height: 18px;
      color: #555;
    }
    .legend i {
      width: 18px;
      height: 18px;
      float: left;
      margin-right: 8px;
      opacity: 0.7;
    }
    .labelstyle {
      all: revert;
      color: green;
      /*font-size:14px;*/
      /*font-weight: 700;*/
      fillColor: none;
      fillOpacity: 0;
      background-color: none;
      border-color: none;
      background: none;
      border: none;
      box-shadow: none;
      margin: 0px;
      cursor: none;
      direction: 'center';
      interactive: false;
      fill: false;
    }
  </style>
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade show">
  <span class="spinner"></span>
</div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade in page-sidebar-fixed page-header-fixed">
  <!-- begin #header -->
  <div id="header" class="header navbar-default">
    <!-- begin navbar-header -->
    <div class="navbar-header">
      <a href="{{ route('admin.dashboard') }}" class="navbar-brand"><img src="{{ asset('assets/img/logo/crop.png') }}" height="50"> <b>Smart</b> Crop Портал</a>
      <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  </div>
  <!-- end #header -->
  <!-- begin #content -->
  <div id="content" class="content m-0">
    <!-- end breadcrumb -->
    <div class="panel panel-inverse">
      <!-- begin panel-heading -->
      <div class="panel-heading">
        <h4 class="panel-title">Фильтр</h4>
        <div class="panel-heading-btn">
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('portal.index') }}" class="form-group" method="get" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="region">Выбрать регион</label>
                <select name="region" id="region" class="form-control" required>
                  <option value="">Выбрать</option>
                  @foreach($region as $value)
                    <option value="{{$value->id}}" {{ request('region') == $value->id ? "selected" : "" }}>{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="district">Выбрать район</label>
                <select name="district" id="district" class="form-control" required>
                  <option value="">Выбрать</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="farmer">Выбрать фермера</label>
                <select name="farmer" id="farmer" class="form-control">
                  <option value="">Выбрать</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="crop">Выбрать тип урожая</label>
                <select name="crop" id="crop" class="form-control" required>
                  <option value="wheat"  {{ request('crop') == "wheat" ? "selected" : "" }}>G'alla</option>
                  <option value="cotton" {{ request('crop') == "cotton" ? "selected" : "" }}>Paxta</option>
                </select>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="ratio">Выбрать соотношение</label>
                <select name="ratio" id="ratio" class="form-control">
                  <option value="1" {{ request('ratio') == "1" ? "selected" : "" }}>1:1</option>
                  <option value="2" {{ request('ratio') == "2" ? "selected" : "" }}>2:1</option>
                  <option value="3" {{ request('ratio') == "3" ? "selected" : "" }}>3:1</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="region">Формат отображения</label>
                <select name="view_type" id="view_type" class="form-control">
                  <option value="table" {{ request('view_type') == "table" ? "selected" : "" }}>Таблица</option>
                  <option value="map" {{ request('view_type') == "map" ? "selected" : "" }}>Карта</option>
                </select>
              </div>
            </div>

{{--            <div class="col-xl-3 col-md-6">--}}
{{--              <div class="form-group">--}}
{{--                <label for="district">Threshold</label>--}}
{{--                <select name="threshold" id="threshold" class="form-control">--}}
{{--                  <option value="">Выберите</option>--}}
{{--                </select>--}}
{{--              </div>--}}
{{--            </div>--}}

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="area">Площадь</label>
                <input type="number" step="0.01" name="area" id="area" class="form-control" value="{{request('area')}}">
              </div>
            </div>

            <div class="col-xl-2 col-md-6">
              <div class="form-group">
                <label for="unit">Выбрать единство</label>
                <select name="unit" id="unit" class="form-control">
                  <option value="hectare" {{request('unit') == "hectare" ? "selected" : "" }}>га</option>
                  <option value="percent" {{request('unit') == "percent" ? "selected" : "" }}>%</option>
                </select>
              </div>
            </div>
            @yield('submit')
            <div class="col-xl-1 col-md-6 p-l-25">
              <button type="submit" class="btn btn-success" style="margin-top: 25px">
                Фильтр
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- begin row -->
    <div class="row">
      @if ($errors->any())
        <ul class="alert alert-danger mr-2">
          @foreach ($errors->all() as $error)
            <li >{{ $error }}</li>
          @endforeach
        </ul>
      @endif
      @if(Session::has('success'))
        <p class="alert {{ Session::get('alert-class', 'alert-success') }} col-xl-12">{{ Session::get('success') }}</p>
      @endif
      @if(request('view_type') == "table")
          @include('pages.Portal.table')
      @endif

      @if(request('view_type') == "map")
          @include('pages.Portal.map')
      @endif
    </div>
    <!-- end row -->

  </div>
  <!-- end #content -->

  <!-- begin scroll to top btn -->
  <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
  <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="../assets/js/app.min.js"></script>
<script src="../assets/js/theme/default.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="../assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables.net-fixedcolumns/js/dataTables.fixedcolumns.min.js"></script>
<script src="../assets/plugins/datatables.net-fixedcolumns-bs4/js/fixedcolumns.bootstrap4.min.js"></script>
<script>
  if ($('#data-table-fixed-columns').length !== 0) {
    $('#data-table-fixed-columns').DataTable({
      scrollY:        400,
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      fixedColumns:   true,
      info:           false,
      searching:      false,
    });
  }
</script>
<script>
  function getDistricts(check, region_id) {
    console.log(region_id)
    if (region_id) {
      $.ajax({
        url: "{{ url('admin/basic/districts') }}/"+region_id,
        type: "GET",
        dataType: "json",
        success: function(data){
          $('select[name="district"]').empty();
          if (check) {
            $('select[name="district"]').append('<option value="">Выбрать</option>');
            $.each(data,function(key,value){
              $('select[name="district"]').append('<option value="'+value.id+'">'+value.name+'</option>');
            });
          }
          else {
            let district_id = @json(old('district'), JSON_UNESCAPED_UNICODE);
            $('select[name="district"]').append('<option value="">Выбрать</option>');
            $.each(data, function (key, value) {
              let selected = district_id == value.id ? 'selected': '';
              $("select[name='district']").append("<option value='" + value.id + "'" +selected+">" + value.name + "</option>");
            });
          }
        }
      });
    }else {
      $('select[name="district"]').empty();
    }
  }
  function getFarmers(check, district_id) {
    if (district_id) {
      $.ajax({
        url: "{{ url('admin/farmers/list') }}/"+district_id,
        type: "GET",
        dataType: "json",
        success: function(data){
          $('select[name="farmer"]').empty();

          if (check) {
            $('select[name="farmer"]').append('<option value="">Выбрать</option>');
            $.each(data,function(key,value){
              $('select[name="farmer"]').append('<option value="'+value.id+'">'+value.name+' - '+value.crop_area+' (га)</option>');
            });
          }
          else {
            let farmer_id = @json(old('farmer'), JSON_UNESCAPED_UNICODE);
            $('select[name="farmer"]').append('<option value="">Выбрать</option>');
            $.each(data, function (key, value) {
              let selected = farmer_id == value.id ? 'selected': '';
              $("select[name='farmer']").append("<option value='" + value.id + "'" +selected+">" + value.name + " - " +value.crop_area+ "</option>");
            });
          }
        }
      });
    }else {
      $('select[name="farmer"]').empty();
    }
  }
</script>
<script>
  $(document).ready(function(){

    $('select[name="district"]').bind('change',function(){
      getFarmers(true, $(this).val())
    });

    $('select[name="region"]').bind('change',function(){
      getDistricts(true, $(this).val());
    });
  });
</script>
@if(old('district'))
  <script>
    $(document).ready(function() {
      getDistricts(false, @json(old('region'), JSON_UNESCAPED_UNICODE))
    });
  </script>
@endif

@if(old('farmer') or old('district'))
  <script>
    $(document).ready(function() {
      getFarmers(false, @json(old('district'), JSON_UNESCAPED_UNICODE))
    });
  </script>
@endif

<script>
  $(document).ready(function() {
    jQuery('.import-button').click(function() {
      $( "body" ).append("<div id='page-loader' class='fade show'><span class='spinner'></span></div>")
    });
  });
</script>

@yield('vue-scripts')
<!-- ================== END PAGE LEVEL JS ================== -->
</body>
</html>
