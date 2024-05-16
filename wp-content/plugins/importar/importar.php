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
                
                $product_data = array(
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
                );                                        
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

function activar(){};
function desactivar(){};
function borrar(){};

register_activation_hook(__FILE__, 'activar');
register_deactivation_hook(__FILE__, 'desactivar');
register_uninstall_hook(__FILE__, 'borrar');
?>