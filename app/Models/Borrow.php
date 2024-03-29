<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Borrow extends Model

{
    use HasFactory;
    protected $table = "transaction_borrow";
    protected $dates = [
        'borrow_start',
        'borrow_end'
    ];
    protected $primaryKey = 'transaction_borrow_id';
    protected $fillable = [
        'no_transaction',
        'user_id',
        'book_id',
        'borrow_start',
        'borrow_end',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCustomId($bookId)
    {
        // Get the current datetime
        $currentDatetime = now();

        // Format the ID using 'T{book_id}-{datetime}'
        return 'T' . $bookId . '-'. $currentDatetime->format('YmdHis');
    }
}
