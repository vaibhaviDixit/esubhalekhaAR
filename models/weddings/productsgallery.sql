CREATE TABLE productsgallery (
    imageID VARCHAR(255) PRIMARY KEY NOT NULL,
    imageURL VARCHAR(255) NOT NULL,
    uploadedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    productID VARCHAR(255)  -- This can reference both tables smartCard and ARInvites
);
