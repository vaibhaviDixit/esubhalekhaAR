<?php

class ARInvite
{
    protected $ARID;
    protected $name;
    protected $price;
    protected $eventDate;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->errors = "";
    }

    // Get ARInvite by ARID
    public static function getARInviteByID($ARID)
    {
        DB::connect();
        $ARID = DB::sanitize($ARID);
        $getInvite = DB::select('ARInvites', '*', "ARID = '$ARID'")->fetch();
        DB::close();
        if ($getInvite) {
            return $getInvite;
        } else {
            return ['error' => true, 'errorMsgs' => ['invite' => 'ARInvite Not Found']];
        }
    }

    // Get all ARInvites
    public static function getARInvites()
    {
        DB::connect();
        $invites = DB::select('ARInvites', '*')->fetchAll();
        DB::close();
        if ($invites) {
            return $invites;
        } else {
            return ['error' => true];
        }
    }

    // Create a new ARInvite
    public function create($name, $price, $eventDate = null)
    {
        DB::connect();
        // Sanitize and prepare the data for inserting into the database
        $this->name = trim(DB::sanitize($name));
        $this->price = trim(DB::sanitize($price));
        $this->eventDate = $eventDate ? DB::sanitize($eventDate) : null;
        DB::close();

        $inviteData = [
            'ARID' => uniqid('AR_'), // Unique ARID generation
            'name' => $this->name,
            'price' => $this->price,
            'eventDate' => $this->eventDate,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        // Insert the new ARInvite record into the database
        DB::connect();
        $createInvite = DB::insert('ARInvites', $inviteData);
        DB::close();

        if ($createInvite) {
            return ['success' => true, 'ARID' => $inviteData['ARID']];
        } else {
            return ['error' => true, 'errorMsgs' => ['createInvite' => 'Failed to create ARInvite']];
        }
    }

    // Edit an existing ARInvite
    public function update($ARID, $data)
    {
        // Sanitize input data
        DB::connect();
        $this->name = trim(DB::sanitize($data['name']));
        $this->price = trim(DB::sanitize($data['price']));
        $this->eventDate = isset($data['eventDate']) ? DB::sanitize($data['eventDate']) : null;
        DB::close();

        // Validate that the ARInvite exists
        $invite = self::getARInviteByID($ARID);
        if ($invite['error']) {
            return $invite; // ARInvite not found
        }

        $updateData = [
            'name' => $this->name,
            'price' => $this->price,
            'eventDate' => $this->eventDate,
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        DB::connect();
        $updateInvite = DB::update('ARInvites', $updateData, "ARID = '$ARID'");
        DB::close();

        if ($updateInvite) {
            return $updateData;
        } else {
            return ['error' => true, 'errorMsgs' => ['updateInvite' => 'ARInvite update failed']];
        }
    }

    // Delete an ARInvite
    public function deleteARInvite($ARID)
    {
        // Check if the ARInvite exists
        $invite = self::getARInviteByID($ARID);
        if ($invite['error']) {
            return $invite; // ARInvite not found
        }

        // Perform the delete operation
        DB::connect();
        $deleteInvite = DB::delete('ARInvites', "ARID = '$ARID'");
        DB::close();

        if ($deleteInvite) {
            return ['success' => true, 'message' => "$ARID successfully deleted"];
        } else {
            return ['error' => true, 'errorMsgs' => ['deleteInvite' => 'Failed to delete ARInvite']];
        }
    }

    // Check if an ARInvite with the same name already exists
    public static function checkInviteName($name)
    {
        DB::connect();
        $name = DB::sanitize($name);
        $result = DB::select('ARInvites', '*', "name = '$name'")->fetchAll();
        DB::close();
        return count($result);
    }
}
