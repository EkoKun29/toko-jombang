<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    protected $table= 'audits';

    
    public function OpnameGlobal()
    {
        return $this->belongsTo(OpnameGlobal::class, 'id_opname_global');
    }
}
