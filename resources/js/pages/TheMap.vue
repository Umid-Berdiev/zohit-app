<template>
  <div id="mapid" ref="map"></div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import L, { latLng, CRS } from "leaflet";

export default {
  data() {
    return {
      map: null,
      zoom: 6,
      center: latLng(41.95949, 67.335205),
      crs: CRS.EPSG4326,
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
    };
  },
  mounted() {
    this.setupLeafletMap();
  },
  methods: {
    setupLeafletMap() {
      const layers = this.tileProviders.map(({ attribution, url }) => {
        return L.tileLayer(url, { attribution });
      });

      this.map = L.map("mapid", {
        center: this.center,
        zoom: this.zoom,
      });

      const baseMaps = {
        "Openstreet харита": layers[0],
        "Google харита": layers[1],
        "Google харита (сунъний йўлдош)": layers[2],
      };

      L.control.layers(baseMaps).addTo(this.map);
      layers[0].addTo(this.map);
    },
  },
};
</script>

<style>
#mapid {
  height: 500px;
}
</style>
