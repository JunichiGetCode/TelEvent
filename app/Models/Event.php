<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',      // Relasi ke user
        'title',
        'type',
        'start_date',
        'end_date',
        'proposal',
        'timeline',     // Menyimpan nama file (string), bukan relasi tabel
        'budgeting',    // Menyimpan nama file (string), bukan relasi tabel
        'poster',
        'other_data',
        'status',
    ];

    // Relasi ke User (Pemilik Event) - INI WAJIB ADA
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi timelines() dan budgetItems() SUDAH DIHAPUS
    // agar error "Class not found" hilang.
}