<?php

declare(strict_types=1);

use App\Models\Exam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table): void {
            $table->id();
            $table->string("label");
            $table->string("description")->nullable();

            $table->timestamps();
        });

        Exam::query()->create(["label"=> "Visite Médicale"]);
        Exam::query()->create(["label"=> "Code de la route"]);
        Exam::query()->create(["label"=> "Code de Conduite"]);
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
