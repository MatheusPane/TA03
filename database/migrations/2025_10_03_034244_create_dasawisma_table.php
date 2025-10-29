    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up()
        {
            Schema::create('dasawisma', function (Blueprint $table) {
                $table->id();
                $table->string('nama'); // contoh: Dasawisma Mawar
                $table->foreignId('dusun_id')->nullable()->constrained('dusun')->nullOnDelete();
                $table->foreignId('ketua_warga_id')->nullable()->constrained('data_warga')->nullOnDelete();
                $table->text('keterangan')->nullable();

                // audit & control
                $table->timestamps();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
                $table->boolean('active')->default(true);
            });
        }

        public function down()
        {
            Schema::dropIfExists('dasawisma');
        }
    };
