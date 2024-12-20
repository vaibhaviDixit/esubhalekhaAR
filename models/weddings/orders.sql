CREATE TABLE orders (
    id  VARCHAR(255) PRIMARY KEY NOT NULL,
    userID VARCHAR(255),
    cart JSON,
    offer VARCHAR(255),
    totalAmount DECIMAL(10, 2),
    eventDate TIMESTAMP NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES users(userID),
    FOREIGN KEY (offer) REFERENCES offers(offerID)
);
