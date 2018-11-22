<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\Process;

use EasyDingTalk\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author baijunyao <baijunyao@baijunyao.com>
 */
class Client extends BaseClient
{
    /**
     * 获取审批实例列表.
     *
     * @param string $processCode  流程模板唯一标识 可在oa后台编辑审批表单部分查询
     * @param int    $startTime    时间戳 可以传秒或者毫秒
     * @param int    $endTime      时间戳 可以传秒或者毫秒
     * @param array  $useridList   数组形式的用户列表
     * @param int    $cursor
     * @param int    $size
     *
     * @return array|\GuzzleHttp\Psr7\Response
     */
    public function processInstanceList( $processCode, $startTime, $endTime = 0, $useridList = [], $cursor = 0, $size = 10)
    {
        // php 不方便生成毫秒数 如果传入秒 则自动补 3个0 成为毫秒
        $startTime = strlen($startTime) === 10 ? $startTime.'000' : $startTime;
        $endTime = strlen($endTime) === 10 ? $endTime.'000' : $endTime;
        // userid_list 需要是以 逗号分割的字符串
        $useridList = implode(',', $useridList);
        $params = [
            'process_code' => $processCode,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'userid_list' => $useridList,
            'size' => $size,
        ];
        // 过滤掉 end_time 、 useridList 、 size 这三项的空值
        $params = array_filter($params);
        $params['cursor'] = $cursor;

        return $this->httpGetMethod('dingtalk.smartwork.bpms.processinstance.list', $params);
    }

    /**
     * 创建审批
     * @param $processCode
     * @param $originatorUserId
     * @param $deptId
     * @param $approvers
     * @param $form
     * @param string $cc
     * @param int $agentId
     * @param string $ccPosition
     * @return array|\GuzzleHttp\Psr7\Response
     */
    public function createProcessInstance(
        $processCode,
        $originatorUserId,
        $deptId,
        $approvers,
        $form,
        $cc=[],
        $agentId=0,
        $ccPosition = 'FINISH'
    )
    {
        $params = [
            //必须参数
            'process_code' => $processCode,//审批流的唯一码
            'originator_user_id'=> $originatorUserId,// 审批实例发起人的userid
            'dept_id'=> $deptId,//发起人所在的部门，如果发起人属于根部门，传-1
            'approvers'=> empty($approvers)?'':implode(',', $approvers),//审批人userid列表，最大列表长度：20。多个审批人用逗号分隔，按传入的顺序依次审批
            'form_component_values'=> $form,//审批流表单参数，最大列表长度：20

            //可选参数
            'agent_id'=> $agentId, //企业应用标识(ISV调用必须设置)
            'cc_list'=> empty($cc)?'':implode(',', $cc),//抄送人userid列表，最大列表长度：20。多个抄送人用逗号分隔
            'cc_position'=> $ccPosition,//抄送时间，分为（START, FINISH, START_FINISH）
        ];

        $params = array_filter($params);

        return $this->httpPostJson('topapi/processinstance/create',$params);

    }

    /**
     * 获取审批的id列表
     * @param $processCode
     * @param $startTime
     * @param int $endTime
     * @param array $useridList
     * @param int $cursor
     * @param int $size
     * @return array|\GuzzleHttp\Psr7\Response
     */
    public function processInstanceListIds( $processCode, $startTime, $endTime = 0, $useridList = [], $cursor = 0, $size = 10)
    {
        // php 不方便生成毫秒数 如果传入秒 则自动补 3个0 成为毫秒
        $startTime = strlen($startTime) === 10 ? $startTime.'000' : $startTime;
        $endTime = strlen($endTime) === 10 ? $endTime.'000' : $endTime;
        // userid_list 需要是以 逗号分割的字符串
        $useridList = implode(',', $useridList);
        $params = [
            'process_code' => $processCode,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'userid_list' => $useridList,
            'size' => $size,
        ];
        // 过滤掉 end_time 、 useridList 、 size 这三项的空值
        $params = array_filter($params);
        $params['cursor'] = $cursor;

        return $this->httpPostJson('topapi/processinstance/listids',$params);
    }

    /**
     * 审批详情
     * @param $process_instance_id
     * @return array|\GuzzleHttp\Psr7\Response
     */
    public function singleProcessInstance($process_instance_id)
    {
        $data = [
            'process_instance_id'=>$process_instance_id
        ];
        return $this->httpPostJson('topapi/processinstance/get',$data);

    }


    //public function

    public function processLIstByUserId($userid='',$offset = 0,$size = 100)
    {
        //必须参数
        $data = [
            'userid'=>$userid,
            'offset'=>$offset,
            'size'=>$size,
        ];
        return $this->httpPostJson('topapi/process/listbyuserid',$data);
    }

}
