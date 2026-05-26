<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'school_id',
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
