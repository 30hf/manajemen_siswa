
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('classroom_id')->constrained('classrooms');
            $table->foreignId('parent_id')->constrained('parent_models');
            $table->foreignId('school_fee_id')->constrained('school_fees');
            $table->enum('metode_type', ['cash','credit']);
            $table->enum('month', ['january','february','march','april','may','june','july','august','september','october','november','december']);
            $table->text('proof_of_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_students');
    }
};

