<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\ApiOpenweathermapTrait;

class GetCurrentWeatherByLocation extends Command
{
    use ApiOpenweathermapTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current
        {location? : City and country code. Santander,ES by default }
        {--u|units= : Units of measurement must be metric or imperial, metric by default. } ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current weather data for the given location';

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
        $units = $this->option('units') ?? 'metric';
        $un = $units == 'metric' ? ' °C' : ' °F';

        $current = $this->getWeatherCurrent($city, $country, $units);

        $this->line($current->name.' ('.$current->sys->country.')');
        $this->line(date("M j, Y", $current->dt));
        $this->line("> Weather: ". $current->weather[0]->description);
        $this->line("> Temperature: ". $current->main->temp.$un);

        return Command::SUCCESS;
    }
}
