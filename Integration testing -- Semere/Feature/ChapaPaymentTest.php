<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ChapaPaymentTest extends TestCase
{
    use RefreshDatabase; // Ensures a fresh database for each test

    /** @test */
    public function it_initializes_payment_and_redirects_to_chapa()
    {
        // Mock Chapa API Response
        Http::fake([
            'https://api.chapa.co/v1/transaction/initialize' => Http::response([
                'status' => 'success',
                'data' => [
                    'checkout_url' => 'https://chapa.test/checkout'
                ]
            ], 200)
        ]);

        // Simulate session data
        $this->withSession([
            '_token' => csrf_token(), // Ensure CSRF token exists
            'student' => [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'phone' => '+251912345678'
            ],
            'course' => [
                'course_code' => 'SW101',
                'duration' => 4,
                'course_fee' => 200
            ]
        ]);

        // Send POST request with session data
        $response = $this->post(route('pay'), ['_token' => csrf_token()]);

        // Assert redirection to Chapa checkout URL
        $response->assertRedirect('https://chapa.test/checkout');
    }

    /** @test */
    public function it_verifies_payment_and_creates_student_and_payment_records()
    {
        // Fake Chapa verification API response
        Http::fake([
            'https://api.chapa.co/v1/transaction/verify/*' => Http::response([
                'status' => 'success',
                'data' => [
                    'amount' => 200
                ]
            ], 200)
        ]);

        // Simulate session data
        session([
            'student' => [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'phone' => '+251912345678'
            ],
            'course' => [
                'course_code' => 'SW101',
                'duration' => 4,
                'course_fee' => 200
            ]
        ]);

        // Simulate callback after payment success
        $reference = 'TX12345';
        $response = $this->get(route('callback', ['reference' => $reference]));

        // Assert redirection to the correct success page
        $response->assertRedirect(route('payments.success'));

        // Check that student and payment were created
        $this->assertDatabaseHas('students', ['email' => 'jane@example.com']);
        $this->assertDatabaseHas('payments', ['tx_ref' => $reference, 'amount' => 200]);
    }
}
