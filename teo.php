 <?php
 require_once('../../../wp-blog-header.php');
 ?>
<?php if( current_user_can('level_10') ) : ?>
<?php if ($_GET['id'] == '') { ?>


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Erro</title>
	<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/css/install.css" type="text/css" />
</head>
<body id="error-page">
	<p><h2>H&aacute; erros, por favor volte e verifique!</h2></p><br><a href="javascript:history.go(-1)" class="button-secondary">Voltar </a></body>
<?php } else {
	?>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Enviar Link TEO</title>
	<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/css/install.css" type="text/css" />
</head>
<body id="error-page">
	
<?php
 require_once('../../../wp-blog-header.php');
 $getid = $_GET['id'];
 ?>
 
 <?php 
function get_post_data($getid) {
global $wpdb;
return $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID=$getid");

}
$data = get_post_data($getid);
$posttitle = $data[0]->post_title;
$posturl =  $data[0]->guid;
$conteudo = $data[0]->post_content;
?>
<?php
$size = 'thumbnail';
$images = get_children(array(
'post_type' => 'attachment',
'numberposts' => 1,
'post_status' => null,
'post_parent' => $_GET['id'],));
foreach($images as $image) {
$attachment=wp_get_attachment_image_src($image->ID, $size);
}
if ($attachment == "") {
	echo '<font color="#FF0000"><p><strong><h3>É necessário ter uma imagem para seu post.</h3> <a href="'.get_bloginfo('wpurl'). '/wp-admin/post.php?post='. $getid .'&action=edit">Clique aqui para editar.</a></strong></p></font>';
}
?>
<h1>Verifique os dados abaixo:</h1>
<table border="0">
  <tr>
    <td><strong>T&iacute;tulo:</strong></td>
    <td><?php echo $posttitle; ?></td>
  </tr>
   <tr>
    <td><strong>Link:</strong></td>
    <td><?php echo $posturl; ?></td>
  </tr>
  <tr>
    <td><strong>Descri&ccedil;&atilde;o:</strong></td>
    <td><?php $resumo = substr(strip_tags($conteudo), 0, 197).'...'; echo $resumo; ?></td>
  </tr>
    <tr>
    <td valign="top"><strong>Imagem:</strong></td>
  <td><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/teo-links/timthumb.php?src=<?php echo $attachment[0]; ?>&h=150&w=150&zc=1<?php echo $attributes; ?>"> </td>
  </tr>
</table>


<form id="form<?php echo $getid; ?>" name="form<?php echo $getid; ?>" method="post" action="http://www.todoespacoonline.com/links/envia_link.php" target="_blank">
<input name="email" type="hidden" value="<?php $blog_adminemail = get_bloginfo('admin_email'); echo $blog_adminemail; ?>" />
<input name="titulo" type="hidden" value="<?php echo $posttitle; ?>" />
<input name="feedlinks" type="hidden" value="<?php echo get_option('teo_feed'); ?>" />
  <tr>
    <td><strong>Selecione uma categoria: </strong></td>
    <td><select name="categoria">
                <option value=""></option>
                </option><option value="Auto Ajuda">Auto Ajuda</option><option value="Autom&oacute;veis">Autom&oacute;veis</option><option value="Blogosfera">Blogosfera</option><option value="Cultura">Cultura</option><option value="Curiosidades">Curiosidades</option><option value="Esporte">Esporte</option><option value="Estilo">Estilo</option><option value="Estilo de Vida">Estilo de Vida</option><option value="Filmes/TV">Filmes/TV</option><option value="Filmes/TV/V&iacute;deos">Filmes/TV/V&iacute;deos</option><option value="Humor">Humor</option><option value="Jogos">Jogos</option><option value="Literatura">Literatura</option><option value="Moda e Beleza">Moda e Beleza</option><option value="M&uacute;sica">M&uacute;sica</option><option value="Filmes/TV/V&iacute;deos">Pol&iacute;tica</option><option value="Religi&atilde;o">Religi&atilde;o</option><option value="Tecnologia">Tecnologia</option><option value="Turismo">Turismo</option>
                </select></td>
  </tr>
<input name="site" type="hidden" value="<?php $blog_title = get_bloginfo('name'); echo $blog_title; ?>" />
<input name="url" type="hidden" value="<?php echo $posturl; ?>" />
<input name="descricao" type="hidden" value="<?php $resumo = substr(strip_tags($conteudo), 0, 197).'...'; echo $resumo; ?>" />
<input name="urlimagem" type="hidden" value="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/teo-links/timthumb.php?src=<?php echo $attachment[0]; ?>&h=150&w=150&zc=1<?php echo $attributes; ?>" />
<input name="nome" type="hidden" value="<?php echo get_option('teo_nome'); ?>" />
<input name="twitterlinks" type="hidden" value="<?php echo get_option('teo_twitter'); ?>" />
<input name="data" type="hidden" value="<?php echo date('Y/m/d',current_time('timestamp')); ?>" />
<input name="hora" type="hidden" value="<?php echo date('H:i:s',current_time('timestamp')); ?>" />


<table width="100%" border="0">
  <tr>
    <td align="left" valign="middle"><a href="javascript:history.go(-1)" class="button-secondary">Voltar </a></td>
    <td align="right" valign="middle">Confirmar dados? <input class="button" type="submit" name="enviar" value="Enviar" <?php if ($attachment == "") { echo 'disabled="disabled"'; } ?> /></td>
  </tr>
</table>
</form>
</body>

<?php } ?>
<?php else : ?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Erro &rsaquo; WordPress</title>
	<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/css/install.css" type="text/css" />
</head>
<body id="error-page">
	<p>Sem permiss&otilde;es suficientes para acessar esta p&aacute;gina.</p></body>

<?php endif; ?>
<h6 align="center">&copy; 2011 <a href="http://linkloco.net/novo/wordpress/wordpress-plugin-envie-seus-links-para-o-teo-links/" target="_blank">TEO Links | Felipe</a> - Todos os direitos reservados</h6>