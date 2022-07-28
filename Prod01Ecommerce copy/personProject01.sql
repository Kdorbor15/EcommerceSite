CREATE TABLE product (
  product_id INT(11) NOT NULL AUTO_INCREMENT,
  product_name VARCHAR(255) NOT NULL,
  product_img VARCHAR(255) NOT NULL,
  product_price DECIMAL(10,2) NOT NULL,
  category_name VARCHAR(30) NOT NULL,
  PRIMARY KEY(product_id)
);

CREATE TABLE client (
   client_id INT(11) NOT NULL AUTO_INCREMENT,
   username VARCHAR(255) NOT NULL,
   pwd VARCHAR(255) NOT NULL,
   first_name VARCHAR(255) NOT NULL,
   last_name VARCHAR(255) NOT NULL,
   phone VARCHAR(30),
   email VARCHAR(30) NOT NULL,
   zip VARCHAR(10),
   PRIMARY KEY(client_id)
);

CREATE TABLE cart (
  cart_id INT NOT NULL AUTO_INCREMENT,
  client_id INT NOT NULL,
  PRIMARY KEY(cart_id),
  FOREIGN KEY(client_id) REFERENCES client(client_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE address (
  address_id INT(11) NOT NULL AUTO_INCREMENT,
  client_id INT(11) NOT NULL,
  address_line VARCHAR(255) NOT NULL,
  city varchar(255) NOT NULL,
  zip VARCHAR(10) NOT NULL,
  address_name VARCHAR(30),
  first_name VARCHAR(30) NOT NULL,
  last_name VARCHAR(30) NOT NULL,
  state VARCHAR(30) NOT NULL,
  apt VARCHAR(30),
  PRIMARY KEY(address_id),
  FOREIGN KEY(client_id) REFERENCES client(client_id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE payment (
  payment_id INT(11) NOT NULL AUTO_INCREMENT,
  client_id INT(11) NOT NULL,
  card_number VARCHAR(30) NOT NUll,
  exp_month VARCHAR(11) NOT NULL,
  exp_year VARCHAR(11) NOT NULL,
  cvc INT(11) NOT NULL,
  first_name VARCHAR(30) NOT NULL,
  last_name VARCHAR(30) NOT NULL,
  PRIMARY KEY(payment_id),
  FOREIGN KEY(client_id) REFERENCES client(client_id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE orders (
  order_id INT(11) NOT NULL AUTO_INCREMENT,
  client_id INT(11) NOT NULL,
  address_id INT(11) NOT NULL,
  payment_id INT(11) NOT NULL,
  status VARCHAR(50) NOT NULL,
  order_date VARCHAR(50) NOT NULL,
  quantity INT(11) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  PRIMARY KEY(order_id),
  FOREIGN KEY(client_id) REFERENCES client(client_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(address_id) REFERENCES address(address_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(payment_id) REFERENCES payment(payment_id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE cart_item (
  cart_item_id INT(11) NOT NULL AUTO_INCREMENT,
  cart_id INT(11) NOT NULL,
  product_id INT(11) NOT NULL,
  quantity INT(11) NOT NUll,
  size varchar(30) NOT NULL,
  PRIMARY KEY(cart_item_id),
  FOREIGN KEY(cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(product_id) REFERENCES product(product_id) ON DELETE CASCADE ON UPDATE CASCADE
);




