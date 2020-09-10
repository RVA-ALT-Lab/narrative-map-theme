<h1>Import GeoJSON</h1>
<input type="file" id="upload-input"></input>
<input type="button" id="create-feature" value="Create Feature">
<script>
const features = []
const uploadInput  = document.querySelector('#upload-input')
uploadInput.addEventListener('change', function (event) {
  const file = this.files[0]
  file.text().then(function(text){
    const data = JSON.parse(text);
    console.log(data)
    data.features.forEach(feature => {
      features.push(feature)
    })
  })
})

const createFeatureButton = document.querySelector('#create-feature')
createFeatureButton.addEventListener('click', function(event){
  fetch('/wp-json/narrative-map-theme/v1/features', {
    method: 'POST',
    body: JSON.stringify(features[1])
  }).then(response => {
    return response.json()
  }).then(json => console.log(json))
})
</script>