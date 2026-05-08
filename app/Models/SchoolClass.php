<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'nama_kelas',
        'jurusan',
        'tingkat',
        'wali_kelas',
        'graduation_period_id'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function graduationPeriod()
    {
        return $this->belongsTo(GraduationPeriod::class);
    }
}
