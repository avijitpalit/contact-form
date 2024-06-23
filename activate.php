<?

// define('FORM_TABLE', 'scf_forms');
// define('ENTRIES_TABLE', 'scf_entries');

# Create table upon activation
register_activation_hook(PLUGIN_FILE, 'handle_activation');
function handle_activation(){
    debug('activated');
    error_log('activated');
    global $wpdb;
    $table_name = $wpdb->prefix . FORM_TABLE;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(100) NOT NULL,
        active boolean NOT NULL DEFAULT false,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name = $wpdb->prefix . ENTRIES_TABLE;
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        form_id mediumint(9),
        field_label varchar(100) DEFAULT '',
        field_type varchar(50) DEFAULT 'text',
        field_content varchar(50) DEFAULT '',
        PRIMARY KEY (id),
        FOREIGN KEY (form_id) REFERENCES ". $wpdb->prefix . FORM_TABLE ."(id) ON DELETE SET NULL
    ) $charset_collate;";
     
    dbDelta($sql);
}

register_deactivation_hook(PLUGIN_FILE, 'handle_deactivation');
function handle_deactivation(){
    global $wpdb;
    // $form_table = $wpdb->prefix . FORM_TABLE;
    // $entries_table = $wpdb->prefix . ENTRIES_TABLE;
    $sql = sprintf("DROP TABLE IF EXISTS %s, %s;", $wpdb->prefix . FORM_TABLE, $wpdb->prefix . ENTRIES_TABLE);
    $result = $wpdb->query($sql);
}