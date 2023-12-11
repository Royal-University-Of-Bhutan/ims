<?php

namespace Accounts\Mapper;

use Accounts\Model\StudentFeeCategory;
use Accounts\Model\StudentFeeStructure;

interface FeeStructureMapperInterface {

    public function getLoginEmpDetailfrmUsername($username);

    public function listAll($tableName);

    public function findDetails($tableName, $id);

    public function save(StudentFeeStructure $moduleObject, $level);

    public function checkUniqueFeeStructure($tableName, $fields, $type);

    public function saveCategory(StudentFeeCategory $moduleObject, $level);

    public function getStudentFeeReportList($tableName,$params);

    public function getTotalReceivableAndPaidFeesCount($tableName, $params);
}
