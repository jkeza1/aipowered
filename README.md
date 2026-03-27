<div align="center">

# Irembo AI-POWERED

**Automate, verify, and secure government document workflows with advanced AI and robust PHP/Python integration.**

** [Access the Deployed Application](https://aipowered.gamer.gd/login.php) **

![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![Python](https://img.shields.io/badge/Python-3.10+-yellow?logo=python)
![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-orange?logo=tensorflow)
![Build](https://img.shields.io/badge/build-passing-brightgreen)
![License](https://img.shields.io/badge/license-Custom-lightgrey)

</div>

---

## Table of Contents
- [About](#about)
- [Live Demo](#live-demo)
- [Features](#features)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Tech Stack](#tech-stack)
- [Screenshots](#screenshots)
- [Environment Variables](#environment-variables)
- [Contributing](#contributing)
- [License](#license)
- [👥 Authors](#-authors)
- [Acknowledgements](#acknowledgements)

---

## About
Irembo AI-POWERED addresses the challenge of document fraud in government services by combining ML-based forgery detection with a full citizen/admin workflow. The system automates verification, reduces manual review, and increases trust in digital document processing for government and public sector applications.

---

## Live Demo
** [Access the Deployed Application](https://aipowered.gamer.gd/login.php) **

---

## Features

- **AI Document Forgery Detection** (EfficientNetB0, TensorFlow 2.x)
- **Unified Admin Dashboard** for all document types
- **Automated Email Notifications** (PHPMailer)
- **Role-based Access** (Admin/Citizen)
- **Extensive Dataset Support** (CASIA2, Synthetic, Real Samples)
- **Modular PHP Backend** for easy extension
- **FastAPI Python Service** for ML inference
- **Secure Database Integration** (MySQL)
- **Comprehensive Testing & Reporting**

---

## Project Structure

```
/
├── adminsection/                # Admin panel, document management, models
│   ├── models/                  # Trained ML models (.keras, .pkl)
│   ├── sectionincludes/         # Admin PHP includes
│   └── ...                      # Document type folders, PHP scripts
├── backendcodes/                # PHP business logic, DB connection, PHPMailer
├── CASIA2/                      # Forensic dataset (Au/Tp)
├── citizensection/              # Citizen portal (empty/placeholder)
├── css/, js/, scss/             # Frontend assets
├── database/                    # SQL files, DB scripts
├── output/                      # Model outputs, plots
├── samples_documents/           # Real-world sample docs & metadata
├── synthetic_documents/         # Generated synthetic docs
├── tests/                       # Test scripts
├── app.py                       # FastAPI ML inference server
├── Document_Verification_ML_Model version 2.ipynb # ML model notebook
├── index.php, login.php, signup.php, adminlogin.php, userdashboard.php
└── README.md
```

---

## Installation

### Prerequisites

- **PHP 8.x** with MySQLi extension
- **Python 3.10+** (with TensorFlow 2.x, FastAPI, Uvicorn)
- **XAMPP/LAMP** or compatible stack

### Steps

1. **Clone the repository** to your server:
   ```sh
   git clone <repo-url> aipowered
   ```
2. **Import the database** using `database/iremboaipowered.sql` in phpMyAdmin.
3. **Configure your environment variables** in a `.env` file at the project root:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=your_password
   DB_NAME=iremboaipowered
   ```
   > **Security Warning:** Never commit your `.env` file or credentials to version control.
4. **Set up Python environment**:
   ```sh
   cd aipowered
   python -m venv .venv
   .venv\Scripts\activate
   pip install -r requirements.txt
   ```
5. **Start the FastAPI server**:
   ```sh
   uvicorn app:app --host 127.0.0.1 --port 8001
   ```
6. **Run the PHP server** (e.g., via XAMPP/Apache).

---

## Usage

- **Admin Panel:**  
  Visit `/adminlogin.php` to manage and verify applications.
- **Citizen Portal:**  
  Register/login at `/signup.php` or `/login.php` to submit and track applications.
- **API Example (Python):**
  ```python
  import requests
  file = {'file': open('test_id.png', 'rb')}
  r = requests.post('http://127.0.0.1:8001/verify', files=file)
  print(r.json())
  ```

---

## Tech Stack

- ![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php) PHP 8.x
- ![Python](https://img.shields.io/badge/Python-3.10+-yellow?logo=python) Python 3.10+
- ![TensorFlow](https://img.shields.io/badge/TensorFlow-2.x-orange?logo=tensorflow) TensorFlow 2.x
- ![FastAPI](https://img.shields.io/badge/FastAPI-0.95+-green?logo=fastapi) FastAPI
- ![MySQL](https://img.shields.io/badge/MySQL-8.x-blue?logo=mysql) MySQL
- PHPMailer, Bootstrap, SweetAlert

---

## Screenshots
![Dashboard](screenshots/dashboard.png)
![Verification](screenshots/verify.png)

---

## Environment Variables
| Variable    | Description         | Default     |
|-------------|---------------------|-------------|
| DB_HOST     | Database host       | localhost   |
| DB_USER     | Database user       | root        |
| DB_PASSWORD | Database password   | (set in .env)|
| DB_NAME     | Database name       | iremboaipowered |
| OPENAI_KEY  | OpenAI API key      | (set in .env)|

---

## 👥 Authors
- **Joan keza** — [@github](https://github.com/jkeza1/aipowered.git)

---

## Acknowledgements
- CASIA2 Forensic Dataset
- EfficientNetB0 Architecture
- Irembo Government Services

---

## License

This project is proprietary and created for Irembo AI-POWERED Service.
Some components (e.g., PHPMailer) are under their respective open-source licenses.
