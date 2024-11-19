<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use HasFactory,Notifiable, SoftDeletes;

    protected $fillable = [
        'issue',
        'priority',
        'status',
        'feedback',
        'image',
    ];
}
