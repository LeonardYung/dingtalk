<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\Department;

use EasyDingTalk\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get department list.
     *
     * @param int $id
     *
     * @return array
     */
    public function departmentList( $id = 0)
    {
        if ($id == 0) {
            return $this->httpGet('department/list');
        }

        return $this->httpGet('department/list', compact('id'));
    }

    /**
     * Get department detail.
     *
     * @param int $id
     *
     * @return array
     */
    public function get( $id)
    {
        return $this->httpGet('department/get', compact('id'));
    }

    /**
     * Create a department.
     *
     * @param array $data
     *
     * @return array
     */
    public function create( $data)
    {
        return $this->httpPostJson('department/create', $data);
    }

    /**
     * Update a department.
     *
     * @param array $data
     *
     * @return array
     */
    public function update( $data)
    {
        return $this->httpPostJson('department/update', $data);
    }

    /**
     * Delete a department.
     *
     * @param int $id
     *
     * @return array
     */
    public function delete( $id)
    {
        return $this->httpGet('department/delete', compact('id'));
    }

    /**
     * Get department parents by department id.
     *
     * @param int $id
     *
     * @return array
     */
    public function parent( $id)
    {
        return $this->httpGet('department/list_parent_depts_by_dept', compact('id'));
    }

    /**
     * Get department parents by user id.
     *
     * @param string $userId
     *
     * @return array
     */
    public function userParent( $userId)
    {
        return $this->httpGet('department/list_parent_depts', compact('userId'));
    }
}
