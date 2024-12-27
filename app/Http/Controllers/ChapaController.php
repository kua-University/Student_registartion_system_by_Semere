<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ChapaController extends Controller
{
    /**
     * Initialize the payment process with Chapa.
     */
    public function initialize(Request $request)
    {
        // Retrieve session data
        $studentData = $request->session()->get('student');
        $courseData = $request->session()->get('course');

        if (!$studentData || !$courseData) {
            return redirect()->route('students.create')->with('error', 'Please complete the registration process first.');
        }

        $request->validate([
            'payment_id' => 'required|unique:payments,payment_id',
        ]);

        $student = Student::firstOrCreate(['email' => $studentData['email']], $studentData);
        $student->update($studentData);

        $course = Course::create($courseData);

        $payment = Payment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'amount' => $courseData['course_fee'],
            'status' => 'pending',
            'payment_id' => uniqid('payment_'),
        ]);

        \Log::info('Generated Payment:', $payment->toArray());

        if (!$payment->payment_id) {
            return redirect()->route('payments.failure')->with('error', 'Payment ID generation failed.');
        }

        $callbackUrl = route('callback', ['reference' => $payment->payment_id]);
        \Log::info('Generated Callback URL:', ['url' => $callbackUrl]);

        $chapaData = [
            'amount' => $courseData['course_fee'] * 100,
            'currency' => 'ETB',
            'email' => $studentData['email'],
            'first_name' => $studentData['name'],
            'last_name' => '',
            'phone_number' => $studentData['phone'],
            'callback_url' => $callbackUrl,
            'txn_ref' => uniqid('txn_'),
            'customization[title]' => 'Course Payment',
        ];

        try {
            $client = new Client();
            $response = $client->post('https://api.chapa.co/v1/transaction/initialize', [
                'json' => $chapaData,
                'headers' => [
                    'Authorization' => 'Bearer ' . config('CHAPA_SECRET_KEY'),
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            \Log::info('Chapa API Response:', $responseBody);

            if (isset($responseBody['data']['link'])) {
                $payment->payment_id = $responseBody['data']['id'];
                $payment->save();

                return redirect($responseBody['data']['link']);
            } else {
                return redirect()->route('payments.failure')->with('error', 'Payment initiation failed.');
            }
        } catch (RequestException $e) {
            \Log::error('Chapa Request Exception:', ['error' => $e->getMessage()]);
            return redirect()->route('payments.failure')->with('error', 'Payment initiation failed.');
        }
    }


    /**
     * Handle the callback from Chapa.
     */
    public function callback(Request $request, $reference)
    {
        // Log the callback request for debugging
        \Log::info('Chapa callback received:', $request->all());

        // Find the payment record from the database using the payment reference
        $payment = Payment::where('payment_id', $reference)->first();

        if ($payment) {
            // Update the payment status based on the Chapa callback response
            $payment->status = $request->input('status');
            $payment->save();

            // Clear session data
            session()->forget(['student', 'course']);

            // Redirect to the appropriate page based on the payment status
            if ($request->input('status') === 'successful') {
                return redirect()->route('payments.success')->with('success', 'Payment processed successfully!');
            } else {
                return redirect()->route('payments.failure')->with('error', 'Payment failed. Please try again.');
            }
        }

        return redirect()->route('payments.failure')->with('error', 'Payment record not found.');
    }
}
