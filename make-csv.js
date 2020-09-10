const fs = require('fs')
const createCsvWriter = require('csv-writer').createObjectCsvWriter;


const file = fs.readFileSync('./va-counties-town-cities-extended.json')
const json = JSON.parse(file)

const features = json.features.map(feature => {
  delete feature.properties.data['\n\n']
  delete feature.properties.data[feature.properties.data['NAME']]
  return feature.properties.data
})
// console.log(features)
const headers = []

for (key in features[0]){
  const header = {
    id: key,
    title: key
  }
  headers.push(header)
}

console.log(headers)
const csvWriter = createCsvWriter({
  path: './current-data.csv',
  header: headers
});

csvWriter.writeRecords(features)