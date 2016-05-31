<?php

namespace Drupal\todo_list\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the todo_list module.
 */
class TodoListControllerTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "todo_list TodoListController's controller functionality",
      'description' => 'Test Unit for module todo_list and controller TodoListController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests todo_list functionality.
   */
  public function testTodoListController() {
    // Check that the basic functions of module todo_list.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
