<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MuseumItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'kategori',
        'asal',
        'tahun',
        'deskripsi',
        'foto',
        'status',
    ];

    /**
     * Relasi ke LoanRequest
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class);
    }
}
