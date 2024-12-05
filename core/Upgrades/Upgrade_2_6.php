<?php
namespace WeDevs\PM\Core\Upgrades;

/**
*   Upgrade project manager 3.0
*/
class Upgrade_2_6 {
    /*initialize */
    public function upgrade_init() {
        $this->create_tasks_checklist_table();
    }


    /**
     * Set page access capability for admin user
     *
     * @since 1.0
     *
     * @return void
     */
    public function create_tasks_checklist_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'pm_tasks_checklist';

      
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
			  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) NOT NULL,
			  `created_by` int(11) UNSIGNED DEFAULT NULL,
			  `updated_by` int(11) UNSIGNED DEFAULT NULL,
			  `created_at` timestamp NULL DEFAULT NULL,
			  `updated_at` timestamp NULL DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";

        dbDelta($sql);
    }


}
