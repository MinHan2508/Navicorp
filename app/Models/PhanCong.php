<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanCong extends Model
{
    use HasFactory;

    /**
     * Get the user associated with the PhanCong.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the phongban associated with the PhanCong.
     */
    public function phongban()
    {
        return $this->belongsTo(PhongBan::class);
    }
   

}
