<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->text('description');

        $table->string('priority', 20);
        $table->string('status', 20);

        $table->foreignId('responsible_id')
            ->nullable()
            ->constrained('responsibles')
            ->nullOnDelete();

        $table->timestamp('opened_at');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
