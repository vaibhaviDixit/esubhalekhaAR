-- wedding Payments Table
CREATE TABLE payments(
    paymentID VARCHAR(255) PRIMARY KEY NOT NULL,
    userID VARCHAR(255),
    weddingID VARCHAR(255),
    lang ENUM('as', 'bn', 'gu', 'hi', 'kn', 'ml', 'mr', 'ne', 'or', 'pa', 'ta', 'te', 'ur', 'en') DEFAULT 'en',
    paidAt DATETIME,
    FOREIGN KEY (userID) REFERENCES users(userID),
    FOREIGN KEY (weddingID) REFERENCES weddings(weddingID)
)