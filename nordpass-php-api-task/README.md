# Secure Information Storage REST API

### Project setup

* Add `secure-storage.localhost` to your `/etc/hosts`: `127.0.0.1 secure-storage.localhost`

* Run `make init` to initialize project

* Open in browser: http://secure-storage.localhost:8000/item Should get `Full authentication is required to access this resource.` error, because first you need to make `login` call (see `postman_collection.json` or `SecurityController` for more info).

### Run tests

make tests

### API credentials

* User: john
* Password: maxsecure

### Update Item endpoint

POST http://secure-storage.localhost:8000/item?_method=PUT

#### Request Headers
* Host: secure-storage.localhost:8000
* Accept-Encoding: gzip, deflate, br
* Connection: keep-alive
* Content-Type: multipart/form-data; boundary=--------------------------160761595698873230673420
* Content-Length: 265
### Request Body
* id: "1"
* data: ""test""

### Response:
HTTP status 200

400 BAD_REQUEST Bad Request
* Content-Type: [application/json]
* Content-Length: []

### Postman requests collection

You can import all available API calls to Postman using `postman_collection.json` file
