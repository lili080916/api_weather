<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetWeatherTest extends TestCase
{
    /** @test */
    public function get_current_weather_by_location()
    {
        $this->withoutExceptionHandling();

        $this->artisan('current', ['location' => 'Santander,ES'], ['--units' => 'metric'])
            ->expectsOutput('Santander (ES)')
            ->assertExitCode(0);
    }

    /** @test */
    public function get_forecast_weather_by_location_and_days()
    {
        $this->withoutExceptionHandling();

        $this->artisan('forecast', ['location' => 'Santander,ES'], ['--units' => 'metric', '--days' => 3])
            ->expectsOutput('Santander (ES)')
            ->assertExitCode(0);
    }

    /** @test */
    public function get_forecast_weather_by_location_and_days_wizard_ask()
    {
        $this->withoutExceptionHandling();

        $this->artisan('forecast:ask', ['location' => 'Santander,ES'])
            ->expectsQuestion('How many days to forecast?', 3)
            ->expectsQuestion('what unit of measure?', 'metric')
            ->expectsOutput('Santander (ES)')
            ->assertExitCode(0);
    }
}
