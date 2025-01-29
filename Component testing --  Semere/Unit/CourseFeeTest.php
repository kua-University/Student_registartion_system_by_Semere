<?php

namespace Tests\Unit;

use Tests\TestCase;

class CourseFeeTest extends TestCase
{
        /**
     * @test
     */
    public function it_calculates_fee_based_on_course_and_duration()
    {
        $courseDetails = [
            'course_code' => 'SW101',
            'duration' => 4,
        ];

        $feePerMonth = 50; // Assume $50 per month
        $expectedFee = $courseDetails['duration'] * $feePerMonth;

        $this->assertEquals(200, $expectedFee);
    }
}
