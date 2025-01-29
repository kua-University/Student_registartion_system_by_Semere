<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function it_displays_active_navigation_link()
    {
        $response = $this->get(route('home'));

        $response->assertSee('<a class="nav-link active" href="'.route('home').'">Home</a>', false);
    }
}
