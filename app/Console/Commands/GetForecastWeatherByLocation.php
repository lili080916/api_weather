<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\ApiOpenweathermapTrait;

class GetForecastWeatherByLocation extends Command
{
    use ApiOpenweathermapTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast 
        {location? : City and country code. Santander,ES by default }
        {--d|days= : The number of days to retrieve forecast data for, 1 by default. }
        {--u|units= : Units of measurement must be metric or imperial, metric by default. } ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the weather forecast for max 5 days for the given location.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $city = $this->argument('location') ? explode(',', $this->argument('location'))[0] : 'Santander';
        $country = $this->argument('location') ? explode(',', $this->argument('location'))[1] : 'ES';
        $days = $this->option('days') ?? 1;
        $units = $this->option('units') ?? 'metric';
        $un = $units == 'metric' ? ' °C' : ' °F';

        if ($days > 5) {
            $this->error('The number of days must be less than or equal to 5');

            return Command::SUCCESS;
        }

        $forecasts = $this->getWeatherForecast($city, $country, $units, $days);

        $this->line($forecasts['city'].' ('.$forecasts['country'].')');
        foreach ($forecasts['forecasts'] as $key => $forecast) {
            $this->line(date("M j, Y", $forecast->dt));
            $this->line("> Weather: ". $forecast->weather[0]->description);
            $this->line("> Temperature: ". $forecast->main->temp.$un);
        }

        return Command::SUCCESS;
    }
}
