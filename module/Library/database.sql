-- drop table loan_outs;
-- drop table book_copies;
-- drop table location;
-- drop table owner;
-- drop table book;

CREATE TABLE book (
        id int NOT NULL auto_increment,
        author text NOT NULL,
        title text NOT NULL,
        summary text,
        year int(4),
        isbn text,
        PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE location (
    id int NOT NULL auto_increment,
    name text NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE owner (
    id int NOT NULL auto_increment,
    name text NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE book_copies (
  `id` int NOT NULL auto_increment,
  `book_id` int NOT NULL,
  `additional_id` text comment 'Additional id used by the location to identify multiple copies of the same book',
  `condition` int NOT NULL comment '1 = perfect, 5 = good, 10 = bad, 15 = needs exchange',
  `comment` text,
  `lost` BOOL NOT NULL,
  `location_id` int,
  `owner_id` int,
  PRIMARY KEY (id),
  FOREIGN KEY (book_id) REFERENCES book(id) ON DELETE CASCADE,
  FOREIGN KEY (location_id) REFERENCES location(id) ON DELETE SET NULL,
  FOREIGN KEY (owner_id) REFERENCES owner(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- The current loan out is the one which has stop set to null but start set to something.
CREATE TABLE loan_outs (
    `id` int NOT NULL auto_increment,
    `book_copy_id` int NOT NULL,
    `loan_out_to` text,
    `start` DATETIME,
    `stop` DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (book_copy_id) REFERENCES book_copies(id) ON DELETE CASCADE
) ENGINE=InnoDB;