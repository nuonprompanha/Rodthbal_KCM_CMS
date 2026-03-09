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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('email_verified_at');
        });

        // Existing users are considered already approved
        \DB::table('users')->update(['is_approved' => true]);

        Schema::create('department_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_department_id')->constrained('user_departments')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'user_department_id']);
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_permission_id')->constrained('user_permissions')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'user_permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('department_user');
    }
};
