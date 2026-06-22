<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = ['id'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function jalur() {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_id');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}