<?php
namespace App\Model\Grade;

use PhalApi\Model\NotORMModel as Model;
use App\Model\Grade;
/**
 * 年级表
 */
class ClassTeam extends Model {
    /**
     * [getAllParentMenu 获取所有年级]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllDatas()
    {

        $results = [];
        $grade = new Grade;
        $gradeDatas = $grade->getAllDatas();
        foreach ($gradeDatas as $gradeData) {
            $classes = $this->getORM()->where(['status' => 1, 'grade_id' => $gradeData['id']])->fetchAll();
            foreach ($classes as $key => $class) {
                $class['all_name'] = $gradeData['name'] . $class['name'];
                $classes[$key] = $class;
            }

            $results = array_merge($results, $classes);
        }
        return $results;
    }

}