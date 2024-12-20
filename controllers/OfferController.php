<?php

class Offer
{
    protected $offerID;
    protected $name;
    protected $code;
    protected $startDate;
    protected $endDate;
    protected $offer;
    protected $cards;
    protected $themes;
    protected $ar;
    protected $users;

    // Create operation
    public function create($data)
    {
        DB::connect();
        $this->name = trim(DB::sanitize($data['name']));
        $this->code = trim(DB::sanitize($data['code']));
        $this->offerID = md5(md5($this->name.$this->code).md5(time().uniqid()));
        $this->startDate = trim(DB::sanitize($data['startDate']));
        $this->endDate = trim(DB::sanitize($data['endDate']));
        $this->offer = floatval(trim(DB::sanitize($data['offer'])));

        $this->cards = json_encode($data['cards']); 
        $this->themes = json_encode($data['themes']); 
        $this->ar = json_encode($data['ar']); 
        $this->users = json_encode($data['users']); 
        DB::close();

        // Data to insert into DB
        $offerData = array(
            'offerID' => $this->offerID,
            'name' => $this->name,
            'code' => $this->code,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'offer' => $this->offer,
            'cards' => $this->cards,
            'themes' => $this->themes,
            'ar' => $this->ar,
            'users' => $this->users
        );

        // Insert offer into DB
        DB::connect();
        $createOffer = DB::insert('offers', $offerData);
        DB::close();

        if ($createOffer) {
            return ['error' => false, 'message' => 'Offer created successfully'];
        } else {
            return ['error' => true, 'errorMsgs' => ['createOffer' => 'Failed to create offer']];
        }
    }

    // Check if an offer exists by offer ID
    public function checkOfferExists($offerID)
    {
        DB::connect();
        $getOffer = DB::select('offers', '*', "offerID = '$offerID'")->fetch();
        DB::close();

        return $getOffer ? true : false;
    }

    // Retrieve offer details by offer ID
    public function getOfferById($offerID)
    {
        DB::connect();
        $offer = DB::select('offers', '*', "offerID = '$offerID'")->fetch();
        DB::close();

        if ($offer) {
            return $offer;
        } else {
            return ['error' => true, 'errorMsgs' => ['getOffer' => 'Offer not found']];
        }
    }

    // Retrieve all offers
    public function getAllOffers()
    {
        DB::connect();
        $offers = DB::select('offers', '*')->fetchAll();
        DB::close();

        if ($offers) {
            return $offers;
        } else {
            return ['error' => true, 'errorMsgs' => ['getAllOffers' => 'No offers found']];
        }
    }

    // Update offer details
    public function update($offerID, $data)
    {
        DB::connect();
        $name = trim(DB::sanitize($data['name']));
        $code = trim(DB::sanitize($data['code']));
        $startDate = trim(DB::sanitize($data['startDate']));
        $endDate = trim(DB::sanitize($data['endDate']));
        $offer = floatval(trim(DB::sanitize($data['offer'])));

        $this->cards = json_encode($data['cards']); 
        $this->themes = json_encode($data['themes']); 
        $this->ar = json_encode($data['ar']); 
        $this->users = json_encode($data['users']); 
        DB::close();

        DB::connect();
        $updateOffer = DB::update('offers', [
            'name' => $name,
            'code' => $code,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'offer' => $offer,
            'cards' => $this->cards,
            'themes' => $this->themes,
            'ar' => $this->ar,
            'users' => $this->users

        ], "offerID = '$offerID'");
        DB::close();

        if ($updateOffer) {
            return ['error' => false, 'message' => 'Offer updated successfully'];
        } else {
            return ['error' => true, 'errorMsgs' => ['updateOffer' => 'Failed to update offer']];
        }
    }

    // Delete an offer
    public function deleteOffer($offerID)
    {
        DB::connect();
        $deleteOffer = DB::delete('offers', "offerID = '$offerID'");
        DB::close();

        if ($deleteOffer) {
            return ['error' => false, 'message' => 'Offer deleted successfully'];
        } else {
            return ['error' => true, 'errorMsgs' => ['deleteOffer' => 'Failed to delete offer']];
        }
    }
}
