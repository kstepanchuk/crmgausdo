<?php

use App\Enums\RequestStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('procurement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('requested_by')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default(RequestStatus::Draft->value);
            $table->boolean('is_archived')->default(false);
            $table->foreignId('camp_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('request_template_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
