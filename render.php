<div class="wrap">
    <h2><?= esc_html(get_admin_page_title()) ?></h2>
    
    <div class="tabs">
        <h2 class="nav-tab-wrapper">
            <a href="#tab1" class="nav-tab nav-tab-active">Forms</a>
            <a href="#tab2" class="nav-tab">Entries</a>
        </h2>
        <div id="tab1" class="tab-content">
            <div>
                <a href='?page=create-form' class="button button-primary button-large">
                    <span class="dashicons-plus dashicons"></span>
                    New Form
                </a>
            </div>
            <table class="widefat fixed mt-1" cellspacing="0">
                <thead>
                    <tr>
                        <th class="manage-column column-columnname" scope="col">Title</th>
                        <th class="manage-column column-columnname" scope="col">Active</th>
                        <th class="manage-column column-columnname" scope="col">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="manage-column column-columnname" scope="col">Title</th>
                        <th class="manage-column column-columnname" scope="col">Active</th>
                        <th class="manage-column column-columnname" scope="col">Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="column-columnname">Newsletter form</td>
                        <td class="column-columnname"><input type="checkbox" name="" id=""></td>
                        <td class="column-columnname"><button class="button">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tab2" class="tab-content" style="display: none;">
            <!-- Entries -->
            <table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th class="manage-column column-columnname" scope="col">Firstname</th>
                        <th class="manage-column column-columnname" scope="col">Lastname</th>
                        <th class="manage-column column-columnname" scope="col">Email</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="manage-column column-columnname" scope="col">Firstname</th>
                        <th class="manage-column column-columnname" scope="col">Lastname</th>
                        <th class="manage-column column-columnname" scope="col">Email</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?
                    global $wpdb;
                    $table_name = $wpdb->prefix.'scf';
                    $rows = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
                    foreach($rows as $row){
                        ?>
                        <tr>
                            <td class="column-columnname"><?= $row['fname'] ?></td>
                            <td class="column-columnname"><?= $row['lname'] ?></td>
                            <td class="column-columnname"><?= $row['email'] ?></td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
