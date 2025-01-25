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
            <option value="one-time">One-time</option>
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
        <input type="text" name="skills" id="skills" placeholder="e.g., event planning, fundraising" required style="margin-bottom: 10px;">
        <br>

        <label for="description" style="display: inline-block; width: 150px; margin-bottom: 10px;">Description:</label>
        <textarea name="description" id="description" required style="margin-bottom: 10px;"></textarea>
        <br>
        <button type="submit" name="submit" style="margin-left: 150px;">Submit</button>
    </form>

<?php



}

function wp_volunteer_adminpage()
{
    add_menu_page("Welcome to the Volunteer Opportunities Admin Page", "Volunteer", "manage_options", "volunteer_admin", "wp_volunteer_adminpage_html", "", 20);
}

//Hooks
add_action("admin_menu", "wp_volunteer_adminpage");
register_activation_hook(__FILE__, 'myplugin_activate');
register_deactivation_hook(__FILE__, 'myplugin_deactivate');
register_uninstall_hook(__FILE__, 'myplugin_uninstall');
