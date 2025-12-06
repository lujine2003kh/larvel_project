<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Employee",
 *     type="object",
 *     title="Employee",
 *     required={"name","email","phone"},
 * 
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Lujine"),
 *     @OA\Property(property="email", type="string", example="lujine@gmail.com"),
 *     @OA\Property(property="phone", type="string", example="+9626118158"),
 *     @OA\Property(property="position", type="string", example="Developer"),
 *
 *     @OA\Property(
 *         property="projects",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Project")
 *     ),
 *
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */


class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'position'];

    public function projects(){
        return $this->hasmany(Project::class);
    }
}
