<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoiTac extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'ten_doi_tac',
        'dia_chi',
        'sdt',
        'email',
        'loai_doi_tac',
        'ma_so_thue',
        'nguoi_dai_dien',
        'chuc_vu_dai_dien',
        'website',
        'fax',
        'ghi_chu',
    ];
}
