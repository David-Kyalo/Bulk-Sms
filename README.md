# Bulk SMS Web App

## Introduction

The Bulk SMS Web App is a PHP-based application designed to send bulk SMS messages to multiple recipients. This application leverages a third-party SMS gateway to deliver messages efficiently. It provides a user-friendly interface for managing contacts, composing messages, and sending them in bulk.

## Features

- **User Authentication**: Secure login and registration system.
- **Contact Management**: Add, edit, delete, and group contacts.
- **Compose SMS**: Create and send SMS messages to individual or multiple recipients.
- **Bulk SMS**: Send SMS to a large group of contacts simultaneously.
- **Delivery Reports**: View the status of sent messages.
- **API Integration**: Connect with various SMS gateway APIs for message delivery.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP, WAMP, or similar local server
- An SMS Gateway account (e.g., Twilio, Nexmo)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/David-Kyalo/bulk-sms.git
cd bulk-sms-web
```

### 3. Configure the System

Open the `config/config.php` file and update the database and SMS gateway settings.

### 4. Set Up the Database

Create a new MySQL database and import the provided SQL file.

```bash
mysql -u username -p database_name < database/bulksms.sql
```

### 5. Run the Application

Start your local server or use a tool like XAMPP to serve the application.

### 6. Access the Application

Open your web browser and navigate to `http://localhost/bulk-sms`.

## Usage

### User Authentication

1. Register a new user account.
2. Log in with your credentials.
3. Verify your phone number to enable SMS sending.

### Contact Management

1. Navigate to the "Contacts" section.
2. Create a contact group.
3. Add new contacts to the group.
4. Edit or delete existing contacts.
5. Edit or delete the contact group.

### Composing and Sending SMS

1. Navigate to the "Send SMS" section.
2. Select recipients from your contact groups.
3. Write your message.
4. Click "Send" to dispatch the message.

### Viewing Delivery Reports

1. Navigate to the "History" section.
2. View the status of sent messages and delivery confirmations.

## Troubleshooting

### Common Issues

- **Database Connection Error**: Check your `config/config.php` file for correct database credentials.
- **SMS Delivery Failure**: Ensure your SMS gateway credentials are correct and your account is active.

## Contribution

We welcome contributions! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a Pull Request.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more information.

## Contact

For any queries or support, please contact [dmulei001@outlook.com](mailto:dmulei001@outlook.com).

---

By following this README, you should be able to set up and use the Bulk SMS Web App effectively. If you encounter any issues, feel free to reach out for assistance.
