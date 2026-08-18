# PRVTS - Progress Report Viva Tracking System

![PRVTS Dashboard Preview](https://img.shields.io/badge/Status-Active-brightgreen) ![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue) ![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange)

The **Progress Report Viva Tracking System (PRVTS)** is a comprehensive web-based application designed for the **Ghazali Shafie Graduate School of Government (GSGSG)** at **Universiti Utara Malaysia (UUM)**. 

It streamlines the management and tracking of postgraduate students (Masters, PhD, DBA) throughout their research journey—from proposal submission and examination panel assignment to the final viva-voce and graduation.

> 📖 **Comprehensive User Manual & Handbook**: For full feature walkthroughs, UI navigation, and step-by-step operational guides, refer to [USER_MANUAL.md](USER_MANUAL.md).

---

## 🚀 Key Features

- **Interactive Dashboard & Severity Alerts**:
  - Visual charts (Chart.js) for school, degree level, and research status distributions.
  - **Color-Coded Priority Badges**: Distinct alerts for Upcoming Viva Sessions (Blue), Pending Honorarium Payments (Green), Corrections Due Soon (Yellow), and Overdue Corrections (Red).
  - **Academic Staff Pending Responses**: Dedicated tracking for pending examiner confirmations/reports and supervisor endorsements with direct contact phone/email links.
  - **Quick Resolve / Checkmark Action**: Mark alerts as complete directly from the dashboard, backed by persistent resolution tracking (`alert_resolutions`).

- **Student Details & Remarks Timeline**:
  - Complete tracking of student details, viva arrangements, post-viva corrections, and institutional approvals.
  - **Dedicated Remarks Tab**: Post timestamped notes and feedback on student profiles.
  - **File Attachments**: Upload and download supporting documents (PDF, Word, Images, ZIP, Excel up to 10MB) with inline media previews.

- **Academic Staff Management**:
  - Registry for supervisors and internal/external examiners.
  - **Contact Details**: Phone number fields for all staff with direct clickable `tel:` links.
  - **Examiner Classification**: Distinguish examiners as **Internal** or **External** with styled tags and modal selectors.

- **Modern Bulk Export & Multi-Parameter Filtering**:
  - **Modern Excel Layout**: Executive styling with navy title banners (`#0F172A`), metric summary cards, styled column headers, auto-adjusted column widths, and zebra row shading.
  - **Viva Date Sorting**: Sort reports by viva date (Earliest, Latest, or Jan–Dec Month order).
  - **Multi-Parameter Filter Panel**: Filter student lists and bulk exports prior to download by **Viva Month**, **Viva Year**, **School/Department**, **Degree Level**, and **Research Status**.
  - Bulk PDF (Dompdf) and Excel (PhpSpreadsheet) exports dynamically reflect active filters.

- **Bulk Import**:
  - Batch import students directly from Excel/CSV files.

- **Security & Authentication**:
  - Role-based access control for Admin and Staff.
  - Admin-managed user accounts and password resets.
  - Forced password change on first login.
  - Secure session management and environment configuration.

---

## 🛠️ Technology Stack

- **Backend**: Vanilla PHP 8+ using a custom MVC architecture.
- **Database**: MySQL 8+
- **Frontend**: HTML5, Vanilla CSS3, JavaScript (ES6+).
- **Styling**: Bootstrap 5 (with Bootstrap Icons) and custom modern CSS.
- **Libraries**:
  - `dompdf/dompdf` - For generating PDF reports.
  - `phpoffice/phpspreadsheet` - For generating and reading Excel spreadsheets.
  - `chart.js` - For dashboard data visualizations.

---

## ⚙️ Installation & Setup

1. **Prerequisites**: 
   - Local server environment (XAMPP, WAMP, or MAMP with PHP 8.0+ and MySQL 8.0+).
   - Composer installed.

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
   - Copy `.env.example` to `.env`.
   - Update `APP_URL` to match your local path (e.g. `http://localhost/PRV_Tracking_System`).
   - Configure database credentials (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).

5. **Database Setup & Migrations**:
   - Open phpMyAdmin or MySQL CLI.
   - Create database `prvts_db`.
   - Import `database/schema.sql` for the full schema setup.
   - *(For existing database upgrades)*: Run `database/migration_v2.sql`.
   - Optionally import `database/seed.sql` for sample data.

6. **Run the Application**:
   - Open your browser to `http://localhost/PRV_Tracking_System`.
   - Default login credentials (if seeded):
     - Username: `admin`
     - Password: `password` (You will be prompted to change this on first login).

---

## 📂 Project Structure

- `app/`
  - `Controllers/` - Request handlers (StudentController, StaffController, ExportController, DashboardController, etc.).
  - `Core/` - Router, Database singleton, Base Controller, Middleware, App boot.
  - `Models/` - Database access objects (Student, Supervisor, Examiner, Remark, VivaRecord, Correction, Graduation).
  - `Views/` - HTML/PHP templates (students, staff, export, dashboard, layouts, errors).
- `config/` - App and database settings.
- `database/` - `schema.sql`, `seed.sql`, and `migration_v2.sql`.
- `public/` - Public entry point (`index.php`), CSS/JS assets, and `uploads/remarks/`.
- `vendor/` - Composer libraries.

---

## 📄 License

This project is intended for internal academic management use. All rights reserved by the respective institution.
