<!-- begin col-12 -->
<div class="col-xl-12">
  <!-- begin panel -->
  <div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
      <h4 class="panel-title">Общая посевная площадь: {{$response['total_area']}} га | Площадь после фильтрации: {{$response['required_area']}} га</h4>
      <button class="btn btn-xs btn-success mr-3" onclick="exportToImage()">
        Скачать изображение
      </button>
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
{{--      <button id="snapshot-button">--}}
{{--        Snapshot--}}
{{--      </button>--}}
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
  <script src="{{ asset('js/html2canvas.min.js') }}"></script>

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

          // this.map.addControl(new L.Control.Fullscreen());

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
              }).addTo(this.map);
            polygon.bindTooltip(value['properties']['contour_number'].toString(),
              {
                permanent: true,
                direction:"center",
                className: 'labelstyle'
              }
            ).openTooltip(polygon.getBounds().getCenter())

            nelat = Math.min(nelat, polygon.getBounds().getNorthEast().lat)
            nelng = Math.max(nelng, polygon.getBounds().getNorthEast().lng)
            swlat = Math.max(swlat, polygon.getBounds().getSouthWest().lat)
            swlng = Math.min(swlng, polygon.getBounds().getSouthWest().lng)
          }

          this.map.fitBounds(L.latLngBounds([
            [nelat, nelng],
            [swlat, swlng]
          ]));

          function getColor(d) {
            return d > 80 ? 'green' :
              d > 60  ? '#85e62c' :
                d > 40  ? 'yellow' :
                  d > 20  ? 'orange' :
                    'red';
          }

          let legend = L.control({position: 'bottomright'});

          legend.onAdd = function (map) {
            let div = L.DomUtil.create('div', 'info legend'),
              grades = [0, 20, 40, 60, 80],
              labels = [];
            // loop through our density intervals and generate a label with a colored square for each interval
            for (let i = 0; i < grades.length; i++) {
              div.innerHTML +=
                '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }
            return div;
          };

          legend.addTo(this.map);

          // Set up snapshotter
          const snapshotOptions = {
            hideElementsWithSelectors: [
              ".leaflet-control-container",
              ".leaflet-dont-include-pane",
              "#snapshot-button"
            ],
            hidden: true
          };

          L.control.layers(baseMaps).addTo(this.map);
          layers[0].addTo(this.map);
        }
      },
    }) ;

    function exportToImage() {
      html2canvas(document.querySelector('#mapid'), {
        useCORS: true,
        logging: true,
        allowTaint: true
      }).then(function (canvas) {
        saveAs(canvas.toDataURL(), 'map_img.png');
      });

      function saveAs(uri, filename) {
        let link = document.createElement('a');

        if (typeof link.download === 'string') {

          link.href = uri;
          link.download = filename;

          //Firefox requires the link to be in the body
          document.body.appendChild(link);

          //simulate click
          link.click();

          //remove the link when done
          document.body.removeChild(link);

        } else window.open(uri);

      }

    }
  </script>

@endsection
