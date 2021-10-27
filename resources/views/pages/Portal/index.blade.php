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
        <h4 class="panel-title">Филтр</h4>
        <div class="panel-heading-btn">
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('portal.index') }}" class="form-group" method="get" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="region">Выберите регион</label>
                <select name="region" id="region" class="form-control">
                  <option value="">Выберите</option>
                  @foreach($region as $value)
                    <option value="{{$value->id}}" {{ $value->id == request('region') ? "selected" : "" }}>{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="district">Выберите район</label>
                <select name="district" id="district" class="form-control">
                  <option value="">Выберите</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="farmer">Выберите фермер</label>
                <select name="farmer" id="farmer" class="form-control">
                  <option value="">Выберите</option>
                </select>
              </div>
            </div>

            <?php $years = range(strftime("%Y", time()), 2000); ?>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="year">Выберите соотношение</label>
                <select name="year" id="year" class="form-control">
                  <option value="">Выберите</option>
                  <option value="">1:1</option>
                  <option value="">2:1</option>
                  <option value="">3:1</option>
                </select>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="region">Формат отображения</label>
                <select name="view_type" id="view_type" class="form-control">
                  <option value="table">Таблица</option>
                  <option value="map">Карта</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="district">Threshold</label>
                <select name="threshold" id="threshold" class="form-control">
                  <option value="">Выберите</option>
                </select>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="form-group">
                <label for="farmer">Выберите площадь</label>
                <select name="area" id="area" class="form-control">
                  <option value="">Выберите</option>
                </select>
              </div>
            </div>

            <?php $years = range(strftime("%Y", time()), 2000); ?>

            <div class="col-xl-2 col-md-6">
              <div class="form-group">
                <label for="year">Выберите год</label>
                <select name="year" id="year" class="form-control">
                  <option value="">Выберите</option>
                  @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year == request('year') ? "selected" : "" }}>{{ $year }}</option>
                  @endforeach
                </select>
              </div>
            </div>

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
    <!-- begin col-10 -->
      <div class="col-xl-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
          <!-- begin panel-heading -->
          <div class="panel-heading">
            <h4 class="panel-title">Ежегодная история контуров</h4>
{{--            <a href="{{ route('admin.history.template-export', ['type' => 'xlsx']) }}" class="btn btn-xs btn-success mr-3">--}}
{{--              <i class="fa fa-file-export"></i> Шаблон Export--}}
{{--            </a>--}}
{{--            <a href="#modal-dialog" class="btn btn-xs btn-primary mr-3" data-toggle="modal" >--}}
{{--              <i class="fa fa-file-import"></i> Import </a>--}}

{{--            --}}{{--          <a href="{{ route('admin.indicator.export', 'xls') }}"><button class="btn btn-success">Download Excel xls</button></a>--}}
{{--            --}}{{--          <a href=""><button class="btn btn-success">Download Excel xlsx</button></a>--}}

{{--            <a href="{{ route('admin.history.export', ['type' => 'xlsx']) }}" class="btn btn-xs btn-success mr-3">--}}
{{--              <i class="fa fa-file-export"></i> Export--}}
{{--            </a>--}}
            <div class="panel-heading-btn">
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
          </div>
          <!-- end panel-heading -->
          <!-- begin panel-body -->
          <div class="panel-body">
            <table id="data-table-fixed-columns" class="table table-striped table-bordered  table-td-valign-middle" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>№</th>
                <th>Область</th>
                <th>Район</th>
                <th>Массив</th>
                <th>Фермер</th>
                <th>Номер контура</th>
                <th>Площадь посева</th>
                <th>Год</th>
                <th>Урожай</th>
              </tr>
              </thead>

              <tbody>
              @foreach($response as $item)
                <tr>
                  <td> {{ ($response->currentpage()-1)*$response->perpage() + ($loop->index + 1) }} </td>
                  <td> {{ $item->region->name }} </td>
                  <td> {{ $item->district->name }} </td>
                  <td> {{ $item->matrix->name }} </td>
                  <td> {{ $item->farmer->farmer->name }} </td>
                  <td> {{ $item->farmerContour->contour_number }} </td>
                  <td> {{ $item->farmerContour->crop_area }} </td>
                  <td> {{ $item->year }} </td>
                  <td> {{ $item->crop_name }} </td>
                </tr>
              @endforeach
              </tbody>
            </table>
            Записи с {{ ($response->currentpage()-1)*$response->perpage()+1}} по {{($response->currentpage()-1)*$response->perpage() + count($response->items())}} из {{ $response->total() }} записей
            <div class="float-right">{{$response->links()}}</div>
          </div>
          <!-- end panel-body -->
        </div>
        <!-- end panel -->
      </div>
      <!-- end col-10 -->
    </div>
    <!-- end row -->

    <div class="modal fade" id="modal-dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Import файл</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form action="{{ route('admin.history.import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container">
              <div class="row">
                <div class="col-4 m-0 p-25">
                  <input type="file" name="import_file" />
                </div>
              </div>
              <p class="text-right mr-4 mt-2">
                <input type="submit" value="Import" class="btn btn-primary import-button">
                <a href="{{route('admin.history.index')}}" class="btn btn-danger">
                  <i class="fas fa-arrow-circle-left"></i>
                  Назад
                </a>
              </p>
            </div>

          </form>
        </div>
      </div>
    </div>
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
  $(document).ready(function(){
    $('select[name="region"]').bind('change',function(){
      var region_id= $(this).val();
      if (region_id) {
        $.ajax({
          url: "{{ url('admin/basic/districts') }}/"+region_id,
          type: "GET",
          dataType: "json",
          success: function(data){
            $('select[name="district"]').empty();
            $('select[name="district"]').append('<option value="">Выберите район</option>');
            $.each(data,function(key,value){
              $('select[name="district"]').append('<option value="'+value.id+'">'+value.name+'</option>');
            });
          }
        });
      }else {
        $('select[name="district"]').empty();
      }
    });
  });
</script>
<script>
  $(document).ready(function(){
    $('select[name="district"]').bind('change',function(){
      var district_id= $(this).val();
      if (district_id) {
        $.ajax({
          url: "{{ url('admin/farmers/list') }}/"+district_id,
          type: "GET",
          dataType: "json",
          success: function(data){
            $('select[name="farmer"]').empty();
            $('select[name="farmer"]').append('<option value="">Выберите фермер</option>');
            $.each(data,function(key,value){
              $('select[name="farmer"]').append('<option value="'+value.id+'">'+value.name+' - '+value.crop_area+' (га)</option>');
            });
          }
        });
      }else {
        $('select[name="farmer"]').empty();
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    jQuery('.import-button').click(function() {
      $( "body" ).append("<div id='page-loader' class='fade show'><span class='spinner'></span></div>")
    });
  });
</script>
<!-- ================== END PAGE LEVEL JS ================== -->
</body>
</html>
