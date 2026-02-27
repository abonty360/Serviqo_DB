# Serviqo: Home-Service Booking Platform

This is a **Home-Service Booking and Management Platform** intended to connect customers with verified service providers offering on-demand services.

The platform will allow customers to search for services, place service requests, schedule appointments, make payments, and submit feedback after service completion. Service providers will be able to register on the system, manage service listings, set pricing, and handle service orders efficiently.

---

## Features

- Customer registration and profile management
- Location-based filtering of services and service providers
- Service category and subservice management
- Service order placement and scheduling
- Order status tracking
- Rating and review submission by customers
- A scalable and normalized database structure

---


## Installation

1. **Clone the repository**

```bash
git clone https://github.com/abonty360/Serviqo_DB.git
cd Serviqo
```
2. **Install composer**
   
```bash
composer install
```
3. **Generate Key**
   
```bash
cp .env.example .env
php artisan key:generate
```
4. **Connect to Database (SQL)**

5. **Migrate Tables**

```bash
php artisan migration
```
   
7. **Run The Project**
   
```bash
   php artisan serve
```
