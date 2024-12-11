<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_penjualan',
        'tgl_penjualan',
        'id_konsumen',
        'status_pembelian',
        'total_bayar',
        'total_jual',
        'id_user'
    ];

    protected $table = 'penjualan';

    public static function createCode()
    {
        $latestCode = self::orderBy('kode_penjualan', 'desc')->value('kode_penjualan');
        $latestCodeNumber = intval(substr($latestCode, 2));
        $nextCodeNumber = $latestCodeNumber ? $latestCodeNumber + 1 : 1;
        $formattedCodeNumber = sprintf("%05d", $nextCodeNumber);
        return 'J' . $formattedCodeNumber;
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id');
    }
}
