<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::table('users', function(Blueprint $table){ $table->string('phone')->nullable()->after('password'); $table->string('avatar')->nullable()->after('phone'); $table->string('status')->default('active')->after('avatar'); $table->softDeletes(); }); } public function down(): void { Schema::table('users', fn(Blueprint $table)=>$table->dropColumn(['phone','avatar','status','deleted_at'])); } };
