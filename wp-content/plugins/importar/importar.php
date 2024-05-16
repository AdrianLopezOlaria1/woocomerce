<?php
/*
Plugin Name: Importar
Description: Plugin para importar productos desde CSV
Author: Prácticas AticSoft
Version: 1.0
*/
add_action( 'init', 'importarProductos' );

function importarProductos() {
    
    $csv_file = plugin_dir_path( __FILE__ ) . 'productos.csv';
 
    if ( ! file_exists( $csv_file ) ) {
        return;
    }

    if ( ( $handle = fopen( $csv_file, 'r' ) ) !== false ) {
       
        while ( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== false ) {                   
            
            if ( is_numeric($data[0])) {            
                
               /*$product_data = array(
                    'id' => isset($data[0]) ? $data[0] : '',
                    'type' => isset($data[1]) ? $data[1] : '',
                    'sku' => isset($data[2]) ? $data[2] : '',
                    'name' => isset($data[3]) ? $data[3] : '',
                    'published' => isset($data[4]) ? $data[4] : '',
                    'featured' => isset($data[5]) ? $data[5] : '',
                    'catalog_visibility' => isset($data[6]) ? $data[6] : '',
                    'short_description' => isset($data[7]) ? $data[7] : '',
                    'description' => isset($data[8]) ? $data[8] : '',
                    'date_on_sale_from' => isset($data[9]) ? $data[9] : '',
                    'date_on_sale_to' => isset($data[10]) ? $data[10] : '',
                    'tax_status' => isset($data[11]) ? $data[11] : '',
                    'tax_class' => isset($data[12]) ? $data[12] : '',
                    'stock_status' => isset($data[13]) ? $data[13] : '',
                    'stock_quantity' => isset($data[14]) ? $data[14] : '',
                    'low_stock_amount' => isset($data[15]) ? $data[15] : '',
                    'backorders' => isset($data[16]) ? $data[16] : '',
                    'sold_individually' => isset($data[17]) ? $data[17] : '',
                    'weight' => isset($data[18]) ? $data[18] : '',
                    'length' => isset($data[19]) ? $data[19] : '',
                    'width' => isset($data[20]) ? $data[20] : '',
                    'height' => isset($data[21]) ? $data[21] : '',
                    'reviews_allowed' => isset($data[22]) ? $data[22] : '',
                    'purchase_note' => isset($data[23]) ? $data[23] : '',
                    'sale_price' => isset($data[24]) ? $data[24] : '',
                    'regular_price' => isset($data[25]) ? $data[25] : '',
                    'category_ids' => isset($data[26]) ? $data[26] : '',
                    'tag_ids' => isset($data[27]) ? $data[27] : '',
                    'shipping_class_id' => isset($data[28]) ? $data[28] : '',
                    'images' => isset($data[29]) ? $data[29] : '',
                    'download_limit' => isset($data[30]) ? $data[30] : '',
                    'download_expiry' => isset($data[31]) ? $data[31] : '',
                    'parent_id' => isset($data[32]) ? $data[32] : '',
                    'grouped_products' => isset($data[33]) ? $data[33] : '',
                    'upsell_ids' => isset($data[34]) ? $data[34] : '',
                    'cross_sell_ids' => isset($data[35]) ? $data[35] : '',
                    'product_url' => isset($data[36]) ? $data[36] : '',
                    'button_text' => isset($data[37]) ? $data[37] : '',
                    'menu_order' => isset($data[38]) ? $data[38] : '',
                );   */

                $product_data = array(
                    'post_title'    => isset($data[3]) ? $data[3] : '',
                    'post_content'  => isset($data[7]) ? $data[7] : '',
                    'post_status'   => 'publish', // Estado del producto (publish para publicado)
                    'post_type'     => 'product',
                );   
                //echo '<pre>';                                     
                //var_dump($product_data); die();
                $product_id = wp_insert_post( $product_data );                                                                                      
                //var_dump($product_id);
                if ( is_wp_error( $product_id ) ) {
                    error_log( 'Error al insertar el producto: ' . $product_id->get_error_message() );
                }
            }
        }
        fclose( $handle );
    }
}



// Asegúrate de que este código se ejecute dentro del entorno de WordPress

// Hook para registrar el Custom Post Type y la taxonomía
add_action('init', 'registrar_bebidas_y_tipos_de_bebida', 0);

function registrar_bebidas_y_tipos_de_bebida() {
    // Registrar el Custom Post Type "Bebidas"
    $labels = array(
        'name'               => _x('Bebidas', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Bebida', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Bebidas', 'admin menu', 'textdomain'),
        'name_admin_bar'     => _x('Bebida', 'add new on admin bar', 'textdomain'),
        'add_new'            => _x('Añadir Nueva', 'bebida', 'textdomain'),
        'add_new_item'       => __('Añadir Nueva Bebida', 'textdomain'),
        'new_item'           => __('Nueva Bebida', 'textdomain'),
        'edit_item'          => __('Editar Bebida', 'textdomain'),
        'view_item'          => __('Ver Bebida', 'textdomain'),
        'all_items'          => __('Todas las Bebidas', 'textdomain'),
        'search_items'       => __('Buscar Bebidas', 'textdomain'),
        'parent_item_colon'  => __('Bebida Padre:', 'textdomain'),
        'not_found'          => __('No se encontraron bebidas.', 'textdomain'),
        'not_found_in_trash' => __('No se encontraron bebidas en la papelera.', 'textdomain')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'bebidas'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('bebidas', $args);

    // Registrar la taxonomía personalizada "Tipos de Bebida"
    $labels = array(
        'name'              => _x('Tipos de Bebida', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Tipo de Bebida', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Buscar Tipos de Bebida', 'textdomain'),
        'all_items'         => __('Todos los Tipos de Bebida', 'textdomain'),
        'parent_item'       => __('Tipo de Bebida Padre', 'textdomain'),
        'parent_item_colon' => __('Tipo de Bebida Padre:', 'textdomain'),
        'edit_item'         => __('Editar Tipo de Bebida', 'textdomain'),
        'update_item'       => __('Actualizar Tipo de Bebida', 'textdomain'),
        'add_new_item'      => __('Añadir Nuevo Tipo de Bebida', 'textdomain'),
        'new_item_name'     => __('Nuevo Nombre de Tipo de Bebida', 'textdomain'),
        'menu_name'         => __('Tipos de Bebida', 'textdomain')
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipo-de-bebida')
    );

    register_taxonomy('tipo_de_bebida', array('bebidas'), $args);
}

function activar(){};
function desactivar(){};
function borrar(){};

register_activation_hook(__FILE__, 'activar');
register_deactivation_hook(__FILE__, 'desactivar');
register_uninstall_hook(__FILE__, 'borrar');
?>