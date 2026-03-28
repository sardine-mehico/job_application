<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_title',
        'first_name',
        'last_name',
        'street_address',
        'suburb',
        'postcode',
        'contact_number',
        'email',
        'work_authorization',
        'work_authorization_other',
        'reliable_transport',
        'drivers_licence',
        'criminal_history',
        'police_clearance',
        'workers_compensation',
        'availability',
        'education',
        'work_history',
        'references',
        'applicant_rank',
        'employer_notes',
    ];

    protected function casts(): array
    {
        return [
            'availability' => 'array',
            'education' => 'array',
            'work_history' => 'array',
            'references' => 'array',
            'applicant_rank' => 'integer',
        ];
    }

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
