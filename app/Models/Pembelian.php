<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pembelian',
        'tgl_pembelian',
        'id_supplier',
        'total_bayar'
    ];

    protected $table = 'pembelian';

    public static function createCode()
    {
        $latestCode = self::orderBy('kode_pembelian', 'desc')->value('kode_pembelian');
        $latestCodeNumber = intval(substr($latestCode, 2));
        $nextCodeNumber = $latestCodeNumber ? $latestCodeNumber + 1 : 1;
        $formattedCodeNumber = sprintf("%05d", $nextCodeNumber);
        return 'B' . $formattedCodeNumber;
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }
}
