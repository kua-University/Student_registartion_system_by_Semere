<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    /*
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }  */

    public function testHomePageResponseTime()
    {
        $startTime = microtime(true); // Start time
        $response = $this->get('/');
        $endTime = microtime(true); // End time

        $executionTime = $endTime - $startTime;

        // Assert that the response time is under 2 seconds
        $this->assertLessThan(2, $executionTime, 'Homepage is too slow');
    }

    public function testSpecificPageResponseTime()
    {
        $startTime = microtime(true);
        $response = $this->get('/some-page');
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;

        // Assert the response time is less than 3 seconds
        $this->assertLessThan(3, $executionTime, 'Page response is slow');
    }

    public function testSimulatedLoad()
    {
        $response = $this->get('/some-page');
        $response->assertStatus(200);  // Ensure the page loads successfully

        // Simulate multiple requests and measure response time
        $startTime = microtime(true);
        for ($i = 0; $i < 10; $i++) {
            $response = $this->get('/some-page');
            $response->assertStatus(200);  // Ensure all requests return successfully
        }
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;

        // Assert that the time for 10 requests is under 5 seconds
        $this->assertLessThan(5, $executionTime, 'Simulated load took too long');
    }

}
