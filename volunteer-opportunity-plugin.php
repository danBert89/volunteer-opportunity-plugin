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

//Hooks
register_activation_hook(__FILE__, 'myplugin_activate');
register_deactivation_hook(__FILE__, 'myplugin_deactivate');
