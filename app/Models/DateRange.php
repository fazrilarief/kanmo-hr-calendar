<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRange extends Model
{
    use HasFactory;

    protected $fillable = ['key_activity_id', 'start_date', 'end_date'];

    public function activity()
    {
        return $this->belongsTo(KeyActivity::class);
    }
}
