# Irembo AI-POWERED

A sophisticated AI-powered application system for government documents.

## Features
- **AI Document Analysis**: Automatically compare and detect forgery in legal documents using OpenAI GPT-4 Vision.
- **Unified Dashboard**: Manage various application types (National ID, Driving License, Passports, etc.) from a single admin panel.
- **Status Notifications**: Integrated email system using PHPMailer to notify applicants of status updates.
- **Secure Processing**: Automated verification workflows for government services.

## Project Structure
- `adminsection/`: Admin panel and backend management.
- `citizensection/`: User-facing application portal.
- `backendcodes/`: Core logic and database connection files.
- `database/`: SQL scripts for database initialization.
- `systemimages/`: Storage for sample documents for AI comparison.

## Technologies Used
- **PHP**
- **MySQL**
- **OpenAI API (GPT-4 Vision)**
- **PHPMailer**
- **Bootstrap & SweetAlert**

## Installation
1. Clone the repository to your local server (e.g., XAMPP htdocs).
2. Import the database from `database/iremboaipowered.sql`.
3. Configure your database credentials in `backendcodes/connection.php`.
4. Add your OpenAI API key in `adminsection/sectionincludes/allapplications.php`.

## License
Created for Irembo AI-POWERED Service.
