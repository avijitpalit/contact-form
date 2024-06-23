<?
/*
Plugin Name: Simple contact form
Description: A simple but customizable contact form
Author: Avijit Palit
*/

define('PLUGIN_FILE', __FILE__);
define('FORM_TABLE', 'scf_forms');
define('ENTRIES_TABLE', 'scf_entries');

function debug($data){
    do_action('qm/debug', $data);
}

# Activate deactivate
include __DIR__ . '/activate.php';

# Add menu page
add_action('admin_menu', function(){
    add_menu_page(
        'Simple contact form',
        'SCF',
        'manage_options',
        'simple-contact-form',
        'render_admin_page',
        'dashicons-editor-table',
        5
    );
});

function render_admin_page(){
    include_once __DIR__.'/render.php';
}

add_action('admin_menu', function(){
    add_submenu_page(
        'simple-contact-form',   // Parent menu slug
        'Add New Form',        // Page title
        'Add Form',             // Menu title
        'manage_options',      // Capability required to access this menu
        'create-form',     // Menu slug
        function() { include_once __DIR__.'/render-create-form.php'; } // Callback function to render the page
    );
});

# Add scripts
add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style('scf', plugin_dir_url(__FILE__).'assets/css/style.css');
});

add_action('admin_enqueue_scripts', function($hook){
    $screen = get_current_screen();
    $admin_pages = [
        'toplevel_page_simple-contact-form',
        'scf_page_create-form'
    ];
    
    if(in_array($hook, $admin_pages)){
        wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
        wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), false, true);

        wp_enqueue_style('dashicons');
        wp_enqueue_script('jquery');
        wp_enqueue_script('admin-tab', plugin_dir_url(__FILE__) . 'assets/js/admin-tabs.js', array('jquery'), null, true);
        wp_enqueue_style('admin', plugin_dir_url(__FILE__) . 'assets/css/admin.css');
    }
    if($hook == 'scf_page_create-form'){
        wp_register_script('scf-create-fom', plugin_dir_url(__FILE__) . 'assets/js/add-form.js', array('jquery'), null, true);
        wp_localize_script('scf-create-fom', 'scf', ['ajax_url' => admin_url('admin-ajax.php')]);
        wp_enqueue_script('scf-create-fom');
    }
});

# Render form
add_shortcode('scf', function(){
    ob_start();
    ?>
    <div class="scf-wrapper">
        <form action="<?= esc_url(admin_url('admin-post.php')) ?>" method="POST" class="scf-form">
            <input name='action' type="hidden" value='scf_submit'>
            <? wp_nonce_field('scf_nonce', 'scf_nonce_field') ?>
            <p class="scf-form-row">
                <label for="fname">Firstname</label>
                <input type="text" class="scf-input" name="fname">
            </p>
            <p class="scf-form-row">
                <label for="lname">Lastname</label>
                <input type="text" class="scf-input" name="lname">
            </p>
            <p class="scf-form-row">
                <label for="email">Email</label>
                <input type="email" class="scf-input" name="email">
            </p>

            <p class="scf-form-row scf-submit-btn-wrapper">
                <button class="btn button">Submit</button>
            </p>
        </form>
    </div>
    <?
    return ob_get_clean();
});

# Form submit
add_action('admin_post_scf_submit', 'scf_submit');
add_action('admin_post_nopriv_scf_submit', 'scf_submit');
function scf_submit(){
    // Verify nonce
    if (!isset($_POST['scf_nonce_field']) || !wp_verify_nonce($_POST['scf_nonce_field'], 'scf_nonce')) {
        wp_die('Security check failed');
    }

    // Save form entry to db
    $fname = sanitize_text_field($_POST['fname']);
    $lname = sanitize_text_field($_POST['lname']);
    $email = sanitize_email($_POST['email']);

    global $wpdb;
    $table = $wpdb->prefix.'scf';
    $wpdb->insert($table, [
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email
    ], ['%s', '%s', '%s']);

    wp_redirect('/test');
    exit;
}

# Ajax
include_once(__DIR__ . '/ajax.php');