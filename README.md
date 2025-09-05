# Backend

## Requirements

PHP

## Usage

Run tests
`make tests`

Run code style checker
`make cs`

Run database container
`make up`

Stop database container
`make down`

Available commands

./fleet create <userId> # returns fleetId on the standard output

./fleet register-vehicle <fleetId> <vehiclePlateNumber>

./fleet localize-vehicle <fleetId> <vehiclePlateNumber> latitude longitude
