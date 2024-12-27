<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Selection</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="text-center">Select a Course</h4>
                </div>
                <div class="card-body">

                     <!-- Success Message Alert -->
                     @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('courses.stepTwo') }}" method="POST">
                        @csrf
                        <!-- Course Code -->
                        <div class="mb-3">
                            <label for="course_code" class="form-label">Course</label>
                            <select name="course_code" id="course_code" class="form-select" required onchange="showDetails()">
                                <option value="" disabled selected>Choose a course</option>
                                @foreach(App\Models\Course::getCourseCodes() as $code)
                                    <option value="{{ $code }}">{{ $code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course Description (hidden by default) -->
                        <div id="course_description" class="mb-3" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Course Description</h5>
                                </div>
                                <div class="card-body">
                                    <p id="description_text" class="card-text"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <select name="duration" id="duration" class="form-select" required onchange="updateFee()">
                                <option value="" disabled selected>Choose duration</option>
                            </select>
                        </div>

                        <!-- Course Fee -->
                        <div class="mb-3">
                            <label for="course_fee" class="form-label">Course Fee</label>
                            <input type="text" name="course_fee" id="course_fee" class="form-control" readonly>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('students.create') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // JavaScript data for course descriptions, durations, and fees
    const courses = {
        'SW101': {
            description: 'Learn the basics of software development, programming languages, and coding principles.',
            durations: {
                4: { label: '4 weeks', fee: 200 },
                8: { label: '8 weeks', fee: 400 },
                12: { label: '12 weeks', fee: 600 }
            }
        },
        'SW102': {
            description: 'Explore data structures and algorithms that are the foundation of computer science.',
            durations: {
                4: { label: '4 weeks', fee: 300 },
                8: { label: '8 weeks', fee: 600 },
                12: { label: '12 weeks', fee: 900 }
            }
        },
        'SW103': {
            description: 'Understand the concepts of software quality, testing, and assurance techniques.',
            durations: {
                4: { label: '4 weeks', fee: 250 },
                8: { label: '8 weeks', fee: 500 },
                12: { label: '12 weeks', fee: 750 }
            }
        }
    };

    // Function to display course details
    function showDetails() {
        const courseCode = document.getElementById('course_code').value;
        const descriptionText = document.getElementById('description_text');
        const descriptionDiv = document.getElementById('course_description');
        const durationSelect = document.getElementById('duration');
        const feeInput = document.getElementById('course_fee');

        // Clear previous options and fee
        durationSelect.innerHTML = '<option value="" disabled selected>Choose duration</option>';
        feeInput.value = '';

        if (courseCode && courses[courseCode]) {
            // Update course description
            descriptionText.textContent = courses[courseCode].description;
            descriptionDiv.style.display = 'block';

            // Populate durations
            const durations = courses[courseCode].durations;
            for (const [weeks, { label }] of Object.entries(durations)) {
                const option = document.createElement('option');
                option.value = weeks;
                option.textContent = label;
                durationSelect.appendChild(option);
            }
        } else {
            descriptionDiv.style.display = 'none';
        }
    }

    // Function to update fee based on selected duration
    function updateFee() {
        const courseCode = document.getElementById('course_code').value;
        const duration = document.getElementById('duration').value;
        const feeInput = document.getElementById('course_fee');

        if (courseCode && courses[courseCode]) {
            const fee = courses[courseCode].durations[duration]?.fee || '';
            feeInput.value = fee ? fee : '';
        }
    }
</script>

</body>
</html>
