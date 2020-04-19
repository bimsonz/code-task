<?php

/**
 * @file
 * Drush 8 Support.
 */

/**
 * Implements hook_drush_command().
 */
function content_importer_drush_command() {

  $items['content-importer-import-articles'] = [
    'description' => 'Import article content.',
    'aliases' => ['ciia'],
  ];

  return $items;
}

/**
 * Import article content command.
 */
function drush_content_importer_import_articles() {
  $importer = \Drupal::service('content_importer.importer.article');

  $importer->import();
}
