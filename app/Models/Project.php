<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee;

/**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     title="Project",
 *     required={"employee_id","title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="employee_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Mobile App Update"),
 *     @OA\Property(property="description", type="string", example="Add new features"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ProjectWithEmployee",
 *     type="object",
 *     title="Project with Employee Info",
 *     required={"id","title","employee"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Mobile App Update"),
 *     @OA\Property(property="description", type="string", example="Add new features"),
 *     @OA\Property(
 *         property="employee",
 *         ref="#/components/schemas/Employee"
 *     )
 * )
 */

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'title', 'description'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
