CREATE TABLE IF NOT EXISTS `agency_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inquiry_id` bigint(20) unsigned NOT NULL,
  `agency_id` bigint(20) unsigned NOT NULL,
  `agency_name` varchar(255) NOT NULL,
  `recipient_type` enum('User','Administrator') NOT NULL,
  `comment` text NOT NULL,
  `supporting_document` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agency_notes_inquiry_id_recipient_type_index` (`inquiry_id`,`recipient_type`),
  KEY `agency_notes_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `agency_notes_agency_id_index` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
