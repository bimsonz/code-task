<?php

namespace Drupal\content_importer\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;

/**
 * Processes article content items.
 *
 * @QueueWorker(
 *   id = "article_import_queue_worker",
 *   title = @Translation("Import Article Content"),
 *   cron = {"time" = 10}
 * )
 */
class ArticleImportQueueWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    if (empty($item->title) != TRUE) {
      $node = Node::create(['type' => 'article']);

      $node->set('title', $item->title);

      $body = ['value' => html_entity_decode($item->body)];
      $node->set('body', $body);

      $node->save();
    }
  }

}
