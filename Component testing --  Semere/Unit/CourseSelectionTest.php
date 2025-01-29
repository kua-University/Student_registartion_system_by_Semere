<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class CourseSelectionTest extends TestCase
{
    public function it_displays_course_selection_form()
    {
        $response = $this->get(route('courses.create'));

        $response->assertStatus(200);
        $response->assertSee('Select a Course');
    }

    /** @test */
    public function it_validates_course_selection()
    {
        $response = $this->post(route('courses.stepTwo'), [
            'course_code' => '', // No course selected
            'duration' => '',
        ]);

        $response->assertSessionHasErrors(['course_code', 'duration']);
    }

    /** @test */
}
