<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    protected $table = 'room_reservations';
    protected $fillable = [
        'room_id',
        'guest_id',
        'room_res_date',
        'room_res_source',
        'room_res_status',
    ];
    
protected $casts = [
        'room_res_date' => 'datetime',
    ];


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

   public function stayDetail() {
    return $this->hasOne(
        GuestStayDetail::class,
        'reservation_id', // foreign key on guest_stay_details
        'id'               // local key on room_reservations
    );
}

public function isCheckedOut(): bool
{
    return $this->room_res_status === 'checked_out';
}


}
