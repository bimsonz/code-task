<?php

namespace Drupal\Tests\content_import\Unit;

use Drupal\content_importer\Service\ArticleImporter;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueInterface;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;

class ArticleImporterTest extends UnitTestCase {

  /**
   * @var \Drupal\content_importer\Service\ArticleImporter
   */
  protected $importer;

  public function setUp() {
    $queueProphet = $this->prophesize(QueueFactory::class);
    $queue = $queueProphet->reveal();

    $clientProphet = $this->prophesize(Client::class);
    $client = $clientProphet->reveal();

    $this->importer = new ArticleImporter($queue, $client);
  }

  /**
   * Test article importer service.
   */
  public function testArticleImporter() {
    $this->assertInstanceOf(ArticleImporter::class, $this->importer);
  }

  /**
   * Test article importer service import.
   */
  public function testArticleImporterImport() {

    $queueProphet = $this->prophesize(QueueInterface::class);
    $queueProphet->createItem(Argument::any())->will(function ($args) {
        return $args[0];
    });
    $queue = $queueProphet->reveal();

    $queueFactoryProphet = $this->prophesize(QueueFactory::class);
    $queueFactoryProphet->get(Argument::any())->willReturn($queue);
    $queueFactory = $queueFactoryProphet->reveal();

    $clientProphet = $this->prophesize(Client::class);

    $mockItems = ['1', '2', '3', '4'];
    $clientProphet->get(Argument::any())->willReturn(new Response(200, [], json_encode($mockItems)));

    $client = $clientProphet->reveal();

    $importer = new ArticleImporter($queueFactory, $client);

    $items = $importer->import();

    $this->assertEquals($mockItems, $items);
  }

}
