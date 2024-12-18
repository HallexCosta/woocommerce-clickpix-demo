<?php

// Verifica se o arquivo plugin.php foi incluído
if ( ! function_exists( 'is_plugin_active' ) ) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

function check_required_plugins() {
  $plugins_to_check = [
    'duplicator/duplicator.php' => [
      'name' => 'Duplicator',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=duplicator' ), 'install-plugin_duplicator' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=duplicator/duplicator.php' ), 'activate-plugin_duplicator/duplicator.php' )
    ],
    'meta-box/meta-box.php' => [
      'name' => 'RWMB Meta Box',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=meta-box' ), 'install-plugin_meta-box' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=meta-box/meta-box.php' ), 'activate-plugin_meta-box/meta-box.php' )
    ],
    'wp-mail-smtp/wp_mail_smtp.php' => [
      'name' => 'WP SMTP Mail',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=wp-mail-smtp' ), 'install-plugin_wp-mail-smtp' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=wp-mail-smtp/wp_mail_smtp.php' ), 'activate-plugin_wp-mail-smtp/wp_mail_smtp.php' )
    ],
    'broken-link-checker/broken-link-checker.php' => [
      'name' => 'Broken Link Checker',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=broken-link-checker' ), 'install-plugin_broken-link-checker' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=broken-link-checker/broken-link-checker.php' ), 'activate-plugin_broken-link-checker/broken-link-checker.php' )
    ],
    'smartcrawl-seo/wpmu-dev-seo.php' => [
      'name' => 'SmartCrawl',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=smartcrawl-seo' ), 'install-plugin_smartcrawl-seo' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=smartcrawl-seo/wpmu-dev-seo.php' ), 'activate-plugin_smartcrawl-seo/wpmu-dev-seo.php' )
    ],
    'simple-custom-post-order/simple-custom-post-order.php' => [
      'name' => 'Simple Custom Post Order',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=simple-custom-post-order' ), 'install-plugin_simple-custom-post-order' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=simple-custom-post-order/simple-custom-post-order.php' ), 'activate-plugin_simple-custom-post-order/simple-custom-post-order.php' )
    ],
    'ilab-media-tools/ilab-media-tools.php' => [
      'name' => 'Media Cloud',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=ilab-media-tools' ), 'install-plugin_ilab-media-tools' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=ilab-media-tools/ilab-media-tools.php' ), 'activate-plugin_ilab-media-tools/ilab-media-tools.php' )
    ],
    'nitropack/main.php' => [
      'name' => 'NitroPack',
      'install_url' => wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=nitropack' ), 'install-plugin_nitropack' ),
      'activate_url' => wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=nitropack/main.php' ), 'activate-plugin_nitropack/main.php' )
    ],
  ];

  foreach ( $plugins_to_check as $plugin_file => $plugin_data ) {
    if ( ! is_plugin_active( $plugin_file ) ) {
      if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
        echo '<div class="notice notice-warning">
                <p>O plugin ' . $plugin_data['name'] . ' está instalado, mas não está ativo. <a href="' . $plugin_data['activate_url'] . '">Clique aqui para ativar</a>.</p>
              </div>';
      } else {
        echo '<div class="notice notice-error">
              <p>O plugin ' . $plugin_data['name'] . ' não está instalado. <a href="' . $plugin_data['install_url'] . '">Clique aqui para instalar</a>.</p>
            </div>';
      }
    }
  }
}

add_action( 'admin_notices', 'check_required_plugins' );
