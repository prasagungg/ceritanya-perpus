<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBorrow extends Model
{
    use HasFactory;

    public $table = "transaction_borrow";

    protected $fillable = [
        'no_transaction',
        'user_id',
        'book_id',
        'borrow_start',
        'borrow_end',
        'return_on',
    ];

    public static function generateCustomId($bookId)
    {
        // Get the current datetime
        $currentDatetime = now();

        // Format the ID using 'T{book_id}-{datetime}'
        return 'T' . $bookId . '-'. $currentDatetime->format('YmdHis');
    }
}
