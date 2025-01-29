<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;



class StudentTest extends TestCase
{
    use MakesHttpRequests;

    /** @test */
    public function it_displays_the_registration_form()
    {
        $response = $this->get('/students/create');
        //dd($response->content());

        $response->assertStatus(200);
        $response->assertSee('Register Student');
    }

    /** @test */
    public function it_validates_form_inputs()
    {
        $response = $this->post('/students/next', [
            'name' => '', // Missing fields
            'age' => 17,
            'email' => 'invalid-email',
            'phone' => '123456',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone']);
    }

    /** @test */
    public function it_saves_valid_student_data_to_session()
    {
        $response = $this->post('/students/next', [
            'name' => 'John Doe',
            'age' => 25,
            'email' => 'johndoe@example.com',
            'phone' => '+251912345678',
        ]);

        $response->assertSessionHas('student');
    }

}
