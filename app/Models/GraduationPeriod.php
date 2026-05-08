<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduationPeriod extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'tanggal_pengumuman',
        'is_active',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pengumuman' => 'date',
        'is_active' => 'boolean'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
