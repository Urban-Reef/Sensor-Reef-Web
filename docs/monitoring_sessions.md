# Monitoring Session
Non-automated data collection is done through a monitoring session.

## General information
### Routes
- **GET**, return view: `/reefs/{id}/monitor`
- **POST**, store session: `/reefs/{id}/session`

### Models
- MonitoringSession
- BiodiversityEntry
- PointPhoto
- Sample
- SensorData

### Controller
- MonitoringSessionController

### Validation
- StoreMonitoringSessionRequest
- BiodiversityEntryRequest

### Pages & Components
- MonitoringSession/Create.vue
- EnvironmentSection.vue
- BiodiversityEntry.vue
- PointSection.vue

### Feature tests
MonitoringSessionTest

- testOnStoringSessionSuccess
- testOnValidationFail
