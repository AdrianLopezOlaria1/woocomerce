<?php

require_once("./wp-load.php");

// Verificar si se ha hecho clic en el botón de generar PDF
if (isset($_POST['generate_pdf'])) {
    echo"<p>recibido</p>";
}

?>



<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="contenido">
        <h1>Tabla de productos</h1>
        <div class="product-table">
            <form method="post" action="" id="tabla">
                
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>En Stock</th>
                            <th>Fecha de Publicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Configuración de la consulta
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                        );

                        // Consulta de productos
                        $loop = new WP_Query($args);

                        // Verificar si la consulta tiene resultados
                        if ($loop->have_posts()) :
                            // Loop para mostrar productos
                            while ($loop->have_posts()) : $loop->the_post();
                                global $product;
                                ?>
                                <tr>
                                    <td><?php the_title(); ?></td>
                                    <td class="description"><?php echo $product->get_description(); ?></td>
                                    <td><?php echo wc_price($product->get_price_html()); ?></td>
                                    <td><?php echo $product->is_in_stock() ? 'Sí' : 'No'; ?></td>
                                    <td><?php echo get_the_time('F j, Y'); ?></td>
                                </tr>
                            <?php endwhile;
                            // Restablecer consulta de productos
                            wp_reset_postdata();
                        else :
                            // No hay productos disponibles
                            echo '<tr><td colspan="5">No hay productos disponibles</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
                
            </form>
            
        </div>
        <button type="submit" id="generate_pdf" name="generate_pdf">Generar PDF</button>
    </div><!-- div contenido end -->
    
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            let generate_pdf = document.getElementById("generate_pdf");
            let formulario = document.getElementById("tabla")
            generate_pdf.addEventListener('click', enviar);
            
            function enviar() {
                formulario.submit();
            }
        });
        </script>
</body>
