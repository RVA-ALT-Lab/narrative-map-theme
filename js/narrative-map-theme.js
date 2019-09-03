var MapUtilityClass = function ($) {
  this.geoJsonLayer = null
  this.legendControl = null
  this.activeMarkers = []

  this.fetchGeoJson = function () {
      fetch('/wp-content/themes/narrative-map-theme/va-counties-town-cities-extended.json')
        .then(data => data.json())
        .then(json => resolve(json))
  }

  this.initMap = function ( ) {
      var mymap = L.map('map').setView([37.5215, -78.8537], 7);
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
          ${tableRows.join()}
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
    const lat = instructions.focus.latitude || 37.5215
    const lng = instructions.focus.longitude || -78.8537
    const zoom = instructions.focus.zoom || 7
    const newFocus = [ [lat, lng], zoom ]
    if (!instructions.focus.transition || instructions.focus.transition === 'zoomTo') {
      map.setView(...newFocus)
    } else if (instructions.focus.transition === 'panTo') {
      map.panTo(...newFocus)
    } else if (instructions.focus.transition === 'flyTo') {
      map.flyTo(...newFocus)
    }
  }
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

  this.styleBasedOnBoundProperties = (map, instructions) => {
    if (instructions.binding) {
      const convertedInstructions = JSON.parse(instructions.binding)
      this.geoJsonLayer.setStyle((feature) => {
        for (let instructionSet of convertedInstructions) {
          if (feature.properties.data[instructionSet.field]) {
            if (instructionSet.pattern === 'striped') {
              let stripes = new L.StripePattern({color:instructionSet.fill_color, angle: -45})
              stripes.addTo(map)
              return {
                "fillPattern": stripes,
                "fillOpacity": instructionSet.fill_opacity,
                "color": instructionSet.border_color
              }
            } else {
              return {
                "fillColor": instructionSet.fill_color,
                "fillOpacity": parseFloat(instructionSet.fill_opacity),
                "color": instructionSet.border_color
              }
            }
          }
        }
      })
    } else {
      return
    }
  }


  this.createNewLegend = (map, instructions) => {
    const legend = L.control({position: 'bottomleft'})
    this.legendControl = legend
    legend.onAdd = (map) => {
      var div = L.DomUtil.create('div', 'info legend')
      div.in = 'legend'
      div.innerHTML = instructions.map.title || ""
      return div
    }
    legend.addTo(map)
  }

  this.removeLegend = () => {
    this.legendControl.remove()
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