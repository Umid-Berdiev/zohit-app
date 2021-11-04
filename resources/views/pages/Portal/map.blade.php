<!-- begin col-12 -->
<div class="col-xl-12">
  <!-- begin panel -->
  <div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
      <h4 class="panel-title">Общая посевная площадь фермера: {{$response['total_area']}} га | Площадь после фильтрации: {{$response['required_area']}} га</h4>
      <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
      </div>
    </div>
    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body">
      <div id="mapid" ref="map">

      </div>
    </div>
    <!-- end panel-body -->
  </div>
  <!-- end panel -->
</div>
<!-- end col-12 -->

@section('vue-scripts')
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
          integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
          crossorigin=""></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
  <script>

    new Vue({
      el: "#mapid",

      data() {
        return {
          map: null,
          zoom: 6,
          center: [41.95949, 67.335205],
          crs: 'EPSG4326',
          currentZoom: 6,
          tileProviders: [
            {
              name: "Openstreet харита",
              attribution:
                '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
              url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            },
            {
              name: "Google харита",
              url: "http://www.google.com/maps/vt?ROADMAP=s@189&gl=uz&x={x}&y={y}&z={z}",
              attribution: "GoogleMaps",
            },
            {
              name: "Google харита (сунъний йўлдош)",
              url: "http://www.google.com/maps/vt?lyrs=s,h@189&gl=uz&x={x}&y={y}&z={z}",
              attribution: "GoogleSatellite",
            },
          ],
          maxBounds: L.latLngBounds([
            [42.5, 65],
            [40, 70],
          ])
        };
      },
      mounted() {
        this.setupLeafletMap();
        // this.getPoints()
        // this.getRegionLayer()


      },
      methods: {
        setupLeafletMap() {
          // console.log()
          const layers = this.tileProviders.map(({ attribution, url }) => {
            return L.tileLayer(url, { attribution });
          });

          this.map = L.map("mapid").setView(this.center, this.zoom);
          // this.map.setMaxBounds(this.maxBounds)
          const baseMaps = {
            "Openstreet харита": layers[0],
            "Google харита": layers[1],
            "Google харита (сунъний йўлдош)": layers[2],
          };

          this.regionLayers = @json($response, JSON_UNESCAPED_UNICODE);

          let nelat = 91
          let nelng = -181
          let swlat = -91
          let swlng = 181

          for (const [key, value] of Object.entries(this.regionLayers.features)) {
            let polygon = L.geoJSON(value, {
              style: function (feature) {
                return {color: value['properties']['color']};
              }
            })
              .bindPopup((layer) => {
                return `
                  <table class="table table-striped table-bordered">
                    <tr>
                      <th>Фермер</th>
                      <td>${value['properties']['farmer'].toString()}</td>
                    </tr>
                    <tr>
                      <th>Номер контура</th>
                      <td>${value['properties']['contour_number'].toString()}</td>
                    </tr>
                    <tr>
                      <th>Площадь посева</th>
                      <td>${value['properties']['crop_area'].toString()}</td>
                    </tr>
                    <tr>
                      <th>Показатели качества прошлого года</th>
                      <td>${value['properties']['quality_indicator'].toString()}</td>
                    </tr>
                  </table>
                `
              })
              .addTo(this.map);

            nelat = Math.min(nelat, polygon.getBounds().getNorthEast().lat)
            nelng = Math.max(nelng, polygon.getBounds().getNorthEast().lng)
            swlat = Math.max(swlat, polygon.getBounds().getSouthWest().lat)
            swlng = Math.min(swlng, polygon.getBounds().getSouthWest().lng)
          }

          this.map.fitBounds(L.latLngBounds([
            [nelat, nelng],
            [swlat, swlng]
          ]));

          L.control.layers(baseMaps).addTo(this.map);
          layers[0].addTo(this.map);
        }
      },
    }) ;
  </script>

@endsection
