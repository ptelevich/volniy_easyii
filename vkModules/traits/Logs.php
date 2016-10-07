<?php
namespace fedoskin\vkModules\traits;

trait Logs
{
    private $_logs = [];

    private function _setLog($data)
    {
        if (isset($data['mess'])) {
            $this->_logs[] = $data['mess'];
        }
    }
}