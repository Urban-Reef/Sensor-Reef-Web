# Installing & connecting a Reef
- [Creating a Reef in the web application](#creating-a-reef-in-the-web-application)
- Configuring the sensor system

## Creating a Reef in the web application.
To create a Reef navigate to: `/reefs/create`.

Next fill out the following fields on the page:
### General information
- **Name**; required | unique
  - choose a descriptive and unique name for the Reef.
- **Date of Placement**; required
  - When has or will the Reef be placed.
- **Diagram**; image .jpeg, .jpg or .png
  - A diagram visualising all the points on a Reef.
  - Preferably has an aspect ratio of 4:3 for better readability on smartphones.
- **Location**; required
  - set the location of the Reef by clicking on the map.

### Points & Sensors
Below the map you can add points. In turn, you can add sensors to points.
The points are numbered, i.e. 1, 2, etc. These numbers should reflect the points in the diagram.
To add points and sensors simply click their respective add and delete buttons.

#### Sensor information:
- **Type**: type of measurement | case-sensitive
- **Unit**: unit of measurement

**IMPORTANT:** For automatic data collection to work, Type should match the attribute name in which the value is stored by the [decoder](https://github.com/Urban-Reef/Sensor-Reef-URDecoder).
For example, the decoder stores temperature like this:
```json
{
  "temperature": 34.5
}
```
Type should thus be set to `temperature`, case-sensitive, as the application uses the attribute name to store the data send by
the sensor system, see [storing sensor data](../storing_sensor_data.md).

Click submit to save the Reef.

## Configuring the sensor system
