<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SystemTest extends TestCase
{
    use RefreshDatabase; // Ensures a fresh database for every test

    /** @test */
    public function a_student_can_complete_registration_process()
    {
        // Step 1: Access Student Registration Page
        $response = $this->get('/students/create');
        $response->assertStatus(200); // Ensure the page loads successfully

        // Step 2: Submit Student Registration Form
        $studentData = [
            'name' => 'John Doe',
            'age' => 25,
            'email' => 'johndoe@example.com',
            'phone' => '+251912345678',
        ];

        $response = $this->post('/students/next', $studentData);
        $response->assertRedirect('/courses/create'); // Ensure redirection to course selection

        // Step 3: Check if student data is stored in session
        $this->assertNotEmpty(session('student'));
        $this->assertEquals('John Doe', session('student.name'));
    }

    /** @test */
    public function a_student_can_select_a_course()
    {
        // Simulate student session data (as if they just registered)
        $this->withSession([
            'student' => [
                'name' => 'John Doe',
                'age' => 25,
                'email' => 'johndoe@example.com',
                'phone' => '+251912345678'
            ]
        ]);

        // Step 1: Access Course Selection Page
        $response = $this->get('/courses/create');
        $response->assertStatus(200);

        // Step 2: Submit Course Selection Form
        $courseData = [
            'course_code' => 'SW101',
            'duration' => 4,
            'course_fee' => 200,
        ];

        $response = $this->post('/courses/stepTwo', $courseData);
        $response->assertRedirect('/payments/payment'); // Ensure redirection to payment page

        // Step 3: Verify course data is stored in session
        $this->assertNotEmpty(session('course'));
        $this->assertEquals('SW101', session('course.course_code'));
    }

    /** @test */
    public function a_student_can_complete_payment()
    {
        // Simulate student and course session data
        $this->withSession([
            'student' => [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'phone' => '+251912345678'
            ],
            'course' => [
                'course_code' => 'SW101',
                'duration' => 4,
                'course_fee' => 200
            ]
        ]);

        // Step 1: Access Payment Page
        $response = $this->get('/payments/payment');
        $response->assertStatus(200);

        // Step 2: Simulate Payment Submission
        $response = $this->post('/pay', []);
        $response->assertRedirect('/payments/payment_success'); // Expect redirection to success page

        // Step 3: Check if student and payment records are saved
        $this->assertDatabaseHas('students', ['email' => 'janedoe@example.com']);
        $this->assertDatabaseHas('payments', ['amount' => 200, 'status' => 'success']);
    }

    /** @test */
   /** @test */
    public function guests_cannot_access_payment_page()
    {
        $response = $this->get('/payments/payment');
        $response->assertRedirect('/students/create'); // Ensure unauthenticated users are redirected
    }


        /** @test */
    public function registration_page_loads_under_2_seconds()
    {
        $startTime = microtime(true); // Start time

        $response = $this->get('/students/create');

        $endTime = microtime(true); // End time
        $loadTime = $endTime - $startTime;

        $this->assertLessThan(2, $loadTime, "Registration page took too long to load.");
    }

}
