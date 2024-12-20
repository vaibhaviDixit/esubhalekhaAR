CREATE TABLE offers (
    offerID VARCHAR(255) PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(100) NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    offer DECIMAL(5,2) NOT NULL,
    cards TEXT,     -- Store "all" or a JSON array of card IDs
    ar TEXT,        -- Store "all" or a JSON array of AR invite IDs
    themes TEXT,    -- Store "all" or a JSON array of theme IDs
    users TEXT      -- Store "all" or a JSON array of user IDs
);
