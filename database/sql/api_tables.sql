-- ============================================================
-- API para Clientes Externos — Psicometrías
-- 6 tablas nuevas para el sistema de API REST
-- Base de datos: aeaamisi_alobri (MySQL)
-- ============================================================

-- 1. api_clients — Tabla central de clientes API
CREATE TABLE IF NOT EXISTS `api_clients` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `contact_email` VARCHAR(255) NOT NULL,
    `contact_phone` VARCHAR(50) NULL,
    `company_id` BIGINT UNSIGNED NULL,
    `client_type` ENUM('token', 'government', 'subscription') NOT NULL,
    `rate_limit_per_minute` INT UNSIGNED NOT NULL DEFAULT 60,
    `webhook_url` VARCHAR(2048) NULL,
    `webhook_secret` VARCHAR(255) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `api_clients_slug_unique` (`slug`),
    KEY `api_clients_company_id_index` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. api_client_billing — Configuración de cobro/cuota por cliente
CREATE TABLE IF NOT EXISTS `api_client_billing` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `api_client_id` BIGINT UNSIGNED NOT NULL,
    -- Para tipo Token:
    `token_balance` INT NOT NULL DEFAULT 0,
    -- Para tipo Suscripción:
    `subscription_plan` VARCHAR(255) NULL,
    `subscription_eval_limit` INT NULL,
    `subscription_evals_used` INT NOT NULL DEFAULT 0,
    `subscription_starts_at` TIMESTAMP NULL DEFAULT NULL,
    `subscription_ends_at` TIMESTAMP NULL DEFAULT NULL,
    `subscription_auto_renew` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `api_client_billing_client_id_index` (`api_client_id`),
    CONSTRAINT `api_client_billing_client_id_foreign`
        FOREIGN KEY (`api_client_id`) REFERENCES `api_clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. api_test_token_costs — Costo en tokens por test
CREATE TABLE IF NOT EXISTS `api_test_token_costs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `test_id` BIGINT UNSIGNED NOT NULL,
    `token_cost` INT UNSIGNED NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `api_test_token_costs_test_id_unique` (`test_id`),
    CONSTRAINT `api_test_token_costs_test_id_foreign`
        FOREIGN KEY (`test_id`) REFERENCES `psico_alobri_tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. api_usage_log — Log inmutable de consumo
CREATE TABLE IF NOT EXISTS `api_usage_log` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `api_client_id` BIGINT UNSIGNED NOT NULL,
    `action` ENUM('evaluation_assigned', 'result_queried', 'pdf_downloaded', 'pdf_webhook_sent') NOT NULL,
    `tokens_consumed` INT NOT NULL DEFAULT 0,
    `test_id` BIGINT UNSIGNED NULL,
    `candidate_user_id` BIGINT UNSIGNED NULL,
    `access_code_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `request_metadata` JSON NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `api_usage_log_client_id_index` (`api_client_id`),
    KEY `api_usage_log_action_index` (`action`),
    KEY `api_usage_log_created_at_index` (`created_at`),
    CONSTRAINT `api_usage_log_client_id_foreign`
        FOREIGN KEY (`api_client_id`) REFERENCES `api_clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. api_webhook_deliveries — Tracking de webhooks
CREATE TABLE IF NOT EXISTS `api_webhook_deliveries` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `api_client_id` BIGINT UNSIGNED NOT NULL,
    `event_type` VARCHAR(255) NOT NULL,
    `payload` JSON NULL,
    `url` VARCHAR(2048) NOT NULL,
    `status` ENUM('pending', 'delivered', 'failed', 'retrying') NOT NULL DEFAULT 'pending',
    `attempts` INT UNSIGNED NOT NULL DEFAULT 0,
    `http_status_code` INT UNSIGNED NULL,
    `response_body` TEXT NULL,
    `next_retry_at` TIMESTAMP NULL DEFAULT NULL,
    `delivered_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `api_webhook_deliveries_client_id_index` (`api_client_id`),
    KEY `api_webhook_deliveries_status_index` (`status`),
    CONSTRAINT `api_webhook_deliveries_client_id_foreign`
        FOREIGN KEY (`api_client_id`) REFERENCES `api_clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. api_candidate_mappings — Mapeo IDs externos ↔ internos
CREATE TABLE IF NOT EXISTS `api_candidate_mappings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `api_client_id` BIGINT UNSIGNED NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `external_candidate_id` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `api_candidate_mappings_client_external_unique` (`api_client_id`, `external_candidate_id`),
    UNIQUE KEY `api_candidate_mappings_client_user_unique` (`api_client_id`, `user_id`),
    CONSTRAINT `api_candidate_mappings_client_id_foreign`
        FOREIGN KEY (`api_client_id`) REFERENCES `api_clients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `api_candidate_mappings_user_id_foreign`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. api_internal_consumers — Plataformas autorizadas para usar la API interna
CREATE TABLE IF NOT EXISTS `api_internal_consumers` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `domain` VARCHAR(255) NULL,
    `secret` VARCHAR(255) NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_used_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `api_internal_consumers_slug_unique` (`slug`),
    UNIQUE KEY `api_internal_consumers_secret_unique` (`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
