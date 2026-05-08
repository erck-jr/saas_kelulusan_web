<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'mata_pelajaran',
        'nilai_akhir',
        'nilai_ujian',
        'nilai_sekolah',
        'catatan'
    ];

    protected $casts = [
        'nilai_akhir' => 'float',
        'nilai_ujian' => 'float',
        'nilai_sekolah' => 'float'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
