# Api Weather

Application that implements console commands that access the `openweathermap` api to obtain weather data

## Start

```bash
composer install

Create .env from .env.example and fill the variables

OPENWEATHERMAP_URL=
OPENWEATHERMAP_KEY=
```

## Commands

```bash
php artisan current Havana,CU -uimperial

response:
Havana (CU)
Feb 24, 2022
> Weather: clear sky
> Temperature: 75.52 °F
```
Get the current weather data for the given location.

Arguments:

* Location, in `{city},{country code}` format. If you don't pass the argument, it defaults to Santander,ES

Options:

* --units: Units of measurement must be `metric` or `imperial`, `metric` by default.

```bash
php artisan forecast Madrid,ES -d5 -uimperial

response:
Madrid (ES)
Feb 24, 2022
> Weather: clear sky
> Temperature: 46.47 °F
Feb 25, 2022
> Weather: light rain
> Temperature: 47.71 °F
Feb 26, 2022
> Weather: overcast clouds
> Temperature: 46.76 °F
Feb 27, 2022
> Weather: overcast clouds
> Temperature: 45.9 °F
Feb 28, 2022
> Weather: clear sky
> Temperature: 44.08 °F
```

Get the weather forecast for max 5 days for the given location.

Arguments:

* Location, in `{city},{country code}` format. If you don't pass the argument, it defaults to Santander,ES

Options:

* --days: The number of days to retrieve forecast data for, `1` by default.
* --units: Units of measurement must be `metric` or `imperial`, `metric` by default.

```bash
php artisan forecast:ask

response:
How many days to forecast?:
> 2

what unit of measure?:
[0] metric
[1] imperial
> 0

Santander (ES)
Feb 24, 2022
> Weather: overcast clouds
> Temperature: 10.16 °C
Feb 25, 2022
> Weather: light rain
> Temperature: 9.56 °C
```

Same as forecast command using questions for days and unit of measure

## Logging

log en el archivo storage/log/weather.log

## Test

```bash
php artisan test
```

* get_current_weather_by_location
* get_forecast_weather_by_location_and_days
* get_forecast_weather_by_location_and_days_wizard_ask

