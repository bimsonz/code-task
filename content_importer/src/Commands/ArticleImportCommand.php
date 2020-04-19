<?php

namespace Drupal\content_importer\Commands;

use Drush\Commands\DrushCommands;

class ArticleImportCommand extends DrushCommands {

  /**
   * @var \Drupal\content_importer\ImporterInterface
   */
  protected $importer;

  /**
   * @param \Drupal\content_importer\ImporterInterface $importer
   *   Importer class.
   */
  public function __construct($importer) {
    $this->importer = $importer;
  }

  /**
   * Import article content.
   *
   * @command content:importer:import:articles
   *
   * @aliases ciia
   */
  public function importArticles() {
    $this->importer->import();
  }

}
