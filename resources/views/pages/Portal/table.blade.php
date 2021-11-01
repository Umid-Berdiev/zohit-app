<!-- begin col-12 -->
<div class="col-xl-12">
  <!-- begin panel -->
  <div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
      <h4 class="panel-title">Таблица</h4>
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
{{--          <th>Массив</th>--}}
          <th>Фермер</th>
          <th>Номер контура</th>
          <th>Площадь посева</th>
          <th>Год</th>
          <th>Урожай</th>
        </tr>
        </thead>

        <tbody>
        @foreach((array)$response as $item)
          <tr>
            <td> {{$loop->index + 1 }} </td>
            <td> {{ $item->region }} </td>
            <td> {{ $item->district }} </td>
            <td> {{ $item->farmer }} </td>
            <td> {{ $item->contour_number }} </td>
            <td> {{ $item->crop_area }} </td>
            <td> {{ $item->year }} </td>
            <td> {{ $item->crop_name }} </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- end panel-body -->
  </div>
  <!-- end panel -->
</div>
<!-- end col-12 -->

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

