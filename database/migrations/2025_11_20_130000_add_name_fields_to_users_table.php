<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'surname')) {
                $table->string('surname', 191)->after('name');
            }

            if (!Schema::hasColumn('users', 'patronymic')) {
                $table->string('patronymic', 191)->nullable()->after('surname');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'patronymic')) {
                $table->dropColumn('patronymic');
            }
            if (Schema::hasColumn('users', 'surname')) {
                $table->dropColumn('surname');
            }
        });
    }
};

