<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSession extends Model
{
    use HasFactory;

    protected $table = "meeting_sessions";
    protected $guarded = [];
}
