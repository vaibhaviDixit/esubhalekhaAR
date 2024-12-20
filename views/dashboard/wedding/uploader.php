<?php
// errors(1);

function getImgURL($name){
    $gallery = new Gallery();
    $row=$gallery->getGalleryImg($_REQUEST['id'],$name);
    
    if($row['imageURL']){
        return $row['imageURL'];
    }
    else{
        return false;
    }
    
}

if (!empty($_FILES['hero']['name'])) {
    controller("AWSBucket");
    $awsObj = new AWSBucket();

    controller("Gallery");

    $gallery = new Gallery();

    // Upload to AWS
    $uploadedURL = $awsObj->uploadToAWS($_FILES, 'hero');

    // print_r($uploadedURL);

    // Delete old image from AWS if new image is successfully uploaded
    if (!$uploadedURL['error']) {
        $awsObj->deleteFromAWS(getImgURL('hero'));

        $_REQUEST['imageURL'] = $uploadedURL['url'];    
        $_REQUEST['imageName'] = 'hero';
        $_REQUEST['type'] = 'hero';
        $_REQUEST['weddingID'] = $_REQUEST['id'];

        // Update gallery with the new image
        $addToGallery = $gallery->update($_REQUEST);

        if ($addToGallery['error']) {
            echo json_encode([
                'error' => true,
                'errorMsgs' => $addToGallery['errorMsgs']
            ]);
        } else {
            echo json_encode(['error' => false]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'errorMsg' => $uploadedURL['errorMsg']
        ]);
    }
}
else if (!empty($_FILES['couple']['name'])) {
    controller("AWSBucket");
    $awsObj = new AWSBucket();

    controller("Gallery");

    $gallery = new Gallery();

    // Upload to AWS
    $uploadedURL = $awsObj->uploadToAWS($_FILES, 'couple');

    // print_r($uploadedURL);

    // Delete old image from AWS if new image is successfully uploaded
    if (!$uploadedURL['error']) {
        $awsObj->deleteFromAWS(getImgURL('couple'));

        $_REQUEST['imageURL'] = $uploadedURL['url'];    
        $_REQUEST['imageName'] = 'couple';
        $_REQUEST['type'] = 'couple';
        $_REQUEST['weddingID'] = $_REQUEST['id'];

        // Update gallery with the new image
        $addToGallery = $gallery->update($_REQUEST);

        if ($addToGallery['error']) {
            echo json_encode([
                'error' => true,
                'errorMsgs' => $addToGallery['errorMsgs']
            ]);
        } else {
            echo json_encode(['error' => false]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'errorMsg' => $uploadedURL['errorMsg']
        ]);
    }
}
else if (!empty($_FILES['galleryPic']['name'])) {
    controller("AWSBucket");
    $awsObj = new AWSBucket();

    controller("Gallery");

    $gallery = new Gallery();

    // Upload to AWS
    $uploadedURL = $awsObj->uploadToAWS($_FILES, 'galleryPic');

    // print_r($uploadedURL);

    // Delete old image from AWS if new image is successfully uploaded
    if (!$uploadedURL['error']) {

        $_REQUEST['imageURL'] = $uploadedURL['url'];    
        $_REQUEST['imageName'] = $_FILES['galleryPic']['name'].time();
        $_REQUEST['type'] = 'gallery';
        $_REQUEST['weddingID'] = $_REQUEST['id'];

        // Update gallery with the new image
        $addToGallery = $gallery->update($_REQUEST);

        if ($addToGallery['error']) {
            echo json_encode([
                'error' => true,
                'errorMsgs' => $addToGallery['errorMsgs']
            ]);
        } else {
            echo json_encode(['error' => false]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'errorMsg' => $uploadedURL['errorMsg']
        ]);
    }
}else if (!empty($_FILES['productPic']['name'])) {
    controller("AWSBucket");
    $awsObj = new AWSBucket();

    controller("Gallery");

    $gallery = new Gallery();

    // Upload to AWS
    $uploadedURL = $awsObj->uploadToAWS($_FILES, 'productPic');

    // print_r($uploadedURL);

    // Delete old image from AWS if new image is successfully uploaded
    if (!$uploadedURL['error']) {

        $_REQUEST['imageURL'] = $uploadedURL['url'];  
        $_REQUEST['productID'] = $_REQUEST['cardID'];

        // Update gallery with the new image
        $addToGallery = $gallery->updateProduct($_REQUEST);
        // print_r($addToGallery);

        if ($addToGallery['error']) {
            echo json_encode([
                'error' => true,
                'errorMsgs' => $addToGallery['errorMsgs']
            ]);
        } else {
            echo json_encode(['error' => false]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'errorMsg' => $uploadedURL['errorMsg']
        ]);
    }
}else if (!empty($_FILES['ARPic']['name'])) {
    controller("AWSBucket");
    $awsObj = new AWSBucket();

    controller("Gallery");

    $gallery = new Gallery();

    // Upload to AWS
    $uploadedURL = $awsObj->uploadToAWS($_FILES, 'ARPic');

    // print_r($uploadedURL);

    // Delete old image from AWS if new image is successfully uploaded
    if (!$uploadedURL['error']) {

        $_REQUEST['imageURL'] = $uploadedURL['url'];  
        $_REQUEST['productID'] = $_REQUEST['ARID'];

        // Update gallery with the new image
        $addToGallery = $gallery->updateProduct($_REQUEST);
        // print_r($addToGallery);

        if ($addToGallery['error']) {
            echo json_encode([
                'error' => true,
                'errorMsgs' => $addToGallery['errorMsgs']
            ]);
        } else {
            echo json_encode(['error' => false]);
        }
    } else {
        echo json_encode([
            'error' => true,
            'errorMsg' => $uploadedURL['errorMsg']
        ]);
    }
}


?>
