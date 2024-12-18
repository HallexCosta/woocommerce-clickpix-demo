<?php
/**
 * Install plugin rwmb metabox
 */

class FormContactModel {
  public static $cptTitleSingular = 'Formulário Contato';
  public static $cptTitlePlural = 'Formulário Contatos';
  public static $cptNameSingular = 'form-contact';
  public static $cptNamePlural = 'form-contacts';
  public static $cptLabelSingular = 'Contact';
  public static $cptLabelPlural = 'Contacts';
  public static $cptAddNewItem = 'Adicionar novo contato';
  public static $cptAllItems = 'Todas os Contatos';
  public static $cptNotFound = 'Nenhum contato encontrado';
  public static $cptDescription = 'Inscritos através do formulário Contato';

  public static $postType; 
  public static $out = [];

  public function __construct() {
    self::$postType = self::$cptNameSingular;
  }

  public static function run() {
    add_action('init', [__CLASS__, 'addCapabilitiesAdmin']);
    add_action('init', [__CLASS__, 'addCapabilitiesAuthor']);
    add_action('init', [__CLASS__, 'registerCpt']);
    
    add_filter('manage_'.self::$postType.'_posts_columns', [__CLASS__, 'createColumnsDashboardList']);
    add_action('manage_'.self::$postType.'_posts_custom_column', [__CLASS__, 'addValuesColumnsDashboardList'], 10, 2);

    add_action('admin_menu', [__CLASS__, 'createMenu']);

    add_filter('post_row_actions', [__CLASS__, 'removeActions'], 10, 2);

    add_action('admin_head', [__CLASS__, 'styles']);
  }

  public static function isValidContact($data) {
    if (!check_email($data['email'])) {
      self::$out["staus"] = 400;
      self::$out["message"] = "Dados do formulários inválidos!";
      self::$out["data"] = $data;
      return false;
    }

    return true;
  }

  public static function addCapabilitiesAdmin() {
    // Contact
    $roleAdministrator = get_role( 'administrator' );
    $roleAdministrator->add_cap( 'delete_published_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_private_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_others_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_' . self::$postType, true );
    $roleAdministrator->add_cap( 'delete_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'read_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_' . self::$postType, true );
    $roleAdministrator->add_cap( 'edit_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'publish_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_published_' . self::$cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_others_' . self::$cptNamePlural, true );

    $roleAdministrator->add_cap( 'read_' . FormNotificationModel::$cptNamePlural, true );
  }

  public static function addCapabilitiesAuthor() {
    // Contact
    $roleAuthor = get_role( 'author' );
    $roleAuthor->add_cap( 'delete_published_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'delete_private_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'delete_others_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'delete_' . self::$postType, true );
    $roleAuthor->add_cap( 'delete_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'read_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'edit_' . self::$postType, true );
    $roleAuthor->add_cap( 'edit_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'publish_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'edit_published_' . self::$cptNamePlural, true );
    $roleAuthor->add_cap( 'edit_others_' . self::$cptNamePlural, true );

    $roleAuthor->add_cap( 'read_' . FormNotificationModel::$cptNamePlural, true );
  }


  public static function registerCpt() {
    $capabilities = [
      'delete_published_posts' => 'delete_published_' . self::$cptNamePlural,
      'delete_private_posts' => 'delete_private_' . self::$cptNamePlural,
      'delete_others_posts' => 'delete_others_' . self::$cptNamePlural,
      'delete_post' => 'delete_' . self::$postType,
      'delete_posts' => 'delete_' . self::$cptNamePlural,
      'create_posts' => false,//'create_' . self::$cptNamePlural, // false,
      'read_posts' => 'read_' . self::$cptNamePlural,
      'edit_post' => 'edit_' . self::$postType,
      'edit_posts' => 'edit_' . self::$cptNamePlural,
      'publish_posts' => 'publish_' . self::$cptNamePlural, // false,
      'edit_published_posts' => 'edit_published_' . self::$cptNamePlural,
      'edit_others_posts' => 'edit_others_' . self::$cptNamePlural
    ];

    $labels = [
      'name' => self::$cptTitleSingular,
      'name_admin_bar' => self::$cptTitleSingular,
      'singular_name' => self::$cptLabelSingular,
      'featured_image' => 'Imagem destacada',
      'set_featured_image' => 'Definir imagem destacada',
      'add_new_item' => self::$cptAddNewItem,
      'all_items' => self::$cptAllItems,
      'not_found' => self::$cptNotFound,
    ];

    $cpt = [
      'capabilities' => $capabilities,
      'labels' => $labels,
      //'menu_icon' => 'dashicons-buddicons-pm',
      'menu_icon' => 'dashicons-email-alt2',
      'description' => self::$cptDescription,
      //'public' => true,
      'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
      'publicly_queryable' => false,  // you should be able to query it
      'show_ui' => true,  // you should be able to edit it in wp-admin
      'exclude_from_search' => true,  // you should exclude it from search results
      'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
      'has_archive' => false,  // it shouldn't have archive page
      'rewrite' => false,  // it shouldn't have rewrite rules
      'supports' => [
        'title'
      ],
    ];

    register_post_type(self::$postType, $cpt);
  }

  public static function createMenu() {
    add_submenu_page(
      FormNotificationModel::$menuSlug, // Adicionar a entidade contato no slug menu Formulário (form-menu)
      self::$cptTitlePlural,
      self::$cptTitlePlural,
      'read_' . self::$cptNamePlural,
      'edit.php?post_type=' . self::$postType,
    );
     
    remove_menu_page( 'edit.php?post_type=' . self::$postType ); // Remove menu contato
  }

  public static function templateEmail($subject, $data) {    
    $datetime = formatDateTime('now', 'Y-m-d H:i:s');
    $datetime_fmt = date('d/m/Y H:i', strtotime($datetime));

    $name = $data['name'];
    $email = $data['email'];
    $whatsapp = $data['whatsapp'];
    $cnpj = $data['cnpj'];
    $state = $data['state'];
    $zipcode = $data['zipcode'];
    $message = $data['message'];

    return "
    <html>
      <body style='background-color: #f8f8f8; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5;'>
          <table style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff;'>
              <tbody>
                  <tr>
                    <td style='display: block; padding: 25px; gap: 20px;'>
                      <h1 style='text-align: center; font-size: 34px; color: #e8534a; font-weight: 700;'>$subject - Contato</h1>
                      <p style='text-align: justify; margin: 15px auto; text-align: center; max-width: 235px;'>Chegou uma mensagem atrav&eacute;s do site $subject!</p>
                      <ul>
                        <li>Data: $datetime_fmt</li>
                        <li>Nome: $name</li>
                        <li>Email: $email</li>
                        <li>Whatsapp: $whatsapp</li>
                        <li>CNPJ: $cnpj</li>
                        <li>Estado: $state</li>
                        <li>CEP: $zipcode</li>
                        <li>Mensagem: $message</li>
                      </ul>
                    </td>
                  </tr>
              </tbody>
          </table>
      </body>
    </html>
    ";
  }

  public static function getRWMBMetaFields() {
    return array(
      'id' => self::$postType,
      'title' => 'Formulário de ' . self::$cptTitleSingular,
      'post_types' => [ self::$postType ],
      'context' => 'normal',
      'fields' => array(
        array(
          'name' => 'Nome',
          'id' => 'name',
          'type' => 'text',
          'placeholder' => 'Nome',
          'maxlength' => 255
        ),
        array(
          'name' => 'E-mail',
          'id' => 'email',
          'type' => 'text',
          'placeholder' => 'email@hotmail.com',
        ),
        array(
          'name' => 'Whatsapp',
          'id' => 'whatsapp',
          'type' => 'text',
          'placeholder' => '(00) 00000-0000',
        ),
        array(
          'name' => 'CPNJ',
          'id' => 'cnpj',
          'type' => 'text',
          'placeholder' => 'XX.XXX.XXX/0001-XX',
        ),
        array(
          'name' => 'Estado',
          'id' => 'state',
          'type' => 'text',
          'placeholder' => 'Estado',
        ),
        array(
          'name' => 'CEP',
          'id' => 'zipcode',
          'type' => 'text',
          'placeholder' => 'CEP',
        ),
        array(
          'name' => 'Mensagem',
          'id' => 'message',
          'type' => 'text',
          'placeholder' => 'Mensagem',
        ),
      )
    );
  }

  public static function createColumnsDashboardList($columns) {
    unset($columns['date']);

    $columns = array_merge(
      $columns,
      [
        'title' => 'Nome',
        'email' => 'E-mail',
        'whatsapp' => 'Whatsapp',
        'cnpj' => 'CNPJ',
        'state' => 'Estado',
        'zipcode' => 'CEP',
        'message' => 'Mensagem',
        'data' => 'Data',
      ]
    );

    return $columns;
  }

  public static function addValuesColumnsDashboardList($columnName, $postId) {
    if ($columnName == 'title') {
      echo rwmb_get_value('name', [], $postId); // RWMB_METABOX
      // echo get_field('name', $postId)->post_title; // ACF
    }

    if ($columnName == 'email') {
      echo rwmb_get_value('email', [], $postId); // RWMB_METABOX
      // echo get_field('email', $postId); // ACF
    }

    if ($columnName == 'whatsapp') {
      echo rwmb_get_value('whatsapp', [], $postId); // RWMB_METABOX
      // echo get_field('whatsapp', $postId); // ACF
    }

    if ($columnName == 'cnpj') {
      echo str_replace( PHP_EOL, '<br />', rwmb_get_value('cnpj', [], $postId)); // RWMB_METABOX
      // echo str_replace( PHP_EOL, '<br />', get_field('cnpj', $postId) ); // ACF
    }

    if ($columnName == 'state') {
      echo str_replace( PHP_EOL, '<br />', rwmb_get_value('state', [], $postId)); // RWMB_METABOX
      // echo str_replace( PHP_EOL, '<br />', get_field('state', $postId) ); // ACF
    }

    if ($columnName == 'zipcode') {
      echo str_replace( PHP_EOL, '<br />', rwmb_get_value('zipcode', [], $postId)); // RWMB_METABOX
      // echo str_replace( PHP_EOL, '<br />', get_field('zipcode', $postId) ); // ACF
    }

    if ($columnName == 'message') {
      echo str_replace( PHP_EOL, '<br />', rwmb_get_value('message', [], $postId)); // RWMB_METABOX
      // echo str_replace( PHP_EOL, '<br />', get_field('message', $postId) ); // ACF
    }

    if ($columnName == 'data') {
      echo '<abbr title="' . get_the_date('d/m/Y H:i:s', $postId) . '">' . get_the_date('d/m/Y H:i', $postId) . '</abbr>';
    }
  }

  public static function removeActions($actions, $post) {
    if ($post->post_type == self::$postType)  {
      unset( $actions['view'] );
      unset( $actions['inline hide-if-no-js'] );
  
      unset( $actions['edit'] );
    }
    
    return $actions;
  }

  public static function save($data) {
    if (!self::isValidContact($data)) {
      return false;
    }

    $name = isset($data['name']) ? trim($data["name"]) : '';
    $email = isset($data['email']) ? trim($data["email"]) : '';
    $whatsapp = isset($data['whatsapp']) ? trim($data["whatsapp"]) : '';
    $cnpj = isset($data['cnpj']) ? trim($data["cnpj"]) : '';
    $state = isset($data['state']) ? trim($data["state"]) : '';
    $zipcode = isset($data['zipcode']) ? trim($data["zipcode"]) : '';
    $message = isset($data['message']) ? trim($data["message"]) : '';

    // Escreve a solicitação no banco de dados
    $postId = wp_insert_post([
      'post_status'   => 'publish',
      'post_type'     => self::$postType,
      'post_title'    => $name
    ]);
    $data['id'] = $postId;

    /*
    * Using RWMB_METABOX
    * Search wordpress: Meta Box – WordPress Custom Fields Framework
    */
    rwmb_set_meta( $postId, 'name', $name );
    rwmb_set_meta( $postId, 'email', $email );
    rwmb_set_meta( $postId, 'whatsapp', $whatsapp );
    rwmb_set_meta( $postId, 'cnpj', $cnpj ); 
    rwmb_set_meta( $postId, 'state', $state ); 
    rwmb_set_meta( $postId, 'zipcode', $zipcode ); 
    rwmb_set_meta( $postId, 'message', $message ); 

    /*
    * Using ACF 
    *
    update_field('email', $email, $postId);
    update_field('phone', $phone, $postId);
    update_field('message', $message, $postId); 
    */

    self::$out["status"] = 201;
    self::$out["message"] = "Mensagem enviada com sucesso!";
    self::$out["recipients"] = FormNotificationModel::$recipients;
    self::$out["data"] = $data;

    return self::$out;
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