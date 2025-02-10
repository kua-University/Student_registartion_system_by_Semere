# Test Report

## Summary
- **Total Tests**: 20
- **Assertions**: 28
- **Errors**: 0
- **Warnings**: 1
- **Failures**: 10
- **Skipped**: 0
- **Time**: 1.817336 seconds

---

## Test Suites

### Unit Tests
- **Total Tests**: 5
- **Assertions**: 7
- **Errors**: 0
- **Warnings**: 0
- **Failures**: 2
- **Skipped**: 0
- **Time**: 0.423170 seconds

#### Tests\Unit\CourseFeeTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Unit/CourseFeeTest.php`
- **Tests**: 1
- **Assertions**: 1
- **Failures**: 0
- **Time**: 0.184388 seconds

  - **Test Case**: `it_calculates_fee_based_on_course_and_duration`  
    - **Status**: Passed

#### Tests\Unit\CourseSelectionTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Unit/CourseSelectionTest.php`
- **Tests**: 1
- **Assertions**: 3
- **Failures**: 0
- **Time**: 0.080183 seconds

  - **Test Case**: `it_validates_course_selection`  
    - **Status**: Passed

#### Tests\Unit\ExampleTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Unit/ExampleTest.php`
- **Tests**: 1
- **Assertions**: 1
- **Failures**: 0
- **Time**: 0.000607 seconds

  - **Test Case**: `test_example`  
    - **Status**: Passed

#### Tests\Unit\PaymentTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Unit/PaymentTest.php`
- **Tests**: 2
- **Assertions**: 2
- **Failures**: 2
- **Time**: 0.157993 seconds

  - **Test Case**: `it_displays_student_and_course_details`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [200] but received 500.  
    - **Error**: `RuntimeException: Session store not set on request.`

  - **Test Case**: `it_validates_payment_submission`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [200] but received 500.  
    - **Error**: `RuntimeException: Session store not set on request.`

---

### Feature Tests
- **Total Tests**: 15
- **Assertions**: 21
- **Errors**: 0
- **Warnings**: 1
- **Failures**: 8
- **Skipped**: 0
- **Time**: 1.394166 seconds

#### Tests\Feature\ChapaPaymentTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/ChapaPaymentTest.php`
- **Tests**: 2
- **Assertions**: 3
- **Failures**: 2
- **Time**: 0.563610 seconds

  - **Test Case**: `it_initializes_payment_and_redirects_to_chapa`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [201, 301, 302, 303, 307, 308] but received 500.  
    - **Error**: `RuntimeException: Session store not set on request.`

  - **Test Case**: `it_verifies_payment_and_creates_student_and_payment_records`  
    - **Status**: Failed  
    - **Failure**: Failed asserting that two strings are equal.  
    - **Expected**: `'http://localhost/payments/payment_success'`  
    - **Actual**: `'http://localhost'`

#### Tests\Feature\ExampleTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/ExampleTest.php`
- **Tests**: 1
- **Assertions**: 1
- **Failures**: 0
- **Time**: 0.022517 seconds

  - **Test Case**: `test_example`  
    - **Status**: Passed

#### Tests\Feature\NavigationTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/NavigationTest.php`
- **Tests**: 1
- **Assertions**: 0
- **Warnings**: 1
- **Time**: 0.011720 seconds

  - **Test Case**: `Warning`  
    - **Warning**: No tests found in class "Tests\Feature\NavigationTest".

#### Tests\Feature\PerformanceTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/PerformanceTest.php`
- **Tests**: 3
- **Assertions**: 3
- **Failures**: 1
- **Time**: 0.185025 seconds

  - **Test Case**: `testHomePageResponseTime`  
    - **Status**: Passed

  - **Test Case**: `testSpecificPageResponseTime`  
    - **Status**: Passed

  - **Test Case**: `testSimulatedLoad`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [200] but received 404.

#### Tests\Feature\StudentTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/StudentTest.php`
- **Tests**: 3
- **Assertions**: 7
- **Failures**: 1
- **Time**: 0.217868 seconds

  - **Test Case**: `it_displays_the_registration_form`  
    - **Status**: Passed

  - **Test Case**: `it_validates_form_inputs`  
    - **Status**: Passed

  - **Test Case**: `it_saves_valid_student_data_to_session`  
    - **Status**: Failed  
    - **Failure**: Session is missing expected key [student].

#### Tests\Feature\SystemTest
- **File**: `/Applications/MAMP/htdocs/student-registration-system/tests/Feature/SystemTest.php`
- **Tests**: 5
- **Assertions**: 7
- **Failures**: 4
- **Time**: 0.393425 seconds

  - **Test Case**: `a_student_can_complete_registration_process`  
    - **Status**: Failed  
    - **Failure**: Failed asserting that two strings are equal.  
    - **Expected**: `'http://localhost/courses/create'`  
    - **Actual**: `'http://localhost'`

  - **Test Case**: `a_student_can_select_a_course`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [200] but received 500.  
    - **Error**: `Undefined variable: errors`

  - **Test Case**: `a_student_can_complete_payment`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [200] but received 500.  
    - **Error**: `RuntimeException: Session store not set on request.`

  - **Test Case**: `guests_cannot_access_payment_page`  
    - **Status**: Failed  
    - **Failure**: Expected response status code [201, 301, 302, 303, 307, 308] but received 500.  
    - **Error**: `RuntimeException: Session store not set on request.`

  - **Test Case**: `registration_page_loads_under_2_seconds`  
    - **Status**: Passed

---

## Conclusion
- **Total Failures**: 10
- **Total Warnings**: 1
- **Most Common Issue**: Session store not set on request (causing 500 errors).
- **Recommendation**: Ensure session handling is properly configured in the test environment.
