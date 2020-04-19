<?php

namespace Drupal\content_importer\Service;

use Drupal\content_importer\ImporterInterface;
use Drupal\Core\Queue\QueueFactory;
use GuzzleHttp\ClientInterface;

class ArticleImporter implements ImporterInterface {

  /**
   * @var \Drupal\Core\Queue\QueueInterface
   */
  protected $queue;

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * ArticleImporter constructor.
   *
   * @param \Drupal\Core\Queue\QueueFactory $queueFactory
   *   Default queue factory.
   *
   * @param \GuzzleHttp\ClientInterface $client
   *   Http client.
   */
  public function __construct(QueueFactory $queueFactory, ClientInterface $client) {
    $this->queue = $queueFactory->get('article_import_queue_worker');
    $this->client = $client;
  }

  /**
   * Add data into the queue.
   *
   * @return bool|array
   *   False if failure, array of items if successful.
   */
  public function import() {
    $response = $this->makeRequest();

    if ($response->getStatusCode() != 200) {
      return FALSE;
    }

    $responseBody = json_decode($response->getBody());

    if (is_array($responseBody) != TRUE) {
      return FALSE;
    }

    $items = [];
    foreach ($responseBody as $item) {
      $items[] = $this->queue->createItem($item);
    }

    return $items;
  }

  /**
   * Get request data.
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  protected function makeRequest() {
    $response = $this->client->get('https://jsonplaceholder.typicode.com/posts');

    return $response;
  }

}
