<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee;

class Project extends Model
{
   use HasFactory;

    protected $fillable = ['employee_id', 'title', 'description'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
