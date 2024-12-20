<?php

class SmartCard
{
    protected $cardID;
    protected $name;
    protected $price;
    protected $eventDate;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->errors = "";
    }

    // Get SmartCard by cardID
    public static function getSmartCardByID($cardID)
    {
        DB::connect();
        $cardID = DB::sanitize($cardID);
        $getCard = DB::select('smartCard', '*', "cardID = '$cardID'")->fetch();
        DB::close();
        if ($getCard) {
            return $getCard;
        } else {
            return ['error' => true, 'errorMsgs' => ['card' => 'SmartCard Not Found']];
        }
    }

    // Get all SmartCards
    public static function getSmartCards()
    {
        DB::connect();
        $cards = DB::select('smartCard', '*')->fetchAll();
        DB::close();
        if ($cards) {
            return $cards;
        } else {
            return ['error' => true];
        }
    }

    // Create a new SmartCard
    public function create($name, $price, $eventDate = null)
    {
         DB::connect();
        // Sanitize and prepare the data for inserting into the database
        $this->name = trim(DB::sanitize($name));
        $this->price = trim(DB::sanitize($price));
        $this->eventDate = $eventDate ? DB::sanitize($eventDate) : null;
         DB::close();

        $cardData = [
            'cardID' => uniqid('card_'), // Unique cardID generation
            'name' => $this->name,
            'price' => $this->price,
            'eventDate' => $this->eventDate,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        // Insert the new smartCard record into the database
        DB::connect();
        $createCard = DB::insert('smartCard', $cardData);
        DB::close();

        if ($createCard) {
            return ['success' => true, 'cardID' => $cardData['cardID']];
        } else {
            return ['error' => true, 'errorMsgs' => ['createCard' => 'Failed to create smart card']];
        }
    }

    // Edit an existing SmartCard
    public function update($cardID, $data)
    {
        // Sanitize input data
        DB::connect();
        $this->name = trim(DB::sanitize($data['name']));
        $this->price = trim(DB::sanitize($data['price']));
        $this->eventDate = isset($data['eventDate']) ? DB::sanitize($data['eventDate']) : null;
        DB::close();

        // Validate that the smartCard exists
        $card = self::getSmartCardByID($cardID);
        if ($card['error']) {
            return $card; // SmartCard not found
        }

        $updateData = [
            'name' => $this->name,
            'price' => $this->price,
            'eventDate' => $this->eventDate,
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        DB::connect();
        $updateCard = DB::update('smartCard', $updateData, "cardID = '$cardID'");
        DB::close();

        if ($updateCard) {
            return $updateData;
        } else {
            return ['error' => true, 'errorMsgs' => ['updateCard' => 'SmartCard update failed']];
        }
    }

    // Delete a SmartCard
    public function deleteSmartCard($cardID)
    {
        // Check if the smart card exists
        $card = self::getSmartCardByID($cardID);
        if ($card['error']) {
            return $card; // SmartCard not found
        }

        // Perform the delete operation
        DB::connect();
        $deleteCard = DB::delete('smartCard', "cardID = '$cardID'");
        DB::close();

        if ($deleteCard) {
            return ['success' => true, 'message' => "$cardID successfully deleted"];
        } else {
            return ['error' => true, 'errorMsgs' => ['deleteCard' => 'Failed to delete smart card']];
        }
    }

    // Check if a SmartCard with the same name already exists
    public static function checkCardName($name)
    {
        DB::connect();
        $name = DB::sanitize($name);
        $result = DB::select('smartCard', '*', "name = '$name'")->fetchAll();
        DB::close();
        return count($result);
    }
}
