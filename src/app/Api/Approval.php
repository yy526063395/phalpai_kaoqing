<?php
namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;
use App\Model\Approval\Form as ApprovalForm;
use App\Model\Grade\ClassTeam;

/**
 * 审核模块接口服务
 */
class Approval extends Api {
    public function getRules() {
        return array(
            'addApprovalItemAction' => array(
                'name' => array('name' => 'name', 'require' => true, 'desc' => '姓名'),
                'class_id' => array('name' => 'class_id', 'require' => true, 'desc' => '班级ID'),
                'start_time' => array('name' => 'start_time', 'require' => true, 'desc' => '开始时间'),
                'end_time' => array('name' => 'end_time', 'require' => true, 'desc' => '结束时间'),
                'type' => array('name' => 'type', 'require' => true, 'desc' => '审核类型'),
                'remark' => array('name' => 'remark', 'require' => true, 'desc' => '具体事项'),
            ),
        );
    }
    
    /**
     * [addApprovalItemAction 添加审核单]
     * @Author   czt
     * @DateTime 2019-04-02
     */
    public function addApprovalItemAction()
    {
        $data = [
            'id'         => null,
            'name'       => $this->name,
            'class_id'   => $this->class_id,
            'start_time' => strtotime($this->start_time),
            'end_time'   => strtotime($this->end_time),
            'type'       => $this->type,
            'remark'     => $this->remark,
        ];
        $approval = new ApprovalForm;
        $id = $approval->insert($data);
        if (!$id) {
            throw new BadRequestException('操作失败');
        }
    }

    /**
     * [getAllClassAction 获取所有班级]
     * @Author   czt
     * @DateTime 2019-04-02
     * @return   [type]     [description]
     */
    public function getAllClassAction()
    {
        $classTeam = new ClassTeam;
        $results   = $classTeam->getAllDatas();
        return $results;
    }
}
