<?php

namespace Tests\Unit;

use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function it_displays_student_and_course_details()
    {
        $this->withoutMiddleware();

        $this->withSession([
            'student' => 'Jane Doe',
            'course' => 'SW101',
            'amount' => '200',
        ]);

        $response = $this->get('payments/payment');

        $response->assertStatus(200);
        $response->assertSee('Jane Doe');
        $response->assertSee('SW101');
        $response->assertSee('200');


    /** @test */
   public function it_validates_payment_submission()
    {
        // Set session data for student and course
        $this->withSession([
            'student' => [
                'name' => 'Jane Doe',
                'age' => 23,
                'email' => 'jane@example.com',
                'phone' => '+251912345678',
            ],
            'course' => [
                'course_code' => 'SW101',
                'duration' => 4,
                'course_fee' => 200,
            ],
        ]);

        // Perform the POST request
        $response = $this->post('pay', []);

        // Assert that the response status is 200
        $response->assertStatus(200);
    }
}

