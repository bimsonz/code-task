<?php

namespace Drupal\content_display\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleController extends ControllerBase {

  /**
   * Entity Type Manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   Entity Type Manager.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Article list action.
   */
  public function list() {
    $articleNodes = $this->entityTypeManager
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'article',
        'status' => 1,
      ]);

    $articlesItems = [];
    foreach ($articleNodes as $nid => $node) {
      $articlesItems[] = [
        'title' => $node->getTitle(),
        'link' => $node->toUrl()->toString(),
      ];
    }

    return ['#theme' => 'article_item', '#articles' => $articlesItems];
  }

}
