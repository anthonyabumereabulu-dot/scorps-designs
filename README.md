# Scorps Designs — Business Website

A dynamic business website developed for **Scorps Designs**, a creative design and decoration company. The platform provides an online presence for the business and includes customer-facing pages, account functionality, project management features and administrative tools.

## Project Overview

Scorps Designs offers creative services including painting, mural art, architectural beautification, graphic design and decorative artwork.

This project was developed to help the business present its services online and make customer interactions and project management more organised.

## Features

- **Business website:** Home, About, Services and Projects pages.
- **User authentication:** Customer registration, login and logout.
- **Project management:** Customers can submit project requests.
- **Customer dashboard:** View project-related information and progress.
- **Contact system:** Contact form with PHP processing.
- **Administrative tools:** Manage and view customer messages and project records.
- **Database integration:** MySQL database connectivity and data handling.

## Technologies Used

| Technology | Purpose |
|---|---|
| HTML5 | Website structure |
| CSS3 | Styling and layout |
| JavaScript | Client-side interactivity |
| PHP | Server-side functionality |
| MySQL | Database management |

**Development tools:** Visual Studio Code, XAMPP and phpMyAdmin.

## Project Structure

```text
scorps-designs/
│
├── home.html
├── about.html
├── services.html
├── projects.html
├── contact.html
├── login.html
│
├── signup.php
├── login.php
├── logout.php
├── contact.php
├── dashboard.php
├── create_project.php
├── database.php
│
├── view_customers.php
├── view_messages.php
├── view_projects.php
│
├── *.css
├── homescript.js
└── images/
```

*The image folder above represents the image assets included in the repository; filenames may differ.*

## Running the Project Locally

The project currently runs locally and is not publicly hosted.

### Requirements

- XAMPP
- PHP
- MySQL
- A web browser

### Installation

1. Clone or download this repository.
2. Move the project folder into the XAMPP `htdocs` directory.
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Create the database required by the application.
6. Set up the required database tables using your project's database schema.
7. Update `database.php` with your local database connection settings.
8. Open the website in your browser:

```text
http://localhost/scorps-designs/
```

**Note:** The repository currently includes a sample SQL insert file, not a complete database schema export. The database tables must be created before all database-dependent features can work.

## Learning Outcomes

Working on this project provided practical experience in:

- Building multi-page websites.
- Connecting frontend interfaces to PHP backend functionality.
- Implementing user authentication.
- Working with MySQL databases.
- Handling form submissions and user input.
- Developing features around real business requirements.
- Debugging and testing applications in a local development environment.

## Project Status

## Screenshots

### Homepage
![Homepage](screenshots/homepage.png.png)

### Login Page
![Login Page](screenshots/login.png.png)

### Customer Dashboard
![Dashboard](screenshots/dashboard.png.jpg)

**Status:** Developed and running locally.

**Hosting:** Not yet deployed.

## Developer

**Anthony Abumere Abulu**  
Software Engineering Student | Junior Software Developer

[GitHub Profile](https://github.com/anthonyabumereabulu-dot)

---

*Developed as a practical business web development project for Scorps Designs.*
