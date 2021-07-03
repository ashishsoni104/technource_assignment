<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use SoftDeletes;
    //
    protected $table = 'employee';
    //
    protected $fillable = [
        'first_name', 'last_name', 'email','phone','company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
