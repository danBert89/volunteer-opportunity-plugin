<?php

/**
 * Plugin Name: Volunteer Opportunity Plugin
 * Description: Assignment 01
 * Author: Daniel Bertrand
 * Version 1.0
 */

// run this function on plugin activation to initialize database in phpmyadmin.
function myplugin_activate()
{
    global $wpdb;

    $wpdb->query("CREATE TABLE {$wpdb->prefix}volunteer_opportunity(
                id INT AUTO_INCREMENT PRIMARY KEY,
                position VARCHAR(255),
                organization VARCHAR(255),
                type_of_commitment VARCHAR(255),
                email VARCHAR(255),
                description VARCHAR(255),
                location VARCHAR(255),
                hours INT,
                skills_required TEXT);");
}

function myplugin_deactivate()
{
    global $wpdb;

    $wpdb->query("DELETE FROM {$wpdb->prefix}volunteer_opportunity");
}

function myplugin_uninstall()
{
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}volunteer_opportunity");
}

function wp_volunteer_adminpage_html()
{
    global $wpdb;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}volunteer_opportunity WHERE id = $id", ARRAY_A);
        $result = $result[0];
?>
        <h1>Update Volunteer Opportunity</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo esc_html($result['id']); ?>">
            <label for="position" style="display: inline-block; width: 150px; margin-bottom: 10px;">Position:</label>
            <input type="text" name="position" id="position" value="<?php echo esc_html($result['position']); ?>" required style="margin-bottom: 10px;">
            <br>

            <label for="organization" style="display: inline-block; width: 150px; margin-bottom: 10px;">Organization:</label>
            <input type="text" name="organization" id="organization" value="<?php echo esc_html($result['organization']); ?>" required style="margin-bottom: 10px;">
            <br>

            <label for="type" style="display: inline-block; width: 150px; margin-bottom: 10px;">Type:</label>
            <select name="type" id="type" required style="margin-bottom: 10px;">
                <option value="one-time" <?php echo $result['type_of_commitment'] === 'one-time' ? 'selected' : ''; ?>>One Time</option>
                <option value="recurring" <?php echo $result['type_of_commitment'] === 'recurring' ? 'selected' : ''; ?>>Recurring</option>
                <option value="seasonal" <?php echo $result['type_of_commitment'] === 'seasonal' ? 'selected' : ''; ?>>Seasonal</option>
            </select>
            <br>

            <label for="email" style="display: inline-block; width: 150px; margin-bottom: 10px;">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo esc_html($result['email']); ?>" required style="margin-bottom: 10px;">
            <br>

            <label for="location" style="display: inline-block; width: 150px; margin-bottom: 10px;">Location:</label>
            <input type="text" name="location" id="location" value="<?php echo esc_html($result['location']); ?>" required style="margin-bottom: 10px;">
            <br>
            <label for="hours" style="display: inline-block; width: 150px; margin-bottom: 10px;">Hours:</label>
            <input type="number" name="hours" id="hours" value="<?php echo esc_html($result['hours']); ?>" required style="margin-bottom: 10px;">
            <br>

            <label for="skills" style="display: inline-block; width: 150px; margin-bottom: 10px;">Skills Required:</label>
            <input type="text" name="skills" id="skills" value="<?php echo esc_html($result['skills_required']); ?>" placeholder="e.g., event planning, fundraising" required style="margin-bottom: 10px; width: 500px;">
            <br>

            <label for="description" style="display: inline-block; width: 150px; margin-bottom: 10px;">Description:</label>
            <textarea name="description" id="description" required style="margin-bottom: 10px; width: 500px; height: 175px;">
            <?php echo esc_html($result['description']); ?>
            </textarea>
            <br>
            <button type="update" name="update" style="margin-left: 150px;">Update Record</button>
        </form>

    <?php

    } else {
    ?>
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <h2>Insert Volunteer Opportunity</h2>
        <form method="POST" action="">
            <label for="position" style="display: inline-block; width: 150px; margin-bottom: 10px;">Position:</label>
            <input type="text" name="position" id="position" required style="margin-bottom: 10px;">
            <br>

            <label for="organization" style="display: inline-block; width: 150px; margin-bottom: 10px;">Organization:</label>
            <input type="text" name="organization" id="organization" required style="margin-bottom: 10px;">
            <br>

            <label for="type" style="display: inline-block; width: 150px; margin-bottom: 10px;">Type:</label>
            <select name="type" id="type" required style="margin-bottom: 10px;">
                <option value="one-time">One Time</option>
                <option value="recurring">Recurring</option>
                <option value="seasonal">Seasonal</option>
            </select>
            <br>

            <label for="email" style="display: inline-block; width: 150px; margin-bottom: 10px;">Email:</label>
            <input type="email" name="email" id="email" required style="margin-bottom: 10px;">
            <br>

            <label for="location" style="display: inline-block; width: 150px; margin-bottom: 10px;">Location:</label>
            <input type="text" name="location" id="location" required style="margin-bottom: 10px;">
            <br>

            <label for="hours" style="display: inline-block; width: 150px; margin-bottom: 10px;">Hours:</label>
            <input type="number" name="hours" id="hours" required style="margin-bottom: 10px;">
            <br>

            <label for="skills" style="display: inline-block; width: 150px; margin-bottom: 10px;">Skills Required:</label>
            <input type="text" name="skills" id="skills" placeholder="e.g., event planning, fundraising" required style="margin-bottom: 10px; width: 500px;">
            <br>

            <label for="description" style="display: inline-block; width: 150px; margin-bottom: 10px;">Description:</label>
            <textarea name="description" id="description" required style="margin-bottom: 10px; width: 500px; height: 175px;"></textarea>
            <br>
            <button type="submit" name="submit" style="margin-left: 150px;">Submit</button>
        </form>
    <?php
    }
    if (isset($_POST['submit'])) {
        $wpdb->insert(
            "{$wpdb->prefix}volunteer_opportunity",
            array(
                'position' => $_POST['position'],
                'organization' => $_POST['organization'],
                'type_of_commitment' => $_POST['type'],
                'email' => $_POST['email'],
                'description' => $_POST['description'],
                'location' => $_POST['location'],
                'hours' => $_POST['hours'],
                'skills_required' => $_POST['skills'],
            )
        );
    } elseif (isset($_POST['update'])) {
        $wpdb->update(
            "{$wpdb->prefix}volunteer_opportunity",
            array(
                'position' => $_POST['position'],
                'organization' => $_POST['organization'],
                'type_of_commitment' => $_POST['type'],
                'email' => $_POST['email'],
                'description' => $_POST['description'],
                'location' => $_POST['location'],
                'hours' => $_POST['hours'],
                'skills_required' => $_POST['skills'],
            ),
            array('id' => $_POST['id'])
        );
    }

    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}volunteer_opportunity", ARRAY_A);
    ?>

    <h3> Current Volunteer Opportunities </h3>
    <br>
    <br>
    <table border="1" style="width: 80%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Position</th>
                <th>Organization</th>
                <th>Type of Commitment</th>
                <th>Email</th>
                <th>Location</th>
                <th>Hours</th>
                <th>Skills Required</th>
                <th>Description</th>
                <th>Remove</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
                $id = $_POST['id'];
                $wpdb->query("DELETE FROM {$wpdb->prefix}volunteer_opportunity WHERE id = $id");
            }
            $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}volunteer_opportunity", ARRAY_A);

            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . esc_html($row['position']) . '</td>';
                echo '<td>' . esc_html($row['organization']) . '</td>';
                echo '<td>' . esc_html($row['type_of_commitment']) . '</td>';
                echo '<td>' . esc_html($row['email']) . '</td>';
                echo '<td>' . esc_html($row['location']) . '</td>';
                echo '<td>' . esc_html($row['hours']) . '</td>';
                echo '<td>' . esc_html($row['skills_required']) . '</td>';
                echo '<td>' . esc_html($row['description']) . '</td>';
                echo '<td> <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="' . esc_html($row['id']) . '">
                            <button type="submit">Delete</button>
                           </form>
                      </td>';
                echo '<td> <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="' . esc_html($row['id']) . '">
                            <button type="submit">Update</button>
                           </form>
                        </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

<?php
}

function wporg_shortcode($atts = [], $content = null)
{
    global $wpdb;

    $atts = shortcode_atts([
        'hours' => null,
        'type' => null,
    ], $atts);

    $query = "SELECT * FROM {$wpdb->prefix}volunteer_opportunity WHERE 1=1";
    if ($atts['hours'] !== null) {
        $query .= $wpdb->prepare(" AND hours < %d", $atts['hours']);
    }
    if ($atts['type'] !== null) {
        $query .= $wpdb->prepare(" AND type_of_commitment = %s", $atts['type']);
    }

    $results = $wpdb->get_results($query, ARRAY_A);

    $content = '<table border="1" style="width: 80%; border-collapse: collapse;">';
    $content .= '<thead>';
    $content .= '<tr>';
    $content .= '<th>Position</th>';
    $content .= '<th>Organization</th>';
    $content .= '<th>Type of Commitment</th>';
    $content .= '<th>Email</th>';
    $content .= '<th>Location</th>';
    $content .= '<th>Hours</th>';
    $content .= '<th>Skills Required</th>';
    $content .= '<th>Description</th>';
    $content .= '</tr>';
    $content .= '</thead>';
    $content .= '<tbody>';

    foreach ($results as $row) {
        $row_style = '';

        if ($atts['hours'] === null && $atts['type'] === null) {
            if ($row['hours'] < 10) {
                $row_style = 'background-color:rgb(26, 228, 37);';
            } elseif ($row['hours'] >= 10 && $row['hours'] <= 100) {
                $row_style = 'background-color:rgb(255, 247, 4);';
            } else {
                $row_style = 'background-color:rgb(255, 9, 9);';
            }
        }
        $content .= '<tr style="' . esc_attr($row_style) . '">';
        $content .= '<td>' . esc_html($row['position']) . '</td>';
        $content .= '<td>' . esc_html($row['organization']) . '</td>';
        $content .= '<td>' . esc_html($row['type_of_commitment']) . '</td>';
        $content .= '<td>' . esc_html($row['email']) . '</td>';
        $content .= '<td>' . esc_html($row['location']) . '</td>';
        $content .= '<td>' . esc_html($row['hours']) . '</td>';
        $content .= '<td>' . esc_html($row['skills_required']) . '</td>';
        $content .= '<td>' . esc_html($row['description']) . '</td>';
        $content .= '</tr>';
    }
    $content .= '</tbody>';
    $content .= '</table>';

    return $content;
}

function wp_volunteer_adminpage()
{
    add_menu_page("Welcome to the Volunteer Opportunities Admin Page", "Volunteer", "manage_options", "volunteer_admin", "wp_volunteer_adminpage_html", "", 20);
}
add_shortcode("volunteer", "wporg_shortcode");
add_action("admin_menu", "wp_volunteer_adminpage");
register_activation_hook(__FILE__, 'myplugin_activate');
register_deactivation_hook(__FILE__, 'myplugin_deactivate');
register_uninstall_hook(__FILE__, 'myplugin_uninstall');
