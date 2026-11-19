<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalamanUtama extends Model
{
    use HasFactory;

    protected $table = 'halamanutama';
    protected $primaryKey = 'id_halamanutama';
    protected $guarded = [];
}
