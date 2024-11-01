<?php
/*
Plugin Name: Todo Espaço Online - Links | Felipe
Plugin URI: http://linkloco.net/novo/wordpress/wordpress-plugin-envie-seus-links-para-o-teo-links/
Description: Envia os posts selecionado do seu blog para o diretório de links do <a href="http://todoespacoonline.com/"  target="_blank">Todo Espaço Onine</a>, de forma prática e rápida.
Author: Felipe Valtl de Mello
Version: 0.1
Author URI: http://linkloco.net/novo/author/admin/

Copyright (C) 2011  Felipe Valtl de Mello  ( email : valtlfelipe@gmail.com )

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


    function fb_add_admin_bar_trash_menu() {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
    return;
    $current_object = get_queried_object();
    if ( empty($current_object) )
    return;
    if ( !empty( $current_object->post_type ) &&
    ( $post_type_object = get_post_type_object( $current_object->post_type ) ) &&
    current_user_can( $post_type_object->cap->edit_post, $current_object->ID )
    ) {
		$caminho = "/wp-content/plugins/teo-links/teo.php?id=";
    $wp_admin_bar->add_menu(
    array( 'id' => 'teo',
    'title' => __('Enviar para o TEO'),
    'href' => get_bloginfo('url') . $caminho . $current_object->ID
    )
    );
    }
    }
    add_action( 'admin_bar_menu', 'fb_add_admin_bar_trash_menu', 35 );
	
	
function teo_links_admin_msg() {
	if( get_option('teo_nome') == '' || get_option('teo_feed') == '' || get_option('teo_twitter') == '')
		echo '<div class="error"><p><strong>É necessário configurar o TEO Links, para funcionar corretamente, <a href="options-general.php?page=teo-links/teo-links.php">clique aqui para configurar</a>.</strong></p></div>';
}
add_action( 'admin_notices', 'teo_links_admin_msg' );

  add_action( 'admin_init', 'register_mysettings' );
function register_mysettings() {
	//register our settings
	register_setting( 'teo_config', 'teo_nome' );
	register_setting( 'teo_config', 'teo_feed' );
	register_setting( 'teo_config', 'teo_twitter' );
}
// add the admin menu
function teo_links_admin_page() {
global $wpdb;
if ( function_exists('add_submenu_page') )
add_submenu_page('options-general.php', __('TEO Links'), __('TEO Links'), 2, __FILE__, 'teo_links_admin');
}
add_action('admin_menu', 'teo_links_admin_page');

function teo_links_admin() { 
// content of menu page
?>
<?php   //settings
  	if (!current_user_can('manage_options'))  {
		wp_die( __('Você não tem permisões suficientes para acessar essa página.') );
	} ?>
 
	<div class="wrap"><div id="icon-tools" class="icon32"></div>
    <h2>Teo Links | Configuração</h2>
    <?php if ($_GET['updated']==true) { ?>
    <br><div id="message" class="updated">
        <p>
        Configurações Salvas.
        </p> <?php } ?>
        
    <form  method="post" action="options.php">
 <?php settings_fields( 'teo_config' ); ?>
<table width="100%" border="0">
  <tr>
    <td width="125">*Seu Nome:</td>
    <td width="827"><input name="teo_nome" type="text" value="<?php echo get_option('teo_nome'); ?>" size="40"></td>
  </tr>
  <tr>
    <td>*Twitter do seu Site:</td>
    <td>
    <input name="teo_twitter" type="text" value="<?php echo get_option('teo_twitter'); ?>" size="40">
    <em>Deve incluir &quot;http://twitter.com/&quot;</em></td>
  </tr>
  <tr>
    <td>*Feed do seu Site:</td>
    <td>
    <input name="teo_feed" type="text" value="<?php echo get_option('teo_feed'); ?>" size="40">
    <em>Se não sabe o que colocar, use isso: &quot;<?php $blog_rss = get_bloginfo('rss2_url'); echo $blog_rss; ?>&quot;</em></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" class="button-primary" value="Salvar"></td>
  </tr>
</table>
*Todos os campos são obrigatórios
     </form>
     <h6 align="center">© 2011 <a href="http://linkloco.net/novo/wordpress/wordpress-plugin-envie-seus-links-para-o-teo-links/" target="_blank">TEO Links | Felipe</a> - Todos os direitos reservados</h6>
    </div>
<?php } 
// add a colun to the posts page

add_filter( 'manage_posts_columns', 'teo_links_col');
function teo_links_col($cols) {
$cols['teo_links'] = __('TEO Links');
return $cols;
}
add_action( 'manage_posts_custom_column', 'teo_links_btn');

function teo_links_btn($column_name ) {
if ( $column_name  == 'teo_links'  ) {
	$caminho = "/wp-content/plugins/teo-links/teo.php?id=";
//content os the posts column page
?>
<form id="form<?php the_ID(); ?>" name="form<?php the_ID(); ?>" method="post" action="">
<input name="botao" type="button" id="botao" onClick="javascript:window.location='<?php echo get_bloginfo('url'); ?><?php echo $caminho; ?><?php the_ID(); ?>';" value="Enviar" />
</form>
<?php } } ?>
