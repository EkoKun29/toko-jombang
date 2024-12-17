<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpnameGlobal extends Model
{
    use HasFactory;
    protected $table= 'opname_globals';
    public function Audit()
    {
        return $this->hasMany(Audit::class, 'id_opname_global');
    }

    public function totalAudit()
    {
        return $this->Audit()->where('nama_barang', '=', $this->nama_barang);
    }
}
