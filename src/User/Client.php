<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\User;

use EasyDingTalk\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param string $userId
     *
     * @return array
     */
    public function get( $userId)
    {
        return $this->httpGet('user/get', ['userid' => $userId]);
    }

    /**
     * Create a new user.
     *
     * @param array $params
     *
     * @return array
     */
    public function create( $params)
    {
        return $this->httpPostJson('user/create', $params);
    }

    /**
     * Update an exist user.
     *
     * @param array $params
     *
     * @return array
     */
    public function update( $params)
    {
        return $this->httpPostJson('user/update', $params);
    }

    /**
     * @param array|string $userId
     *
     * @return array
     */
    public function delete($userId)
    {
        if (is_array($userId)) {
            return $this->httpPostJson('user/batchdelete', ['useridlist' => $userId]);
        }

        return $this->httpGet('user/delete', $userId);
    }

    /**
     * @param int   $departmentId
     * @param array $params
     *
     * @return array
     */
    public function simpleList( $departmentId,  $params = [])
    {
        return $this->httpGet('user/simplelist', [
            'department_id' => $departmentId,
        ] + $params);
    }

    /**
     * @param int   $departmentId
     * @param int   $size
     * @param int   $offset
     * @param array $params
     *
     * @return array
     */
    public function useList( $departmentId,  $size = 100,  $offset = 0,  $params = [])
    {
        return $this->httpGet('user/list', [
            'department_id' => $departmentId,
            'offset' => $offset,
            'size' => $size,
        ] + $params);
    }

    /**
     * @return array
     */
    public function admin()
    {
        return $this->httpGet('user/get_admin');
    }

    /**
     * UnionId to userId.
     *
     * @param string $unionId
     *
     * @return array
     */
    public function toUserId( $unionId)
    {
        return $this->httpGet('user/getUseridByUnionid', [
            'unionid' => $unionId,
        ]);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function count( $params)
    {
        return $this->httpGet('user/get_org_user_count', $params);
    }

    /**
     * @param string $code
     *
     * @return array
     */
    public function getUserInfo( $code)
    {
        return $this->httpGet('user/getuserinfo', ['code' => $code]);
    }
}
