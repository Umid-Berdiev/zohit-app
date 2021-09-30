@extends('layouts.default')

@section('title', 'Фермеры')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Рабочий стол</a></li>
		<li class="breadcrumb-item active">Фермеры</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Фермеры</h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-10 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Фермеры</h4>
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
                <th>ID</th>
								<th>Название</th>
                <th>Площадь посева</th>
                <th>Область</th>
								<th>Район</th>
                <th>Действия</th>
							</tr>
						</thead>
            <tbody>
              @foreach($response as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->crop_area }}</td>
                  <td>{{ $item->region->name }}</td>
                  <td>{{ $item->district->name }}</td>
                  <td class="text-center">
                    <a href="{{ route('admin.farmer.show', ['farmer' => $item->id]) }}" class="btn  btn-icon btn-success mr-1"><span class="fas fa-eye "></span></a>
                    <button type="button" class="btn btn-icon btn-primary mr-1" data-toggle="modal" data-target="#edit-modal">
                      <i class="fa fa-edit"></I>
                    </button>
                    <a
                      class="btn btn-icon btn-danger delete_button"
                      data-toggle="modal"
                      data-target="#deleteModal"
                    >
                      <i class="fas fa-trash  text-white"></i>
                    </a>
                  </td>
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
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" align="center"><b>Редактировать</b></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.farmer.update')}}" class="form-group" method="post" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Название фермера</label>
                <input type="text" class="form-control" name="name" placeholder="Название" >
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрывать</button>
              <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
          </form>
        </div>
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

  <script>

  </script>
@endpush
