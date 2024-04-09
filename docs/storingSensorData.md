# Storing Sensor Data
Explanation of how sensor data is processed when received from TTN.
## TODO
- [ ] Authorisation
- [ ] Return error message when `pointId` or `sensorId` cannot be found.
## General information
### Route
POST: `/api/storeSensorData`
### Models
#### Sensor
Belongs to a **Point**. Has many **SensorData**.

`type` type of sensor i.e. humidity or temperature.

`unit` unit of measurement i.e. °C or %

#### SensorData
Belongs to **Sensor**.

`value` value measured by sensor stored as a numeric value.

`measured_at` standard value is `CURRENT_TIMESTAMP`

### Controller
SensorDataController
### Validation
PostSensorDataRequest
### Feature Test
StoreSensorDataTest
- successful store test
- validation fail test
## How it works
When TTN receives sensor data it will [decode](https://github.com/Urban-Reef/Sensor-Reef-URDecoder) the package to JSON and perform a POST request. Below an example of the contents of this request:
```json
{
    "uplink_message": {
        "decoded_payload": {
            "points": [
                {
                    "humidity": 47.5,
                    "position": 1,
                    "temperature": 20.1
                },
                //additional points
            ],
            "reefId": 1
        }
    }
}
```
The sensor data is stored by looping through the objects inside the `points` array. The id of a specific point is retrieved using the `reefID` and the `position` of a point:
```php
foreach ($data['points'] as $point){
    //get point id.
    $pointId = Point::where('reef_id', '=', $data['reefId'])
                    ->where('position', '=', $point['position'])
                    ->first()->id;
```
The other attribute names should be equal to the `type` of sensors. The names of the attributes can be accessed by creating an array of the keys:
```php
//create an array of keys. Keys should be equal to a sensor's type.
//remove 'position' from this array.
$keys = array_diff(array_keys($point), ['position']);
//example: $keys = ['humidity', 'temperature']
```
We can then loop through this array and retrieve the id of specific sensors:
```php
//Loop through keys array
foreach ($keys as $key){
    //get sensor id using pointId and the key. Key should be equal to the sensor type.
    $sensorId = Sensor::where('point_id', '=', $pointId)
                      ->where('type', '=', $key)
                      ->first()->id;
```
We then use this sensor id to insert a new `SensorData` entry into the database:
```php
//insert new sensor_data.
    $sensorData = new SensorData();
    $sensorData->sensor_id = $sensorId;
    $sensorData->value = $point[$key];
    $sensorData->save();
```
