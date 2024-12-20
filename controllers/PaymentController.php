<?php


class Payment
{   
    protected $paymentID;
    protected $userID;
    protected $weddingID;

    // Create operation
    public function create($data)
    {
        DB::connect();
        $this->paymentID = trim(DB::sanitize($data['paymentID']));
        $this->userID = strtolower(trim(DB::sanitize($data['userID'])));
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->lang = trim(DB::sanitize($data['lang']));
        DB::close();

        // Check if payment already exists
        if ($this->checkPaymentExists($this->userID, $this->weddingID,$this->lang)) {
            return ['error' => true, 'errorMsgs' => ['createPayment' => 'Payment already exists for this user and wedding']];
        }

        $data = array(
                'paymentID' => $this->paymentID,
                'userID' => $this->userID,
                'weddingID' => $this->weddingID,
                'lang' => $this->lang,
                'paidAt' => date('Y-m-d H:i:s'),
            );


            DB::connect();
            $createPayment = DB::insert('payments', $data);
            DB::close();

            if ($createPayment) {
                $this->error = false;
                $this->errorMsgs['createPayment'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createPayment'] = 'Payment updation failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Payment successful'];
            }

    }

    // Function to check if payment exists
    public function checkPaymentExists($userID, $weddingID,$lang)
    {

        DB::connect();
        $getPayment = DB::select('payments', '*', "userID = '$userID' and weddingID='$weddingID' and lang='$lang' ")->fetch();
        DB::close();

        if ($getPayment) {
            return true; // Payment exists
        } else {
            return false; // Payment does not exist
        }
    }

    public function getPaymentByID($weddingID,$userID)
    {   
        DB::connect();
        $getPay = DB::select('payments', '*', "weddingID = '$weddingID' and userID = '$userID'")->fetch();
        DB::close();
        if ($getPay)
            return $getPay;
        else
            return ['error' => true, "errorMsgs" => ['user' => "Payment Not Found"]];
    }


    
}
