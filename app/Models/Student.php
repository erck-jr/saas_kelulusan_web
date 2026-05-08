<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'school_class_id',
        'graduation_period_id',
        'status',
        'nilai_rata_rata',
        'catatan'
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function graduationPeriod()
    {
        return $this->belongsTo(GraduationPeriod::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
