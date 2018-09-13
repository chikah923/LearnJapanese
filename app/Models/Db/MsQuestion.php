<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class MsQuestion extends Model
{
    protected $fillable = ['level', 'category', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'answer','explanation'];


}
