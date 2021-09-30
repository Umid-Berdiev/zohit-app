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
					<table id="data-table-scroller" class="table table-striped table-bordered  table-td-valign-middle" cellspacing="0" width="100%">
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
                  <td> {{ $loop->index + 1 }} </td>
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
	<script src="/assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<script src="/assets/plugins/datatables.net-scroller-bs4/js/scroller.bootstrap4.min.js"></script>
	<script>
		if ($('#data-table-scroller').length !== 0) {
			$('#data-table-scroller').DataTable({
				// ajax:           "/assets/js/demo/json/scroller_demo.json",
				deferRender:    true,
				scrollY:        300,
				scrollCollapse: true,
				scroller:       true,
				responsive: true
			});
		}
	</script>
@endpush
