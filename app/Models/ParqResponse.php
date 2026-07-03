<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParqResponse extends Model
{
    protected $fillable = [

        'fitness_assessment_id',

        'heart_condition',
        'chest_pain_activity',
        'chest_pain_rest',
        'dizziness_balance',
        'bone_joint_condition',
        'blood_pressure_medication',
        'other_medical_reason',

        'medical_clearance_required',

    ];
}