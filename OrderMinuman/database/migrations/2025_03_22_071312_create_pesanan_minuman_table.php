<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pesanan_minuman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan', 100);
            $table->enum('jenis_minuman', [
                'Thai Tea', 'Green Tea', 'Milk Tea', 'Dark Choco', 'Vanilla Latte',
                'Mocca Latte', 'Mango Yakult', 'Lychee Tea', 'Peach Tea'
            ]);
            $table->enum('suhu', ['Hot', 'Ice']);
            $table->enum('gula', ['25%', '50%', '100%']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_minuman');
    }
};
