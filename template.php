<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 * 
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "fo_common" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "fo_common".
 * 2. Uncomment the required function to use.
 */

function fo_common_preprocess_field(&$variables, $hook) {
  // Add sub-labels to Records fields with HTML classes for styling
  switch($variables['element']['#field_name']) {
    case 'field_record_active':
      $variables['label'] = $variables['label'] . ' <span class="sub-label">(Used during the course of University or departmental operations)</span>';
      break;
    case 'field_record_location':
      $variables['label'] = $variables['label'] . ' <span class="sub-label">(Central Administrative Unit or Local Department)</span>';
      break;
    case 'field_record_inactive':
      $variables['label'] = $variables['label'] . ' <span class="sub-label">(No longer needed during regular course of operations, but retained for legal or business purposes)</span>';
      break;
    case 'field_record_permanent':
      $variables['label'] = $variables['label'] . ' <span class="sub-label">(May be required for legal, historical or business purposes or recommended for records of enduring value)</span>';
      break;
  }
}

/**
 * Implmenets hook_block_view_MODULE_DELTA_alter().
 */
function fo_common_block_view_book_navigation_alter(&$data, $block) {
  // Display the title of the Book Navigation block as plain text, ie not a link
  $current_bid = 0;
  if ($node = menu_get_object()) {
    $current_bid = empty($node->book['bid']) ? 0 : $node->book['bid'];
  }

  if ($current_bid) {
    // Only display this block when the user is browsing a book.
  $select = db_select('node', 'n')
    ->fields('n', array('title'))
    ->condition('n.nid', $node->book['bid'])
    ->addTag('node_access');
    $title = $select->execute()->fetchField();
    // Only show the block if the user has view access for the top-level node.
    if ($title) {
      $tree = menu_tree_all_data($node->book['menu_name'], $node->book);
      // There should only be one element at the top level.
      $link_data = array_shift($tree);
      $data['subject'] = $link_data['link']['link_title'];
    }
  }
}


/**
 * Preprocess variables for the html template.
 */
/* -- Delete this line to enable.
function fo_common_preprocess_html(&$vars) {
  global $theme_key;

  // Two examples of adding custom classes to the body.
  
  // Add a body class for the active theme name.
  // $vars['classes_array'][] = drupal_html_class($theme_key);

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  // $vars['classes_array'][] = css_browser_selector();

}
// */


/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function fo_common_process_html(&$vars) {
}
// */


/**
 * Override or insert variables for the page templates.
 */
/* -- Delete this line if you want to use these functions
function fo_common_preprocess_page(&$vars) {
}
function fo_common_process_page(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function fo_common_preprocess_node(&$vars) {
}
function fo_common_process_node(&$vars) {
}
// */


/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function fo_common_preprocess_comment(&$vars) {
}
function fo_common_process_comment(&$vars) {
}
// */


/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function fo_common_preprocess_block(&$vars) {
}
function fo_common_process_block(&$vars) {
}
// */
