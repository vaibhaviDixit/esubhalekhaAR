CREATE TABLE partners (
    userID VARCHAR(255),
    businessName VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    pinCode VARCHAR(10) NOT NULL,
    bankName VARCHAR(255) NOT NULL,
    bankAccountNumber VARCHAR(50) NOT NULL,
    ifscCode VARCHAR(20) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    createdAt DATETIME,
    updatedAt DATETIME,
    FOREIGN KEY (userID) REFERENCES users(userID)
);
