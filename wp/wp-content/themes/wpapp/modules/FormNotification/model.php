<?php
class FormNotificationModel {
  public static $cptTitleSingular = 'Formulário Notificação';
  public static $cptTitlePlural = 'Formulário Notificações';
  public static $cptNameSingular = 'form-notification';
  public static $cptNamePlural = 'form-notifications';
  public static $menuSlug = 'form-menu-notifications';

  public static $postType;
  public static $recipients = [];
  public static $out = [];
  public static $submenu;

  public function __construct() {
    self::$recipients[] = 'hallan.costa1.backup@gmail.com'; // Fallback
    self::$postType = self::$cptNameSingular; // Fallback
    self::addRecipients();
  }

  public function run() {
    add_action('admin_menu', [__CLASS__, 'createMenu']);
    add_action('admin_init', [__CLASS__, 'notificationRegister']);
    add_action('admin_head', [__CLASS__, 'styles']);
  }

  public static function notificationRegister() {
    register_setting( 'cs-notifications-settings', 'form_' . self::$cptNameSingular );
  }

  public static function createMenu() {
    global $menu;

    add_menu_page(
      'Formulários',
      'Formulários',
      'read_' . self::$cptNamePlural, // Nível de permissão necessário para acessar
      self::$menuSlug, // Cria menu Formulários - slug do menu pai
      'edit.php?post_type=' . self::$cptNameSingular, // Função de callback para renderizar o conteúdo
      'dashicons-buddicons-pm', // Ícone do menu (veja a lista de ícones no Codex)
      6 // Posição do menu (use um número alto para colocá-lo no final)
    );

    add_submenu_page(
      self::$menuSlug, 
      'Notificações', 
      'Notificações', 
      'read_' . self::$cptNamePlural, 
      'notifications', 
      function() { self::recipientsNotificationHtml(); }
    );

    add_submenu_page(
      self::$menuSlug, 
      'Separator', 
      '<span style="user-select: none; display:block; margin:1px 0 1px -5px; padding:0; height:1px; line-height:1px; background-color: rgba(255, 255, 255, 0.3)"></span>', 
      'read_' . self::$cptNamePlural, 
      '#'
    );

    remove_submenu_page( self::$menuSlug, self::$menuSlug ); // Remove sub menu que faz referência ao pai
  }

  public static function recipientsNotificationHtml() {
    $form_contact = esc_attr( get_option('form_' . self::$cptNameSingular) );

    $formNotification = 'form_' . self::$cptNameSingular;

    echo <<<HEREDOC
<div class="wrap">
    <h1>Notificações</h1>

    <form method="post" action="options.php">
HEREDOC;
        settings_fields( 'cs-notifications-settings' );
        do_settings_sections( 'cs-notifications-settings' );
        echo <<<HEREDOC
        <table class="form-table">
          <tr valign="top">
          <th scope="row">Notificação:<br><span style="display: inline-block;font-size: 13px;font-weight: 500;padding-top: 7px;color: #888">Informe os e-mails que vão receber o formulário.</span></th>
          <td><textarea name="$formNotification" style="width: 100%; min-height: 150px" placeholder="Exemplo:\nteste1@email.com.br\nteste2@email.com.br">{$form_contact}</textarea></td>
          </tr>
        </table>
HEREDOC;
        submit_button();
echo <<<HEREDOC
    </form>
</div>
HEREDOC;
  }

  public static function addRecipients() {    
    $formContact = get_option('form_' . self::$cptNameSingular);
    
    if ($formContact) {
      $tempEmails = esc_attr( $formContact );
      $emails = [];
      $mtemp = array_map('trim', explode("\n", $tempEmails));
      foreach ($mtemp as $uemail) {
        if (filter_var($uemail, FILTER_VALIDATE_EMAIL))
          $emails[] = $uemail;
      }

      
      if (count($emails) > 0) {
        self::$recipients = $emails;
      }
    }
  }

  public static function templateEmail($subject, $data) {    
    $datetime = formatDateTime('now', 'Y-m-d H:i:s');
    $datetime_fmt = date('d/m/Y H:i', strtotime($datetime));

    $template_data = "";

    foreach ($data as $key => $value) {
      $template_data .= "<li>$key: $value</li>";
    }

    $template_data .= "<li>Data: $datetime_fmt</li>";

    return "
    <html>
      <body style='background-color: #f8f8f8; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5;'>
          <table style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff;'>
              <tbody>
                  <tr>
                    <td style='display: block; padding: 25px; gap: 20px;'>
                      <h1 style='text-align: center; font-size: 34px; color: #e8534a; font-weight: 700;'>$subject</h1>
                      <p style='text-align: justify; margin: 15px auto; text-align: center; max-width: 235px;'>Chegou uma mensagem atrav&eacute;s do site $subject!</p>
                      <ul>
                        $template_data
                      </ul>
                    </td>
                  </tr>
              </tbody>
          </table>
      </body>
    </html>
    ";
  }

  /**
   * Styles dashboard wordpress
   */
  public static function styles() {
    global $post_type;
    
    if ($post_type == self::$postType) {
      ?>
      <style>
          /* Ocultar items da visualização do contato */
          #add_pod_button, 
          #misc-publishing-actions, 
          #minor-publishing-actions, 
          #postbox-container-1,
          #titlewrap { 
            display: none !important; 
          }
      </style>
      <?php
    }
  }
}