<?php

namespace Drupal\events_recent_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides five recent events block.
 *
 * @Block(
 *   id = "events_recent_block",
 *   admin_label = @Translation("Five recent events"),
 * )
 */
class EventsRecentBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $nids = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'event')
      ->sort('created', 'DESC')
      ->sort('nid', 'DESC')
      ->range(0, 5)
      ->execute();

    $events = \Drupal\node\Entity\Node::loadMultiple($nids);
    $output = '';
    if ($events) {
      foreach ($events as $event) {
        $output .= '<div>' . $event->link() . '</div>';
      }
    }

    return [
      '#markup' => $output,
      '#cache' => [
        'tags' => ['node_type:event'],
      ],
    ];
  }

}
