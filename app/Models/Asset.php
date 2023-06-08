<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';
    // protected $primaryKey = 'id';
    // public $incrementing = false; // false = ไม่ใช้ options auto increment
    // public $timestamps = false; // false = ไม่ใช้ field updated_at และ created_at

    public function type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id', 'id');
    }
}