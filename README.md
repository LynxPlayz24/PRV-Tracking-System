# PRVTS - Postgraduate Research & Viva Tracking System

![PRVTS Dashboard Preview](https://img.shields.io/badge/Status-Active-brightgreen) ![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue) ![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange)

The **Postgraduate Research & Viva Tracking System (PRVTS)** is a comprehensive web-based application designed for the **Ghazali Shafie Graduate School of Government (GSGSG)** at **Universiti Utara Malaysia (UUM)**. 

It streamlines the management and tracking of postgraduate students (Masters, PhD, DBA) throughout their research journey—from proposal submission and examination panel assignment to the final viva-voce and graduation.

## 🚀 Features

- **Dashboard Analytics**: Visual overviews of student statuses, viva statistics, and degree-level distributions using Chart.js.
- **Student Management**: Complete tracking of a student's academic and research milestones.
- **Viva-Voce Tracking**: Manage examination panel assignments (internal/external examiners), viva dates, and final outcomes.
- **Post-Viva Corrections**: Track correction deadlines, review statuses, and thesis endorsements.
- **Institutional Approvals**: Monitor JIL (Jawatankuasa Pengajian Siswazah) and Senate meeting statuses leading up to graduation.
- **Bulk Import/Export**: 
  - Import large batches of students via Excel/CSV.
  - Export comprehensive summary reports in bulk to **PDF** (via Dompdf) and **Excel** (via PhpSpreadsheet).
- **Staff Management**: Maintain a registry of academic supervisors and internal/external examiners.
- **Role-based Authentication**: Secure access for Admin and Staff roles.

## 🛠️ Technology Stack

- **Backend**: Vanilla PHP 8+ using a lightweight, custom-built MVC architecture.
- **Database**: MySQL 8+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla).
- **Styling**: Bootstrap 5 (with Bootstrap Icons) and custom CSS.
- **Libraries**:
  - `dompdf/dompdf` - For generating PDF reports.
  - `phpoffice/phpspreadsheet` - For generating and reading Excel files.
  - `chart.js` - For dashboard data visualizations.

## ⚙️ Installation & Setup

1. **Prerequisites**: 
   - A local server environment like XAMPP, WAMP, or MAMP.
   - Composer installed on your machine.

2. **Clone the Repository**:
   ```bash
   git clone https://github.com/LynxPlayz24/PRV-Tracking-System.git
   cd PRV-Tracking-System
   ```

3. **Install Dependencies**:
   ```bash
   composer install
   ```

4. **Environment Setup**:
   - Copy `.env.example` to `.env` (if provided, otherwise configure database directly in `config/database.php`).
   - Ensure the `APP_URL` in `.env` points to your local project path (e.g., `http://localhost/PRV_REPORT_TRACKING`).

5. **Database Configuration**:
   - Open phpMyAdmin (e.g., `http://localhost/phpmyadmin`).
   - Create a new database named `prvts_db`.
   - Import `database/schema.sql` to structure the database.
   - Import `database/seed.sql` to populate it with sample data (optional).

6. **Run the Application**:
   - Access the application via your browser: `http://localhost/PRV_REPORT_TRACKING`
   - Default login credentials (if seeded):
     - Username: `admin`
     - Password: `password`

## 📂 Project Structure

- `app/` - Contains the MVC architecture (Controllers, Models, Views, Core routing logic).
- `config/` - Database and application configuration files.
- `database/` - SQL schema and seed files for easy setup.
- `public/` - Publicly accessible files (Assets: CSS, JS, images, and the main `index.php` entry point).
- `vendor/` - Composer dependencies.

## 📄 License

This project is intended for internal academic management use. All rights reserved by the respective institution.
