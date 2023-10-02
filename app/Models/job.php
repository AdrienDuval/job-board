<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class job extends Model
{
    use HasFactory;
    public static array $experiences = ['entry', 'intermediate', 'senior'];
    public static array $jobCategories = [
        'IT', 'Finance', 'Marketing', 'Sales', 'Design', 'Engineering', 'Legal', 'Accounting', 'Other'
    ];

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search  . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        })->when($filters['min_salary'] ?? null, function ($query, $minSalary) {
            $query->where('salary', '>=', $minSalary);
        })->when($filters['max_salary'] ?? null, function ($query, $maxSalary) {
            $query->where('salary', '<=', $maxSalary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', 'like',  $experience);
        })->when($filters['category'] ?? null, function ($query, $jobCategorie) {
            $query->where('category', 'like',  $jobCategorie);
        });
    }
}
