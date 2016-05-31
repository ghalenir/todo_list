<?php

namespace Drupal\todo_list\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\todo_list\TodoListManager;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TodoListController.
 *
 * @package Drupal\todo_list\Controller
 */
class TodoListController extends ControllerBase {
 
  private $todolistManager;
  public function __construct() {
    $this->todolistManager = new TodoListManager();
  }
  
  /**
   * @return string
   */
  public function listTask($status, $page) {
    $page = ($page <=1 ) ? 1 : $page;
    $data = $this->todolistManager->getTaskList($page, $status);
    return new JsonResponse($data);
  }

  public function getTaskDetail($nid) {
    return new JsonResponse($this->todolistManager->getNodeDetail($nid));
  }
}
