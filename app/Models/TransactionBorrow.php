<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBorrow extends Model
{
    use HasFactory;

    public $table = "transaction_borrow";

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_start',
        'borrow_end',
        'return_on',
    ];

}
