<?php
/*
 * Plugin Name: Add custom widget
 * Plugin URI: https:/test.com/wordpress/plugin
 * Description: Plugin for add custom widgets
 * Version: 1.1.1
 * Author: Vlad Tkachenko
 * Author URI: https://test.blog
 * License: GPLv2 or later
 */

function get_filter_users($posts_per_page, $empty_comment, $role) {
    global $wpdb;
    $query_string = "SELECT users_var.ID, users_var.display_name, COUNT(user_email) as votes 
            FROM ". $wpdb->users ." users_var 
            LEFT JOIN ". $wpdb->comments ." comments_var ON comments_var.comment_author_email = users_var.user_email ";
    if (!empty($empty_comment)) {
        $query_string .= "OR comments_var.comment_author_email IS NULL ";
    }
    if (!empty($role)) {
        $query_string .= "LEFT JOIN ". $wpdb->usermeta ." usermeta_var ON usermeta_var.user_id = users_var.ID ";
    }
    $query_string .= "WHERE comments_var.comment_approved = 1 ";
    if (!empty($role)) {
        $query_string .= " AND usermeta_var.meta_key = 'wp_capabilities' AND usermeta_var.meta_value LIKE '%". $role ."%' ";
    }
    $query_string .= "GROUP BY users_var.user_email 
            ORDER BY votes DESC 
            LIMIT " . $posts_per_page;
    $count = $wpdb->get_results($query_string);
    return $count;
}

class CustomUsersWidget extends WP_Widget {

    /*
     * создание виджета
     */
    function __construct() {
        parent::__construct(
            'custom_users_widget',
            'Список пользователей',
            array( 'description' => 'Позволяет вывести список пользователей, и отсортировать их по количеству комментариев.' )
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        $posts_per_page = $instance['posts_per_page'];
        $views_comment = $instance['views_comment'];
        $empty_comment = $instance['empty_comment'];
        $background_color = $instance['background_color'];
        $text_color = $instance['text_color'];
        $role = $instance['role'];

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        $q = get_filter_users($posts_per_page, $empty_comment, $role);

        if (!empty($q)) {
            ?>
            <style>
                .widget-list-container {
                    border-radius: 4px;
                    padding: 10px;
                }
                .widget-list-container li {
                    list-style-type: none;
                }

                .widget-list-container .flex-container-widget {
                    display: flex;
                    flex-flow: wrap;
                    justify-content: space-between;
                }

            </style>

            <ul class="widget-list-container" style="background-color: <?php echo !empty($background_color) ? $background_color : '' ?>">
                <?php foreach ($q as $key => $value) { ?>
                    <li>
                        <div class="flex-container-widget">
                            <div class="user-name" style="color: <?php echo !empty($text_color) ? $text_color : '' ?>">
                                <?php echo $value->display_name;?>
                            </div>
                            <?php if(!empty($views_comment)) : ?>
                                <div class="user-comment-count" style="color: <?php echo !empty($text_color) ? $text_color : '' ?>">
                                    <?php echo $value->votes;?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>

                    <?php
                } ?>
            </ul>
            <?php
        }
        echo $args['after_widget'];
    }

    /*
     * бэкэнд виджета
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        if ( isset( $instance[ 'posts_per_page' ] ) ) {
            $posts_per_page = $instance[ 'posts_per_page' ];
        }
        if ( isset( $instance[ 'views_comment' ] ) ) {
            $views_comment = $instance[ 'views_comment' ];
        }
        if ( isset( $instance[ 'empty_comment' ] ) ) {
            $empty_comment = $instance[ 'empty_comment' ];
        }
        if ( isset( $instance[ 'background_color' ] ) ) {
            $background_color = $instance[ 'background_color' ];
        }
        if ( isset( $instance[ 'text_color' ] ) ) {
            $text_color = $instance[ 'text_color' ];
        }
        if ( isset( $instance[ 'role' ] ) ) {
            $role = $instance[ 'role' ];
        }
        global $wp_roles;
        $roles = $wp_roles->roles;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Количество пользователей:</label>
            <input id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '5'; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'views_comment' ); ?>">Отображать комментарии:</label>
            <input id="<?php echo $this->get_field_id( 'views_comment' ); ?>" name="<?php echo $this->get_field_name( 'views_comment' ); ?>" type="checkbox" <?php echo !empty($views_comment) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'empty_comment' ); ?>">Отображение пользователей без комментариев:</label>
            <input id="<?php echo $this->get_field_id( 'empty_comment' ); ?>" name="<?php echo $this->get_field_name( 'empty_comment' ); ?>" type="checkbox" <?php echo !empty($empty_comment) ? 'checked' : ''; ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'background_color' ); ?>">Цвет заднего фона списка</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'text_color' ); ?>">Цвет текста</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'text_color' ); ?>" name="<?php echo $this->get_field_name( 'text_color' ); ?>" type="text" value="<?php echo esc_attr( $text_color ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'role' ); ?>">Выбор роли</label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'role' ); ?>" name="<?php echo $this->get_field_name( 'role' ); ?>" >
                <option <?php echo empty($role) ? 'selected': '' ; ?> value="" >Все</option>
                <?php foreach ($roles as $key => $value) { ?>
                    <option <?php echo $key == $role ? 'selected': '' ; ?> value="<?php echo $key ?>" ><?php echo $value["name"]; ?></option>
                <?php } ?>
            </select>
        </p>
        <?php
    }

    /*
     * сохранение настроек виджета
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : '5';
        $instance['views_comment'] = ( !empty( $new_instance['views_comment'] ) ) ? 1 : 0;
        $instance['empty_comment'] = ( !empty( $new_instance['empty_comment'] ) ) ? 1 : 0;
        $instance['background_color'] = ( ! empty( $new_instance['background_color'] ) ) ? strip_tags( $new_instance['background_color'] ) : '';
        $instance['text_color'] = ( ! empty( $new_instance['text_color'] ) ) ? strip_tags( $new_instance['text_color'] ) : '';
        $instance['role'] = ( ! empty( $new_instance['role'] ) ) ? strip_tags( $new_instance['role'] ) : '';

        return $instance;
    }
}

function custom_users_widget_load() {
    register_widget( 'CustomUsersWidget' );
}
add_action( 'widgets_init', 'custom_users_widget_load' );