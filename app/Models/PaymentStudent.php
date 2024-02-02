<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'classroom_id',
        'parent_id',
        'school_fee_id',
        'metode_type',
        'month',
        'proof_of_payment',
    ];

    public function classroom()
    {
        return $this->hasMany(Classroom::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function parent_model()
    {
        return $this->hasMany(ParentModel::class);
    }
    public function school_fee()
    {
        return $this->belongsTo(SchoolFee::class);
    }
}
