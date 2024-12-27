<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function showPaymentPage(Request $request)
    {
        // Fetch student and course info directly from the session
        $student = $request->session()->get('student');
        $course = $request->session()->get('course');



        // If the session data is missing, redirect to the previous step
        if (!$student || !$course) {
            return redirect()->route('students.create')->with('error', 'Please complete the registration process first.');
        }

        // Pass data to the payment view
        return view('payments.payment', compact('student', 'course'));
    }


    /**
     * Show payment success page.
     */
    public function showSuccessPage()
    {
        return view('payments.payment_success');
    }

    /**
     * Show payment failure page.
     */
    public function showFailurePage()
    {
        return view('payments.payment_failure');
    }
}
