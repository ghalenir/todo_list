<?php
namespace Drupal\todo_list;
use \Drupal\node\Entity\Node;
use Drupal\Core\Url;
/**
 * Class TodoListManager.
 *
 * @package Drupal\todo_list
 */
class TodoListManager {
  const TASK_LIMIT = 10;

  /**
   * Constructor.
   */
  public function __construct() {
    
  }
  
  private function getImageDetails($image_target_id) {
    global $base_url;
    $query = db_select('file_managed','fm')
      ->fields('fm', array('fid', 'filename', 'uri', 'filemime'))
      ->condition('fm.fid', $image_target_id, '=');
    $result = $query->execute()->fetchAll();
    $result[0]->url = str_replace('public://'  , $base_url.'/sites/' . $_SERVER['HTTP_HOST'].'/files/', $result[0]->uri);
    return $result;
  }
  
  public function getNodeDetail($nid) {
   $node = Node::load($nid);
   $data = array(
     'nid' => $node->id(),
     'title' => $node->getTitle(),
     'body' => $node->get('body')->value,
     'image' => $this->getImageDetails($node->get('field_image')->target_id),
   );
   return $data;
  }
  
  public function getTaskList($page,$status) {
    global $base_url;
  
    if ($status == "all"){
      $filter = array('completed', 'pending');
      $operator = "IN";
    } else {
      $filter = ($status == "completed") ? "completed" : "pending";
      $operator = "=";
    }
    $data_array = array();
    $page = ($page <= 1) ? 0 : $page - 1; 
    $query = db_select('node_field_data', 'nd');
    $query->innerJoin('node__field_status','s', "s.entity_id= nd.nid");
    $query->fields('s', array('field_status_value'));
    $query->fields('nd', array('nid','title'))
      ->condition('nd.type','task', '=')
      ->condition('s.field_status_value', $filter, $operator)
      ->condition('nd.status',1)
      ->range($page * self::TASK_LIMIT, self::TASK_LIMIT);
    $result = $query->execute()->fetchAll();
    
    foreach ($result as $data) {
      $data_array[] = array(
        'nid' => $data->nid,
        'title' =>$data->title,
        'status' => $data->field_status_value,
      );
    }
    $json_data['data'] = $data_array;
    $json_data['pager'] = array(
      'next_page' => ($page < 1) ? 1 : $page -  1,
      'previous_page' => ($page > 100) ? 100 : $page + 2,
    );
    return $json_data;
  }
}
