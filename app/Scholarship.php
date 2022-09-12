<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;
    protected $table = 'scholarships';
    protected $fillable = ['roll_no', 'scholarship_sem', 'scholarship_amount'];
    public $timestamps=false;
}
