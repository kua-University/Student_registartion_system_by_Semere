{{-- resources/views/payments/payment.blade.php --}}
@extends('layout') {{-- Extend the layout file directly in the views directory --}}

@section('content') {{-- Start the content section --}}
    <div class="container mt-5">
        <h2>Payment Page</h2>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Student and Course Details</h4>
                <p>N.B: please carefully check your information and if you are sure please confirm to make payment!</p>
            </div>
            <div class="card-body">
                <!-- Display Student Details -->
                <h5>Student Information</h5>
                <p><strong>Name:</strong> {{ $student['name'] ?? 'N/A' }}</p>
                <p><strong>Age:</strong> {{ $student['age'] ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $student['email'] ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $student['phone'] ?? 'N/A' }}</p>

                <hr>

                <!-- Display Course Details -->
                <h5>Course Information</h5>
                <p><strong>Course Code:</strong> {{ $course['course_code'] }}</p>
                <p><strong>Duration:</strong> {{ $course['duration'] }} weeks</p>
                <p><strong>Course Fee:</strong> ${{ $course['course_fee'] }}</p>
            </div>
        </div>

        <form action="{{ route('pay') }}" method="POST">
            @csrf <!-- Include CSRF token for security -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('courses.create') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Pay Now</button>
            </div>
        </form>
    </div>
@endsection {{-- End the content section --}}
