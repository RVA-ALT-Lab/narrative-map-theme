var MapUtilityClass = function ($) {

  this.geoJsonLayer = null;

  this.fetchGeoJson = function () {
      fetch('/wp-content/themes/narrative-map-theme/va-counties-town-cities-extended.json')
        .then(data => data.json())
        .then(json => resolve(json))
  }

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

  this.createCountyBoundries =  (map) => {
    return new Promise((resolve, reject) => {
      fetch('/wp-content/themes/narrative-map-theme/va-counties-town-cities-extended.json')
        .then(data => data.json())
        .then(json => {

          const countyLayer = L.geoJSON(json,{
            onEachFeature: (feature, layer) => {
              if(feature.properties) {
                const popupContent = this.returnFeaturePopupContent(feature)
                const popup = layer.bindPopup(popupContent)
                console.log(popup)

              }
            }
          })
          .addTo(map)
          this.geoJsonLayer = countyLayer
          countyLayer.setStyle(this.returnBaseMapStyles)
          resolve(countyLayer)
        })
    })
  }

  this.returnFeaturePopupContent = (feature) => {

    const tableRows = []
    for (let prop in feature.properties.data) {
      if (feature.properties.data[prop]) {
        const row = `<tr><td>${prop}</td><td>${feature.properties.data[prop]}</td></tr>`
        tableRows.push(row)
      }
    }
    const popupContent = `
      <h2>${feature.properties.Name}</h2>
      <table>
        <tbody>

        </tbody>
      </table>
    `
    return popupContent
  }

  this.returnBaseMapStyles = () => {
    return {
      "fillColor": '#FFFFFF',
      "fillOpacity": 0,
      "color": '#FFFFFF'
    }
  }

  this.processNarrativeStepIntoInstructions = function (element) {
    const mapInstructions = {
      focus: {
        latitude: null,
        longitude: null,
        zoom: null,
        transition: null
      },
      map: {
        title: null,
        legend: null,
        points: [],
        highlightedCounties: []
      },
      binding: null
    }
    mapInstructions.focus.latitude = parseFloat(element.dataset.focusLatitude)
    mapInstructions.focus.longitude = parseFloat(element.dataset.focusLongitude)
    mapInstructions.focus.zoom = parseInt(element.dataset.focusZoom)
    mapInstructions.focus.transition = element.dataset.focusTransition


    mapInstructions.map.title = element.dataset.mapTitle
    mapInstructions.map.legend = element.dataset.mapLegend
    mapInstructions.map.points = element.dataset.mapPoints ? JSON.parse(element.dataset.mapPoints) : []
    mapInstructions.map.highlightedCounties = element.dataset.highlightedCounties

    mapInstructions.binding = element.dataset.mapBinding
    return mapInstructions
  }

  this.performFocusTransitions = function (map, instructions) {

    const newFocus = [
      [37.5536111, -77.4605556],
      instructions.focus.zoom || 8
    ]
    if (!instructions.focus.transition || instructions.focus.transition === 'zoomTo') {
      map.setView(...newFocus)
    } else if (instructions.focus.transition === 'panTo') {
      map.panTo(...newFocus)
    } else if (instructions.focus.transition === 'flyTo') {
      map.flyTo(...newFocus)
    }
  }
  this.activeMarkers = []

  this.addMapPoints = (map, points) => {
    points.forEach(point => {
      const marker = L.marker([point.latitude, point.longitude], {
        title: point.title
      })
      marker.bindPopup(point.content)
      marker.addTo(map)
      this.activeMarkers.push(marker)
    })
  }

  this.removeMapPoints = () => {
    this.activeMarkers.forEach(marker => {
      marker.remove()
    })
  }

  this.styleBasedOnBoundProperties = (instructions) => {
    this.geoJsonLayer.setStyle((feature) => {
      if (feature.properties.data[instructions.binding]) {
        return {
          "fillColor": '#87cefa',
          "fillOpacity": .5,
          "color": '#87cefa'
        }
      }
    })
  }

  this.resetBaseMapProperties = () => {
    this.geoJsonLayer.setStyle(this.returnBaseMapStyles)
  }

}

var MapTool = new MapUtilityClass(jQuery);

const map = MapTool.initMap();
var countyLayer
MapTool.createCountyBoundries(map).then(counties => {
  countyLayer = counties
  this.geoJsonLayer = countyLayer
});