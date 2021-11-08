<!-- begin col-12 -->
<div class="col-xl-12">
  <!-- begin panel -->
  <div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
      <h4 class="panel-title">Общая посевная площадь: {{$response['total_area']}} га | Площадь после фильтрации: {{$response['required_area']}} га</h4>
      <a href="{{ route('portal.export', ['type' => 'xlsx', 'data' => request()->all()]) }}" class="btn btn-xs btn-success mr-3">
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
{{--          <th>Массив</th>--}}
          <th>Фермер</th>
          <th>Номер контура</th>
          <th>Площадь посева</th>
          <th>Показатели качества прошлого года</th>
          <th>Урожай</th>
        </tr>
        </thead>

        <tbody>
        @foreach($response['features'] as $item)
          <tr>
            {{--            <td> {{ ($response->currentpage()-1)*$response->perpage() + ($loop->index + 1) }} </td>--}}
            <td> {{ ($loop->index + 1) }} </td>
            <td> {{ $item['properties']['region'] }} </td>
            <td> {{ $item['properties']['district'] }} </td>
            <td> {{ $item['properties']['farmer'] }} </td>
            <td> {{ $item['properties']['contour_number'] }} </td>
            <td> {{ $item['properties']['crop_area'] }} </td>
            <td> {{ $item['properties']['quality_indicator'] }} </td>
            <td> @foreach($item['crops'] as $key => $value) {{ $key.' - '.$value }} | @endforeach </td>
          </tr>
        @endforeach
        </tbody>
      </table>
{{--      Записи с {{ ($response->currentpage()-1)*$response->perpage() + ($response->total()==0?0:1)}} по {{($response->currentpage()-1)*$response->perpage() + count($response->items())}} из {{ $response->total() }} записей--}}
{{--      <div class="float-right">{{$response->links()}}</div>--}}
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

