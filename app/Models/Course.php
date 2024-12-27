<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_code',
        'duration',
        'course_fee',
    ];

    // Define options for each attribute
    public static function getCourseCodes()
    {
        return [
            'SW101' => 'SW101',
            'SW102' => 'SW102',
            'SW103' => 'SW103',
        ];
    }

    public static function getDurations()
    {
        return [
            4 => '4 weeks',
            8 => '8 weeks',
            12 => '12 weeks',
        ];
    }

    public static function getFees()
    {
        return [
            500.00 => '$500',
            1000.00 => '$1000',
            1500.00 => '$1500',
        ];
    }
}
