<?php
function dwCustLogIn_settings_page() {
  // Check if the user has the necessary permissions
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }

  // Display the form for the settings page
  ?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="options.php">
      <?php
      // Print the fields for the settings page
      settings_fields('dwCustLogIn_options');
      do_settings_sections('dw-cust-login');
      submit_button();
      ?>
    </form>
  </div>
  <?php
}

function dwCustLogIn_settings_init() {
  // Register the settings for the plugin
  register_setting('dwCustLogIn_options', 'dwCustLogIn_options', 'dwCustLogIn_options_validate');

  // Add a section for the settings page
  add_settings_section('dwCustLogIn_section', __('Custom Login Settings', 'dw-cust-login'), 'dwCustLogIn_section_text', 'dw-cust-login');

  // Add the fields for the settings page
  add_settings_field('dwCustLogIn_field_image', __('Image', 'dw-cust-login'), 'dwCustLogIn_field_image_render', 'dw-cust-login', 'dwCustLogIn_section');
  add_settings_field('dwCustLogIn_field_colour1', __('Highlight Colour', 'dw-cust-login'), 'dwCustLogIn_field_colour1_render', 'dw-cust-login', 'dwCustLogIn_section');
  add_settings_field('dwCustLogIn_field_colour2', __('Button Text', 'dw-cust-login'), 'dwCustLogIn_field_colour2_render', 'dw-cust-login', 'dwCustLogIn_section');
}


function dwCustLogIn_section_text() {
  // Display a description for the section
  echo __('Configure the style of the login page', 'dw-cust-login');
}

function dwCustLogIn_field_image_render() {
  $options = get_option('dwCustLogIn_options');
  ?>
  <input type="text" name="dwCustLogIn_options[image]" value="<?php echo esc_attr($options['image']) ?>" />
  <?php
}

function dwCustLogIn_field_colour1_render() {
  $options = get_option('dwCustLogIn_options');
  ?>
  <input type="text" name="dwCustLogIn_options[colour1]" value="<?php echo esc_attr($options['colour1']) ?>" />
  <?php
}

function dwCustLogIn_field_colour2_render() {
  $options = get_option('dwCustLogIn_options');
  ?>
  <input type="text" name="dwCustLogIn_options[colour2]" value="<?php echo esc_attr($options['colour2']); ?>" />
  <?php
}

function dwCustLogIn_options_validate($input) {
  // Validate and sanitize the input data
  $new_input = array();

  if (isset($input['image'])) {
    $new_input['image'] = sanitize_text_field($input['image']);
  }

  if (isset($input['colour1'])) {
    $new_input['colour1'] = sanitize_text_field($input['colour1']);
  }

  if (isset($input['colour2'])) {
    $new_input['colour2'] = sanitize_text_field($input['colour2']);
  }

  return $new_input;
}

function dwCustLogIn_menu() {
  // Add the settings page to the WordPress menu
  add_options_page(
    __('Custom Login Settings', 'dw-cust-login'),
    __('Custom Login', 'dw-cust-login'),
    'manage_options',
    'dw-cust-login',
    'dwCustLogIn_settings_page'
  );
}

function dwCustLogIn_options_init() {
    // Initialize the default values for the plugin options
    $defaults = array(
      'image' => '',
      'colour1' => '',
      'colour2' => '',
    );
  
    // If the option does not already exist in the database, add it
    if (!get_option('dwCustLogIn_options')) {
      add_option('dwCustLogIn_options', $defaults);
    }
  }


add_action('admin_init', 'dwCustLogIn_options_init');
add_action('admin_menu', 'dwCustLogIn_menu');
add_action('admin_init', 'dwCustLogIn_settings_init');
