<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = true;
    
    // REMOVED: protected $keyType = 'int'; (Let Laravel guess it)

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'quantity', 
        'unit', 
        'type', 
        'branch', 
        'img_dir'
    ];
}