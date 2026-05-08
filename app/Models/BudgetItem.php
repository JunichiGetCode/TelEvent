<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',       
        'amount',     
        'category',   
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}