<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'museum_item_id',
        'user_id',
        'nama_acara',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'approved_by',
        'approved_at',
        'catatan',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Relasi ke MuseumItem
     */
    public function museumItem(): BelongsTo
    {
        return $this->belongsTo(MuseumItem::class);
    }

    /**
     * Relasi ke User (Panitia)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke User (Staff Verifikator)
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
