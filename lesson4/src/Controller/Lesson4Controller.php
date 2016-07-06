<?php
/**
 * @file
 * Contains \Drupal\lesson4\Controller\Lesson4Controller.
 */

namespace Drupal\lesson4\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Controller routines for lesson4 module routes.
 */
class Lesson4Controller extends ControllerBase {

    /**
     * Shows page with table as example for Render API.
     *
     * @return array
     */
    public function showRenderApiExamplePage() {
//        $row[] = array(
//            'data' => $operations_elements,
//        );
        $weather = $this->config('lesson4.settings')->get('lesson4.weather');
        var_dump($weather);
        $rows[] = array(
            'data' => array('a','s',$weather),

        );
        $headers = array();
        $headers[] = t('File information');
        $headers[] = t('Weight');
        $headers[] = t('Operations');

        $table_id = 'lesson4';



        return array(
            '#type' => 'table',
'#header' => $headers,
'#rows' => $rows,
'#attributes' => array(
            'id' => $table_id,
        ));


    }
}