@extends('layouts.default')

@section('title', 'Показатели качества')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Рабочий стол</a></li>
		<li class="breadcrumb-item active">Показатели качества</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->

	<h1 class="page-header">Показатели качества</h1>
	<!-- end page-header -->
  <form action="{{ route('admin.indicator.index') }}" class="form-group" method="get" enctype="multipart/form-data">
  <div class="row">

      <div class="col-xl-3 col-md-6">
        <div class="form-group">
          <label for="region">Выберите регион</label>
          <select name="region" id="region" class="form-control">
            <option value="">Выберите регион</option>
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
            <option value="">Выберите район</option>
          </select>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="form-group">
          <label for="farmer">Выберите фермер</label>
          <select name="farmer" id="farmer" class="form-control">
            <option value="">Выберите фермер</option>
          </select>
        </div>
      </div>

      <?php $years = range(strftime("%Y", time()), 2000); ?>

      <div class="col-xl-2 col-md-6">
        <div class="form-group">
          <label for="year">Выберите год</label>
          <select name="year" id="year" class="form-control">
              <option value="">Выберите год</option>
              @foreach($years as $year)
                <option value="{{ $year }}" {{ $year == request('year') ? "selected" : "" }}>{{ $year }}</option>
              @endforeach
          </select>
        </div>
      </div>

      <div class="col-xl-1 col-md-6">
          <button type="submit" class="btn btn-success" style="margin-top: 25px">
            Фильтр
          </button>
      </div>
  </div>
  </form>


	<!-- begin row -->
	<div class="row">
{{--    @if($message = Session::get('success'))--}}
{{--      <div class="alert alert-info alert-dismissible fade in" role="alert">--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--          <span aria-hidden="true">×</span>--}}
{{--        </button>--}}
{{--        <strong>Success!</strong> {{ $message }}--}}
{{--      </div>--}}
{{--    @endif--}}
    @if ($errors->any())
      <ul class="alert alert-danger mr-2">
        @foreach ($errors->all() as $error)
          <li >{{ $error }}</li>
        @endforeach
      </ul>
    @endif
		<!-- begin col-10 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Показатели качества</h4>

          <a href="#modal-dialog" class="btn btn-xs btn-primary mr-3" data-toggle="modal" >
            <i class="fa fa-file-import"></i> Import </a>

{{--          <a href="{{ route('admin.indicator.export', 'xls') }}"><button class="btn btn-success">Download Excel xls</button></a>--}}
{{--          <a href=""><button class="btn btn-success">Download Excel xlsx</button></a>--}}

          <a href="{{ route('admin.indicator.export', 'xlsx') }}" class="btn btn-xs btn-success mr-3">
            <i class="fa fa-file-export"></i> Export
          </a>
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
                <th>Показатели качества</th>
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
                  <td> {{ $item->quality_indicator }} </td>
                </tr>
              @endforeach
            </tbody>
					</table>
            Записи с {{ ($response->currentpage()-1)*$response->perpage() + ($response->total()==0?0:1)}} по {{($response->currentpage()-1)*$response->perpage() + count($response->items())}} из {{ $response->total() }} записей
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
        <form action="{{ route('admin.indicator.import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        @csrf
          <div class="container">
            <div class="row">
              <div class="col-4 m-0 p-25">
                <input type="file" name="import_file" />
              </div>
            </div>
            <p class="text-right mr-4 mt-2">
              <input type="submit" value="Import" class="btn btn-primary">
              <a href="{{route('admin.indicator.index')}}" class="btn btn-danger">
                <i class="fas fa-arrow-circle-left"></i>
                Назад
              </a>
            </p>
          </div>

        </form>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
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
      $('select[name="region"]').on('change',function(){
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
      $('select[name="district"]').on('change',function(){
        var district_id= $(this).val();
        if (district_id) {
          console.log(district_id);
          $.ajax({
            url: "{{ url('admin/farmers/list') }}/"+district_id,
            type: "GET",
            dataType: "json",
            success: function(data){
              console.log(data);
              $('select[name="farmer"]').empty();
              $('select[name="farmer"]').append('<option value="">Выберите фермер</option>');
              $.each(data,function(key,value){
                $('select[name="farmer"]').append('<option value="'+value.id+'">'+value.name+'</option>');
              });
            }
          });
        }else {
          $('select[name="farmer"]').empty();
        }
      });
    });
  </script>
@endpush
