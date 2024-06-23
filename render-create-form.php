<?
    // Check if the user has submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the URL
    if (isset($_GET['settings-updated'])) {
        add_settings_error('custom_messages', 'custom_message', __('Settings Saved', 'textdomain'), 'updated');
    }

    // Show error/update messages
    settings_errors('custom_messages');
?>

<div class="wrap">
    <h2><?= esc_html(get_admin_page_title()) ?></h2>
    
    <h5 class="mt-3">Add field</h5>
    <div>
        <form id='add-field-form' method="post">
            <input type="hidden" name="action" value="add_field">
            <table class="form-table" role="presentation">
                <tr>
                    <th><label for="label">Field label</label></th>
                    <td><input type="text" name="label" id="label" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="type">Field type</label></th>
                    <td>
                        <select name="type" id="type" class="regular-text">
                            <option value="text">Text</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="mt-1">
                <button type="submit" class="button">Add Field</button>
            </div>
        </form>
    </div>
    
    <h5 class="mt-4">Fields preview</h5>
    <div id='fields-preview' class="fields-preview">
        
    </div>
    <div class="mt-2 d-flex align-items-center gap-2">
        <button id="save-form" class="button button-primary button-large">Save Form</button>
        <span id="save-form-stat" class="text-danger">Satus message here</span>
    </div>
</div>