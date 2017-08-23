<?php

namespace Drupal\custom_pdf_download\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use \Drupal\node\Entity\Node;
/**
 * Provides a 'PdfDownload' action.
 *
 * @Action(
 *  id = "pdf_download",
 *  label = @Translation("PDF download"),
 *  type = "node",
 * )
 */
class PdfDownload extends ActionBase
{
    /**
     * {@inheritdoc}
     */
    public function execute($object = NULL)
    {
        // Insert code here.
    }
    /**
     * {@inheritdoc}
     */
    public function executeMultiple(array $entities)
    {
        global $base_url;
        foreach ($entities as $entity) {
            $get_path         = $entity->get('field_application_path')->getValue();
            $application_path = $get_path[0]['value'];
            $filename         = explode('/', $application_path);
            $filename         = end($filename);
        }
        $base_path  = 'sites/default/files/';
        $content    = file_get_contents($base_url . '/' . $base_path . 'applications/' . $filename);
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $content;
        die;
    }
    /**
     * {@inheritdoc}
     */
    public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE)
    {
        $access = $object->status->access('edit', $account, TRUE)->andIf($object->access('update', $account, TRUE));
        return $return_as_object ? $access : $access->isAllowed();
    }
}

