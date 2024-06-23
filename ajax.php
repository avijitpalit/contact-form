<?

# Add form
add_action('wp_ajax_save_form', function(){
    $fields = $_POST['fields'];
    global $wpdb;

    

    foreach($fields){
        $wpdb->insert("{$wbdb->prefix}{FORM_TABLE}", , $format);
    }
    wp_send_json([ 'msg' => 'hello world' ]);
});