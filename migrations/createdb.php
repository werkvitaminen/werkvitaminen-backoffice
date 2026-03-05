<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Core/Database.php';

function up() {
    $pdo = App\Core\Database::getInstance();

    // --- 1. Customers ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS customers (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        company_name VARCHAR(255) NOT NULL,
        contact_name VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(50),
        street VARCHAR(255),
        house_number VARCHAR(20),
        postal_code VARCHAR(20),
        city VARCHAR(100),
        country VARCHAR(50),
        billing_street VARCHAR(255),
        billing_house_number VARCHAR(20),
        billing_postal_code VARCHAR(20),
        billing_city VARCHAR(100),
        billing_country VARCHAR(50),
        active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
    ");

    // --- 2. Users ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        email VARCHAR(255),
        password VARCHAR(255),
        role VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
    ");

    // --- 3. Drivers ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS drivers (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        phone VARCHAR(50),
        email VARCHAR(255)
    ) ENGINE=InnoDB;
    ");

    // --- 4. Fruit Box Types ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_box_types (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT
    ) ENGINE=InnoDB;
    ");

    // --- 5. Fruit Types ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_types (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        unit VARCHAR(50)
    ) ENGINE=InnoDB;
    ");

    // --- 6. Routes ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS routes (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        driver_id BIGINT UNSIGNED,
        delivery_day VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (driver_id) REFERENCES drivers(id)
    ) ENGINE=InnoDB;
    ");

    // --- 7. Fruit Boxes ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_boxes (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        customer_id BIGINT UNSIGNED NOT NULL,
        box_type_id BIGINT UNSIGNED NOT NULL,
        delivery_day VARCHAR(20),
        name VARCHAR(255),
        pieces INT,
        notes TEXT,
        active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id),
        FOREIGN KEY (box_type_id) REFERENCES fruit_box_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 8. Fruit Box Type Compositions ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_box_type_compositions (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        box_type_id BIGINT UNSIGNED NOT NULL,
        fruit_type_id BIGINT UNSIGNED NOT NULL,
        default_quantity DECIMAL(10,2),
        FOREIGN KEY (box_type_id) REFERENCES fruit_box_types(id),
        FOREIGN KEY (fruit_type_id) REFERENCES fruit_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 9. Fruit Box Compositions ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_box_compositions (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fruit_box_id BIGINT UNSIGNED NOT NULL,
        fruit_type_id BIGINT UNSIGNED NOT NULL,
        quantity DECIMAL(10,2),
        week INT,
        year INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (fruit_box_id) REFERENCES fruit_boxes(id),
        FOREIGN KEY (fruit_type_id) REFERENCES fruit_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 10. Customer Preferences ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS customer_preferences (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        customer_id BIGINT UNSIGNED NOT NULL,
        fruit_box_type_id BIGINT UNSIGNED,
        fruit_type_id BIGINT UNSIGNED NOT NULL,
        exclude BOOLEAN DEFAULT FALSE,
        adjustment INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id),
        FOREIGN KEY (fruit_box_type_id) REFERENCES fruit_box_types(id),
        FOREIGN KEY (fruit_type_id) REFERENCES fruit_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 11. Deliveries ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS deliveries (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fruit_box_id BIGINT UNSIGNED NOT NULL,
        customer_id BIGINT UNSIGNED NOT NULL,
        route_id BIGINT UNSIGNED,
        delivery_date DATE,
        status VARCHAR(50),
        cancel_reason TEXT,
        created_by BIGINT UNSIGNED,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (fruit_box_id) REFERENCES fruit_boxes(id),
        FOREIGN KEY (customer_id) REFERENCES customers(id),
        FOREIGN KEY (route_id) REFERENCES routes(id),
        FOREIGN KEY (created_by) REFERENCES users(id)
    ) ENGINE=InnoDB;
    ");

    // --- 12. Route Customers ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS route_customers (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        route_id BIGINT UNSIGNED NOT NULL,
        customer_id BIGINT UNSIGNED NOT NULL,
        position INT,
        FOREIGN KEY (route_id) REFERENCES routes(id),
        FOREIGN KEY (customer_id) REFERENCES customers(id)
    ) ENGINE=InnoDB;
    ");

    // --- 13. Fruit Prices ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS fruit_prices (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fruit_type_id BIGINT UNSIGNED NOT NULL,
        week INT,
        year INT,
        price_per_unit DECIMAL(10,2),
        FOREIGN KEY (fruit_type_id) REFERENCES fruit_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 14. Weekly Procurements ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS weekly_procurements (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        week INT,
        year INT,
        fruit_type_id BIGINT UNSIGNED NOT NULL,
        total_quantity DECIMAL(10,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (fruit_type_id) REFERENCES fruit_types(id)
    ) ENGINE=InnoDB;
    ");

    // --- 15. Customer Users ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS customer_users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        customer_id BIGINT UNSIGNED NOT NULL,
        email VARCHAR(255),
        password VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES customers(id)
    ) ENGINE=InnoDB;
    ");

    // --- 16. Lead Statuses ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS lead_statuses (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100)
    ) ENGINE=InnoDB;
    ");

    // --- 17. Lead Batches ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS lead_batches (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;
    ");

    // --- 18. Leads ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS leads (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        company_name VARCHAR(255),
        contact_name VARCHAR(255),
        phone VARCHAR(50),
        email VARCHAR(255),
        status_id BIGINT UNSIGNED,
        batch_id BIGINT UNSIGNED,
        assigned_to BIGINT UNSIGNED,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (status_id) REFERENCES lead_statuses(id),
        FOREIGN KEY (batch_id) REFERENCES lead_batches(id),
        FOREIGN KEY (assigned_to) REFERENCES users(id)
    ) ENGINE=InnoDB;
    ");

    // --- 19. Lead Notes ---
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS lead_notes (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        lead_id BIGINT UNSIGNED NOT NULL,
        user_id BIGINT UNSIGNED NOT NULL,
        content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (lead_id) REFERENCES leads(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    ) ENGINE=InnoDB;
    ");

    echo "All tables created successfully!\n";
}

up();