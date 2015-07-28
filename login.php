<?php
/*
Template Name: Página de login
*/
get_header();
 
// Dados do formulário de login
$argumentos_login = array(
    'echo'           => true,
    'redirect'       => get_home_url(), 
    'form_id'        => 'tp-login-form',
    'label_username' => __( 'Username' ),
    'label_password' => __( 'Password' ),
    'label_remember' => __( 'Remember Me' ),
    'label_log_in'   => __( 'Log In' ),
    'id_username'    => 'tp-user-login',
    'id_password'    => 'tp-user-pass',
    'id_remember'    => 'tp-remember-me',
    'id_submit'      => 'tp-submit-btn',
    'remember'       => true,
    'value_username' => null,
    'value_remember' => false,
);
?> 
 
<div class="tp-login-container">
 
    <?php if ( ! is_user_logged_in() ): ?>
            
        <?php wp_login_form( $argumentos_login );?>
            
    <?php 
    else:
        
        // Usuário atual
        $usuario_atual = wp_get_current_user();
        
        // URL da página de login
        $pagina_login = 'http://127.0.0.1/trabalhos/wordpress/login/';
        
        // Mensagem para o usuário
        echo '<p>Você já fez login <b>' . $usuario_atual->user_firstname . '</b>.';
        echo ' Clique <a href="' . wp_logout_url( $pagina_login ) . '">aqui</a>';
        echo ' para sair.';
        echo '</p>'; 
        
    endif; // is_user_logged_in
    ?>
    
</div> <!-- tp-login-container -->
 
<?php
get_footer();
?>