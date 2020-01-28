var MapUtilityClass = function ($) {
  this.geoJsonLayer = null
  this.legendControl = null
  this.activeMarkers = []
  this.activeStripes = null

  this.fetchGeoJson = function () {
      fetch('/wp-content/themes/narrative-map-theme/va-counties-town-cities-extended.json')
        .then(data => data.json())
        .then(json => resolve(json))
  }

  this.initMap = function ( ) {
      var mymap = L.map('map', {
        minZoom: 7,
        maxZoom: 10
      })
      .setView([37.5215, -78.8537])

      //TODO: Add check here for localized WP scripts, and setMaxBounds if set
      if (true){
        mymap.setMaxBounds([
          [36.560670, -74.989798],
          [39.483375, -83.441628]
        ])
      }
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
      "fillColor": '#F6F6F6',
      "fillOpacity": .9,
      "weight": 1,
      "color": '#6A6A6A'
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
      this.resetBaseMapProperties().then( () => {
        const convertedInstructions = JSON.parse(instructions.binding)
        this.geoJsonLayer.setStyle((feature) => {
          for (let instructionSet of convertedInstructions) {
            if (feature.properties.data[instructionSet.field]) {
              if (instructionSet.pattern === 'striped') {
                this.activeStripes = new L.StripePattern({color:instructionSet.fill_color, angle: -45})
                console.log(this.activeStripes)
                this.activeStripes.addTo(map)
                return {
                  "fillPattern": this.activeStripes,
                  "fillOpacity": instructionSet.fill_opacity,
                  "weight": 2,
                  "color": instructionSet.border_color
                }
              } else {
                return {
                  "fillColor": instructionSet.fill_color,
                  "fillPattern": null,
                  "fillOpacity": parseFloat(instructionSet.fill_opacity),
                  "weight": 2,
                  "color": instructionSet.border_color
                }
              }
            }
          }
        })
      })
    } else {
      return
    }
  }


  this.createNewLegend = (map, instructions) => {
    console.log(instructions)
    const legend = L.control({position: 'bottomleft'})
    this.legendControl = legend
    legend.onAdd = (map) => {
      var div = L.DomUtil.create('div', 'info legend')
      const bindings = JSON.parse(instructions.binding)
      console.log(bindings)
      const bindingsHTML = bindings.map(binding => {
        return `<i style="box-sizing: border-box;border: 3px solid ${binding.border_color}; background-color: ${binding.fill_color};"></i>${binding.legendAlias || binding.field}</br></br>`
      })
      div.in = 'legend'
      div.innerHTML =
      `<h5>${instructions.map.title || ""}</h5>
       ${bindingsHTML.join('')}
      `
      return div
    }
    legend.addTo(map)
  }

  this.removeLegend = () => {
    this.legendControl.remove()
  }


  this.resetBaseMapProperties = () => {
    return new Promise((resolve, reject) => {
      this.geoJsonLayer.setStyle(this.returnBaseMapStyles)
      if (this.activeStripes) {
        console.log(this.activeStripes)
        this.activeStripes.remove()
      }
      resolve()
    })
  }

}

var MapTool = new MapUtilityClass(jQuery);

const map = MapTool.initMap();
var countyLayer
MapTool.createCountyBoundries(map).then(counties => {
  countyLayer = counties
  this.geoJsonLayer = countyLayer
});