<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'path','weight','user_id','directory_id'
    ];
    public function user(){
        return $this ->belongsTo('User');    
    }
    public function directory(){
        return $this ->belongsTo('Directory');    
    }
}
