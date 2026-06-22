<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    protected $guarded = ['id'];

    public function registrations() {
        return $this->hasMany(Registration::class, 'jalur_id');
    }
}