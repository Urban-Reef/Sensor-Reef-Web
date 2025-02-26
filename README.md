# Sensor Reef Web
Sensor Reef Web is part of the Sensor  Reef project, aimed at improving the collection and canalisation of data for the development of Reefs.
The web application forms the center of the full project responsible for storing, retrieving and managing Reefs and their collected data.
Other related projects are:

- Sensor-Arduino-MKR
- UR-Encoder
- UR-Decoder

## Table of contents
- [Features](#features)
- [User manual](#user-manual)
- [Technical overview](#technical-overview)
- [Educational resources](#educational-resources)

## Features
Current and planned features of the web app are:
- [x] [Storing sensor data](./docs/storing_sensor_data.md).
- [ ] [Storing data collected during monitoring sessions](./docs/monitoring_sessions.md).
- [ ] Managing Reefs and their data.
- [ ] Request data through API or UI
- [ ] Data visualisation
  - Through graphs, timelines, 3D visualisation or other methods

### Important to-do's:
- [ ] Index, detail & edit screen for Reefs.
- [ ] Index, detail & edit screen for Sessions.
- [ ] Authentication, users & APIs.

## User Manual
- [Installing a Reef](./docs/user_manual/reef_installation.md)
- [installation and dev environment](./docs/user_manual/set_up_dev_env.md)

## Technical overview
- Laravel Sail (Docker Compose)
- Framework: Laravel
- Front-end: Inertia.js + Vue.js (composition API)
- Database: MySQL

### ERD
![ERD](https://drive.google.com/uc?id=1C59muJARNKDhu8BCqa4bvV1o19a7W8xY)

## Educational resources
If you're not familiar with Laravel + Vue these courses will help you familiarise yourself with important concepts:
- Complete [Learn Laravel Path](https://laracasts.com/path)
- [30 days to learn laravel](https://laracasts.com/series/30-days-to-learn-laravel-11)
- [Learn Vue 3](https://laracasts.com/series/learn-vue-3-step-by-step)
- [Build modern Laravel apps using Inertia.js](https://laracasts.com/series/build-modern-laravel-apps-using-inertia-js)
