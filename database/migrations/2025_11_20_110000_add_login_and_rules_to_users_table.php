<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'login')) {
                $table->string('login', 191)->unique()->after('email');
            }

            if (!Schema::hasColumn('users', 'rules_accepted')) {
                $table->boolean('rules_accepted')->default(false)->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'login')) {
                $table->dropUnique('users_login_unique');
                $table->dropColumn('login');
            }

            if (Schema::hasColumn('users', 'rules_accepted')) {
                $table->dropColumn('rules_accepted');
            }
        });
    }
};

