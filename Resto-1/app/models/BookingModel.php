<?php


class BookingModel extends AbstracModel
{
    const MAX_SEATS = 25;
    const SHIFTS = [
                        "midi",
                        "soir",
                    ];

    public function findTakeASeatsByDateAndShift($date, $shift)
    {
        $query=$this->pdo->prepare(
                                    "SELECT SUM(seatCount)
                                                FROM `Booking` 
                                                WHERE bookingDate = :date
                                                AND shift = :shift" );
        $query->execute([
                           "date"=> $date,
                           "shift"=> $shift,
                        ]);

        return $query->fetch(PDO::FETCH_COLUMN) ;
    }

    public function create($userId, $date, $shift, $seatCount)
    {
        $query = $this->pdo->prepare("INSERT INTO Booking
                                                (user_id, seatCount, bookingDate, shift)
                                                VALUES 
                                                (:userId, :seatCount, :date, :shift)") ;
        $query->execute([
            "userId" => $userId,
            "seatCount" => $seatCount,
            "date" => $date,
            "shift" => $shift,
        ]) ;
    }
}