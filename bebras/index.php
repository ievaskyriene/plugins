

<style>
@import url("https://fonts.googleapis.com/css?family=Montserrat");
</style>
<?php

require  __DIR__ . '/App.php';
// use App;
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

// add_action( 'admin_menu', function(){
//     add_menu_page('Bebro Puslapis', 'Bebras', 'manage_options', 'bebras', 'bebro_funkcija');
 
// add_submenu_page('bebras', 'Page title 2', 'Menu title 2',
//     'manage_options', 'bebras2', 'bebro_funkcija2');
 
// add_submenu_page('bebras', 'Edit', null,
//     'manage_options', 'bebras3', 'bebro_funkcija3');
// });
 
// add_action( 'init', function() {
//     $labels = [
//       'name'               => 'Event',
//       'singular_name'      => 'Event',
//       'add_new'            => 'new Event',
//       'add_new_item'       => __( 'Add New Product' ),
//       'edit_item'          => __( 'Edit Product' ),
//       'new_item'           => __( 'New Product' ),
//       'all_items'          => __( 'All Products' ),
//       'view_item'          => __( 'View Product' ),
//       'search_items'       => __( 'Search Products' ),
//       'not_found'          => __( 'No products found' ),
//       'not_found_in_trash' => __( 'No products found in the Trash' ), 
//       'menu_name'          => 'Products'
//     ];
//     $args = [
//       'labels'        => $labels,
//       'description'   => 'Holds our products and product specific data',
//       'public'        => true,
//       'menu_position' => 5,
//       'supports'      => [],
//       'has_archive'   => true,
//     ];
// register_post_type('event', $args ); 
// });
 
// function bebro_funkcija()
// {
//     echo '<h1>Aš Esu Bebras</h1>';
 
//     $post = [
//         'post_title'   => 'Test post-----------',
//         'post_content' => '',
//         'post_status'  => 'publish',
//         'post_author'  => 1,
//         'post_type'  => 'event',
//         'meta_input'   => [
//             'text' => 'ivykio tekstas---------',
//             // 'data' => $_POST['event_date']
//         ],
//     ];

//     $post_id = wp_insert_post($post);
    
// }
 
// function bebro_funkcija2()
// {
//     echo '<h1>Aš Esu Bebras Nr 2</h1>';
// }
 
// function bebro_funkcija3()
// {
//     echo '<h1>Aš Esu Bebras Nr 3</h1>';
// }
//nuo cia 

add_action( 'admin_menu', function(){
    add_menu_page('Event Page', 'Events', 'manage_options', 'events', 'event_show');
 
add_submenu_page('events', 'Page title 2', 'new Event',
    'manage_options', 'event.create', 'event_create');
 
add_submenu_page('events', 'Delete', null,
    'manage_options', 'event.delete', 'event_delete');

add_submenu_page('events', 'Edit', null,
    'manage_options', 'event.edit', 'event_edit');
 
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
register_post_type('event', $args ); 
});
 
function event_show(){
   $routeDir = plugin_dir_url(__FILE__).'views';
   print_r($routeDir);
   echo '<br>';

    $start = App::start();
    var_dump($start);

    // $get = App::_get();
    // var_dump($get);

    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_postmeta "); 
    if(!empty($results))
    {                      
        echo '<table>';
        echo '<tr>';
        echo '<th>Įvykis</th>';
        echo '<th>Data</th>';
        echo '<th>Veiksmai</th>';
        echo '<div>';
            foreach($results as $row) {
                    $postid = $row->post_id;   
                if ($row->meta_key == 'text'){  
                    echo "<tr>";        
                    echo "<td>" . $row->meta_value . "</td>";
                }

                if ($row->meta_key == 'data'){       
                    echo "<td>" . $row->meta_value . "</td>";
                    echo "<td>";
                        echo '
                        <form action="'.event_delete($postid).'" method="post"> 
                        <button type="submit" name="delete" value="'. $postid.'">Trinti</button> 
                        </form>';
                        echo '
                        <form action="http://localhost:8080/wordpress/wp-admin/admin.php?page=event.edit" method="post"> 
                        <button type="submit" name="edit_event" value="'. $postid.'">Redaguoti</button> 
                        </form>';
                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    echo '</div><br>';
    echo '</table>';
}
 
function event_create()
{
    echo ' <div class="container">
    <div class="form">
        <h2>Iveskite naują įvykį</h2>
        <form action="" method="post">
            <h3> Įvykio aprašymas </h3> 
                <textarea name="ivykis" required> </textarea> 
            <h3> Numatoma įvykio data  </h3>
                <input type="date" name = "data"><br>
            <button type="submit" name = "action" >Sukurti įvykį</button>
        </form>
    </div>
</div>';
 
    if(array_key_exists('action', $_POST)){
        $post = [
            'post_title'   => 'Events',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'  => 'event',
            'meta_input'   => [
                'text' => $_POST['ivykis'],
                'data' => $_POST['data']
            ],
        ];
        $post_id = wp_insert_post($post);
        wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=events');
    }
}
 
function event_delete($postid)
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

function event_edit($postid)
{
    ?>     
    <?php 
        $args = [
            'post_ID' => $_POST['edit_event']
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $query->the_post();
            $postmetas = get_post_meta($_POST['edit_event']);
            ?>
            <div class="container">
                <div class="form">
                <h2>Redaguoti įvykį</h2>
                    <form action="" method="post">
                        <h3>Įvykio aprašymas</h3>
                            <textarea name="event_description" id="event_desc"><?=$postmetas['text'][0]?></textarea>
                        <h3>Numatoma įvykio data</h3>
                            <input type="date" name="event_date" value="<?=$postmetas['date'][0]?>" id="event_date"><br>
                        <button type="submit" name="update_event" value="<?=$_POST['edit_event']?>">Išsaugoti įvykį</button>
                    </form>
                </div>
            </div>
        <?php
        }
        wp_reset_postdata();
        if (array_key_exists('update_event', $_POST)) {
            $post = get_post($_POST['update_event']);
            $post->meta_input = [
                'text' => $_POST['event_description'], 
                'date' => $_POST['event_date']                               
            ];
            wp_update_post($post);
            wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=events');
            exit;
        }
    ?>
    </div>
    <?php
}
// global $wpdb;
// $results = $wpdb->get_results( "SELECT * FROM wp_postmeta ");
// foreach($results as $post) {
    
//     if (array_key_exists('action', $_POST)){
//         $post = get_post((int)$_POST['ID']);
//         // _dd($post);
//             // $postid = $post->post_id; 
          
//         //    if($_POST['action'] == $post->post_id){
//             // _dd($post);
//             $post->post_content = $_POST['content'];
//             $post->meta_input = [
//                 'text' => $_POST['ivykis'],
//                 'date' => $_POST['data'],
//             ];
//         wp_update_post($post);
//         wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=events');
//     // }
//             // $postid = $post->post_id; 
//             // // _dd($_POST['action']);
//             //     if($_POST['action'] == $postid){
//             //         _dd($postid);
//             //         $post = [
//             //             'post_title'   => 'Events',
//             //             'post_content' => '',
//             //             'post_status'  => 'publish',
//             //             'post_author'  => 1,
//             //             'post_type'  => 'event',
//             //             'meta_input'   => [
//             //                 'text' => $_POST['ivykis'],
//             //                 'data' => $_POST['data']
//             //             ],
//             //         ]; 

//             //         wp_update_post($post);
//             //         wp_redirect('http://localhost:8080/wordpress/wp-admin/admin.php?page=events');
//             //     }
//         }

//     echo ' <div class="container">
//     <div class="form">
//         <h2>Iveskite įvykį</h2>
//         <form action="" method="post">
//             <label> Įvykis:    </label> <br>
//                 <textarea name="ivykis" required> </textarea> <br>
//             <label> Įvykio data: <br>
//                 <input type="date" name = "data"><br>
//             </label>
//             <input type="hidden" name="ID" value="'. $post->post_id.'"readonly> 
//             <button type="submit" name = "action" value="'. $_POST['edit'].'">Redaguoti įvykį</button>
//         </form>
//     </div>
// </div>';
// }

