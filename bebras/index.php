<?php
/**
* Plugin Name: Bebro pluginas
* Plugin URI: https://www.bebbr.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Your Name Here
* Author URI: http://bebbr.com/
**/
 

function admin_enqueue_scripts() {
    wp_enqueue_script( 'custom-js', plugin_dir_url( __FILE__ ) . 'js/custom.js', '', true );
    wp_enqueue_style( 'style-css', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts');

add_action( 'admin_menu', function(){
    add_menu_page('Bebro Puslapis', 'Bebras', 'manage_options', 'bebras', 'bebro_funkcija');
 
add_submenu_page('bebras', 'Page title 2', 'Menu title 2',
    'manage_options', 'bebras2', 'bebro_funkcija2');
 
add_submenu_page('bebras', 'Edit', null,
    'manage_options', 'bebras3', 'bebro_funkcija3');
});
 
add_action( 'init', function() {
    $labels = [
      'name'               => 'Event',
      'singular_name'      => 'Event',
      'add_new'            => 'new Event',
      'add_new_item'       => __( 'Add New Product' ),
      'edit_item'          => __( 'Edit Product' ),
      'new_item'           => __( 'New Product' ),
      'all_items'          => __( 'All Products' ),
      'view_item'          => __( 'View Product' ),
      'search_items'       => __( 'Search Products' ),
      'not_found'          => __( 'No products found' ),
      'not_found_in_trash' => __( 'No products found in the Trash' ), 
      'menu_name'          => 'Products'
    ];
    $args = [
      'labels'        => $labels,
      'description'   => 'Holds our products and product specific data',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => [],
      'has_archive'   => true,
    ];
register_post_type('event', $args ); 
});
 
function bebro_funkcija()
{
    echo '<h1>Aš Esu Bebras</h1>';
 
    $post = [
        'post_title'   => 'Test post-----------',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_author'  => 1,
        'post_type'  => 'event',
        'meta_input'   => [
            'text' => 'ivykio tekstas---------',
            // 'data' => $_POST['event_date']
        ],
    ];

    $post_id = wp_insert_post($post);
    
}
 
function bebro_funkcija2()
{
    echo '<h1>Aš Esu Bebras Nr 2</h1>';
}
 
function bebro_funkcija3()
{
    echo '<h1>Aš Esu Bebras Nr 3</h1>';
}
 
//nuo cia 

add_action( 'admin_menu', function(){
    add_menu_page('Ivykiu Puslapis', 'Ivykiai', 'manage_options', 'ivykiai', 'ivykiu_funkcija');
 
add_submenu_page('ivykiai', 'Page title 2', 'Naujas Ivykis',
    'manage_options', 'ivykiai2', 'ivykiu_funkcija2');
 
add_submenu_page('ivykiai', 'Delete', null,
    'manage_options', 'ivykiai3', 'ivykiu_funkcija3');

add_submenu_page('ivykiai', 'Edit', null,
    'manage_options', 'ivykiai.edit', 'funkcija_edit');
 
});

add_action( 'init', function() {
    $labels = [
      'name'               => 'Event',
      'singular_name'      => 'Event',
      'add_new'            => 'new Event',
      'add_new_item'       => __( 'Add New Event' ),
      'edit_item'          => __( 'Edit Event' ),
      'new_item'           => __( 'New Event' ),
      'all_items'          => __( 'All Event' ),
      'view_item'          => __( 'View Event' ),
      'search_items'       => __( 'Search Event' ),
      'not_found'          => __( 'No Events found' ),
      'not_found_in_trash' => __( 'No Events found in the Trash' ), 
      'menu_name'          => 'Event'
    ];
    $args = [
      'labels'        => $labels,
      'description'   => 'Holds our products and product specific data',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => [],
      'has_archive'   => true,
    ];
register_post_type('Event', $args ); 
});
 
function ivykiu_funkcija(){
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_postmeta "); // Query to fetch data from database table and storing in $results
    if(!empty($results))
    {                      
        echo '<table>';
        echo '<tr>';
        echo '<th>Įvykis</th>';
        echo '<th>Data</th>';
        echo '<div>';
            foreach($results as $row) {
                    $postid = $row->post_id;   
                if ($row->meta_key == 'text'){  
                    echo "<tr>";        
                    echo "<td>" . $row->meta_value . "</td>";
                    // echo "</tr>";
                    // echo'<tr>';
                    // echo '<td>' . $row->meta_value . '</td>';
                    // // echo '</tr>';
                    // // echo'<tr>';
                    // echo '<td>' . $row->meta_value . '</td>';
                    // echo '</tr>';
                }
                if ($row->meta_key == 'data'){
                    // echo "<tr>";        
                    echo "<td>" . $row->meta_value . "</td>";
                    echo "<td>";
                        echo '
                        <form action="'.ivykiu_funkcija3($postid).'" method="post"> 
                        <button type="submit" name="delete" value="'. $postid.'">Trinti</button> 
                        </form>';
                        echo '
                        <form action="http://localhost:8080/wordpress/wp-admin/admin.php?page=ivykiai.edit" method="post"> 
                        <button type="submit" name="edit" value="'. $postid.'">Redaguoti</button> 
                        </form>';
                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    echo '</div><br>';
    echo '</table>';
}
 
function ivykiu_funkcija2()
{
    echo ' <div class="container">
    <div class="form">
        <h2>Iveskite įvykį</h2>
        <form action="" method="post">
            <label> Įvykis: <br>
                <textarea name="ivykis" required> </textarea> <br>
            </label> 
            <label> Įvykio data: <br>
                <input type="date" name = "data"><br>
            </label>
            <button type="submit" name = "action" >Sukurti įvykį</button>
        </form>
    </div>
</div>';
 
    if(array_key_exists('action', $_POST)){
        $post = [
            'post_title'   => 'Ivykiai',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'meta_input'   => [
                'text' => $_POST['ivykis'],
                'data' => $_POST['data']
            ],
        ];
        $post_id = wp_insert_post($post);
        wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=ivykiai');
    }
}
 
function ivykiu_funkcija3($postid)
{
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_postmeta ");
    if(array_key_exists('delete', $_POST))
    {
        foreach($results as $row) {
            $postid = $row->post_id; 
            if($_POST['delete'] == $postid){
                $removefromdb = $wpdb->delete( 'wp_postmeta', ['post_id'=>$postid]);  
            }   
        }
    } 
}

function funkcija_edit($postid)
{
   
    echo ' <div class="container">
    <div class="form">
        <h2>Iveskite įvykį</h2>
        <form action="" method="post">
            <label> Įvykis: <br>
                <textarea name="ivykis" required> </textarea> <br>
            </label> 
            <label> Įvykio data: <br>
                <input type="date" name = "data"><br>
            </label>
            <button type="submit" name = "action" value="'. $postid.'">Redaguoti įvykį</button>
        </form>
    </div>
</div>';
    global $wpdb;
    $results = $wpdb->get_row( "SELECT * FROM wp_postmeta WHERE post_id = $postid"); // Query to fetch data from database table and storing in $results
    $postid = $results->post_id; 
    
    if(array_key_exists('action', $_POST)){
        
        // $post = get_post((int)$postid);
        $post = [
            'post_title'   => 'Ivykiai',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'meta_input'   => [
                'text' => $_POST['ivykis'],
                'data' => $_POST['data']
            ],
        ];
        wp_update_post($post);
        wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=ivykiai');
    }
}

