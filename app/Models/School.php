<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'subscription_ends_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function graduationPeriods()
    {
        return $this->hasMany(GraduationPeriod::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
