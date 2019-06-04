var MapUtilityClass = function ($) {
  var self = this;

  this.vaCounties = function () {
    this.fetchGeoJson()
    .then(geojson => {
      return geojson
    })
  }

  this.fetchGeoJson = function () {
      fetch('/wp-content/themes/narrative-map-theme/va_counties_1870_lat_lng.json')
        .then(data => data.json())
        .then(json => resolve(json))
  }
  this.countyConventions = [
    'Accomack',
    'Prince Edward',
    'Nottoway',
    'Bedford'
  ]

  this.mahoneCanvass = [
    'Spotsylvania',
    'Henrico',
    'Chesterfield',
    'Prince Edward'
  ]


  this.initMap = function ( ) {

      var mymap = L.map('map').setView([37.5536111, -77.4605556], 7);
      L.tileLayer('https://api.mapbox.com/styles/v1/jeffeverhart383/cj9sxi40c2g3s2skby2y6h8jh/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiamVmZmV2ZXJoYXJ0MzgzIiwiYSI6IjIwNzVlOTA3ODI2MTY0MjM3OTgxMTJlODgzNjg5MzM4In0.QA1GsfWZccIB8u0FbhJmRg', {
          attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
          maxZoom: 18,
          id: 'mapbox.streets',
          accessToken: 'pk.eyJ1IjoiamVmZmV2ZXJoYXJ0MzgzIiwiYSI6ImNqOXI2aDg5ejZhYncyd3M0bHd6cWYxc2oifQ.fzcb7maGkQhAxRZTotB4tg'
      }).addTo(mymap);
      return mymap;
  }

  this.createCountyBoundries = function (map) {
    return new Promise((resolve, reject) => {
      fetch('/wp-content/themes/narrative-map-theme/va_counties_1870_lat_lng.json')
        .then(data => data.json())
        .then(json => {

          // function styleCounties(feature) {
          //   return {
          //     fillColor: feature.properties.description.countyConvention ? 'green' : null
          //   }
          // }

          // const mappedCounties = json.features.map(feature => {
          //   feature.properties.description.countyConvention = self.countyConventions.includes(feature.properties.description.name) ? true : false
          //   return feature
          // })
          // json.features = mappedCounties

          const countyLayer = L.geoJSON(json)
          .addTo(map)
          resolve(countyLayer)
        })
    })
  }


}

var MapTool = new MapUtilityClass(jQuery);

const map = MapTool.initMap();
var countyLayer
MapTool.createCountyBoundries(map).then(counties => {
  countyLayer = counties
});