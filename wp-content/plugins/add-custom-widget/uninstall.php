<?php

function remove_custom_users_widget() {
    unregister_widget('CustomUsersWidget');
}

add_action( 'widgets_init', 'remove_custom_users_widget', 20 );
