<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetProject extends Model
{
    protected $table = 'budget_projects';
    // protected $primaryKey = 'id';
    // public $incrementing = false; // false = ไม่ใช้ options auto increment
    // public $timestamps = false; // false = ไม่ใช้ field updated_at และ created_at

    public function plan()
    {
        return $this->belongsTo(BudgetPlan::class, 'plan_id', 'id');
    }
}
