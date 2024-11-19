Pastimes README
Project Overview
This web application is designed for managing a clothing store. It allows users to register, log in, view available clothing items, place orders and request selling of items. Admin users can verify, update or delete user accounts and clothing inventory.
Key Features:
•	User Registration: Users can create accounts, which require admin approval.
•	User Login: Users can log in after being verified by an admin.
•	Clothing Management: Admins can manage clothing inventory, including adding, deleting and updating clothing items.
•	Order Processing: Users can place orders for clothing items.
•	View History: Users can view their order history.
•	Request selling of clothes: Users can send request to sell	 clothes that can then be approved, rejected or deleted by the administer.
Database Tables:
•	tblAdmin: Stores admin information (AdminID, AdminName, AdminEmail, Password).
•	tblClothes: Stores clothing item details (ClothingID, ClothingName, Category, Price, StockQuantity, ProductImage).
•	tblmessages: store messages between admin and users (message_id, sender_id, receiver_id, message_content, timestamp)
•	tblorders: Stores order information (OrderID, UserID, ClothingID, OrderDate, Quantity, TotalPrice).
•	tblorderline: 	Stores the whole order session once user has checked or adding more items (OrderID, orderNum, ClothingID, Quantity, Price, OrderDate, sessionId)
•	tblsellrequests: Store request by user to sell items on the website(request_id, UserID, name, brand, category, description, price, image_path, status, submitted_at) 
•	tblUser: Stores user information (UserID, UserName, Email, Password, status).
Getting Started
Prerequisites
1.	PHP Environment: Ensure you have a local server setup (like XAMPP or WAMP) to run PHP files.
2.	Database: MySQL should be set up, and you should have access to create databases and tables.
Installation
1.	Clone the Repository: Download or clone the project files to your local server directory.(wamp/www/clothingStoreProject)
2.	Database Connection: Ensure the DBConn.php file is correctly configured to connect to your MySQL database.
3.	Create Database Tables:
a.	Run loadClothingStore.php to create the necessary database tables. This script will drop existing tables (if any) and create new ones based on the defined structure.
Place the following text files in the same directory as your PHP scripts:
•	adminData.txt: Contains data for admin accounts.
•	userData.txt: Contains data for user accounts.
•	clothesData.txt: Contains data for clothing items.
Each text file should be formatted as CSV (comma-separated values) for the script to read correctly.


 
Running the Application
1.	Start your local server.
2.	Open a web browser and navigate to the login page (login.php).
3.	Users can register through the register.php page, while admins can log in using adminLogin.php.
4.	No user is verified so is user registered, log into admin to verify them
Admin login are as follows:
Admin: Varlene 	Password: Password123
Admin: Sihle  		Password: Password456

5.	After verifying user, you can the login and begin Shopping.	
User logins are as follows:
User: John Doe	Email: j.doe@abc.co.za	Password: Password123
User: Tom Riddle	Email: tom.riddle@hogwarts.edu	Password: Password123
User: Harry Potter	Email: harry.potter@wizardingworld.com
Password: Password123
User: Hermione Grang	Email: hermione.granger@hogwarts.edu	
Password: Password123

6.	The navigation bar will take all available features to user.
 	 



 
Common Errors
•	Database Connection Issues: If you encounter connection errors, check the DBConn.php file for correct database credentials.
•	File Not Found Errors: Ensure that userData.txt, adminData.txt, and clothesData.txt files exist in the project directory.
•	Empty Fields: If you submit forms with empty fields, you'll receive validation errors.
•	Unverified Users: Users must wait for admin verification to log in successfully. If they try to log in before being verified, they will receive an error message.
•	 during execution.
Conclusion
This web application provides a basic framework for managing a clothing store's user and inventory systems. Feel free to customize and expand upon this application to suit your specific needs.

