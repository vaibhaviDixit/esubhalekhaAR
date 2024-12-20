<?php

class Partners
{
    protected $db;
    protected $partnerID;
    protected $businessName;
    protected $city;
    protected $address;
    protected $pincode;
    protected $bankDetails;
    protected $status;
    protected $phone;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->errors = "";
    }

    public static function getPartnerByPhone($phone)
    {   
        DB::connect();
        $getPartner = DB::select('partners', '*', "phone = '$phone' and status <> 'deleted'")->fetch();
        DB::close();
        if ($getPartner)
            return $getPartner;
        else
            return ['error' => true, "errorMsgs" => ['partner' => "Partner Not Found"]];
    }

    public function checkPhone($phone)
    {
        DB::connect();
        $result = DB::select('partners', '*', "phone = '$phone' and status <> 'deleted'")->fetchAll();
        DB::close();
        return count($result);
    }


    public static function getPartner($partnerID)
    {   
        DB::connect();
        $partnerID = DB::sanitize($partnerID);
        $getPartner = DB::select('partners', '*', "userID = '$partnerID' and status <> 'deleted'")->fetch();
        DB::close();
        if ($getPartner)
            return $getPartner;
        else
            return ['error' => true, "errorMsgs" => ['partner' => "Partner Not Found"]];
    }

    public static function getPartners()
    {
        DB::connect();
        $partners = DB::select('partners', '*', "status <> 'deleted'")->fetchAll();
        DB::close();
        if ($partners)
            return $partners;
        else
            return ['error' => true];
    }

    public function create($userID)
    {

        // Prepare the data for inserting into the database
        $partnerData = [
            'userID' => $userID,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];

        // Insert the new partner record into the database
        DB::connect();
        $createPartner = DB::insert('partners', $partnerData);
        DB::close();

        // Check if the partner creation was successful
        if ($createPartner) {
            return ['success' => true, 'partnerID' => $partnerID];
        } else {
            return ['error' => true, 'errorMsgs' => ['createPartner' => 'Failed to create partner']];
        }
    }



    public function editPartner($partnerID, $data)
    {
        DB::connect();
        $this->businessName = trim(DB::sanitize($data['businessName']));
        $this->city = trim(DB::sanitize($data['city']));
        $this->address = trim(DB::sanitize($data['address']));
        $this->pincode = trim(DB::sanitize($data['pincode']));
        $this->bankName = trim(DB::sanitize($data['bankName']));
        $this->bankAccountNumber = trim(DB::sanitize($data['bankAccountNumber']));
        $this->ifscCode = trim(DB::sanitize($data['ifscCode']));
        DB::close();

        $fields = [
            'userID' => [
                'values' => $partnerID,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Invalid Partner',
                        'validate' => function () use ($partnerID) {
                            return $this->getPartner($partnerID);
                        },
                    ]
                ]
            ]
        ];

        $validate = Validator::validate($fields);
        if ($validate['error']) {
            return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
        } else {
            $updateData = [
                'businessName' => $this->businessName,
                'city' => $this->city,
                'address' => $this->address,
                'pincode' => $this->pincode,
                'bankName' => $this->bankName,
                'bankAccountNumber' => $this->bankAccountNumber,
                'ifscCode' => $this->ifscCode,
                'updatedAt' => date('Y-m-d H:i:s'),
            ];

            DB::connect();
            $updatePartner = DB::update('partners', $updateData, "userID = '$partnerID'");
            DB::close();

            if ($updatePartner) {
                return $updateData;
            } else {
                return ['error' => true, 'errorMsgs' => ['updatePartner' => 'Partner account update failed']];
            }
        }
    }


    public function deletePartner($partnerID)
    {
        $check = $this->getPartner($partnerID);
        if ($check['error']) {
            return $check;
        }

        $data = ['status' => 'deleted'];

        DB::connect();
        $deletePartner = DB::update('partners', $data, "userID = '$partnerID'");
        DB::close();

        if (!$deletePartner) {
            return ['error' => true, 'errorMsgs' => ['deletePartner' => 'Failed to delete partner']];
        } else {
            return ['error' => false, 'message' => "$partnerID successfully deleted"];
        }
    }
}
