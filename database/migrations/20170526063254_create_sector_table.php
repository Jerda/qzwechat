<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateSectorTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        //政府部门表
        $this->table('sector')
             ->addColumn(Column::string('name')->setDefault('')->setComment('部门名称'))
             ->addColumn(Column::smallInteger('parent_id')->setDefault(0)->setComment('上级部门ID'))
//             ->addColumn(Column::string('address')->setDefault('')->setComment('部门地址'))
             ->addColumn(Column::tinyInteger('level')->setDefault(0)->setComment('部门级别'))
             ->addColumn(Column::unsignedInteger('personnel_count')->setDefault(0)->setComment('部门人数'))
             ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
             ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
             ->create();

        //政府部门职员表
        $this->table('personnel')
//             ->addColumn(Column::string('sector_id')->setDefault('')->setComment('部门ID'))
             ->addColumn(Column::string('name')->setDefault('')->setComment('姓名'))
             ->addColumn(Column::string('tel')->setDefault('')->setComment('电话'))
             ->addColumn(Column::string('position')->setDefault('')->setComment('职位'))
             ->addColumn(Column::tinyInteger('level')->setDefault(0)->setComment('职位级别'))
             ->addColumn(Column::string('sector')->setDefault('')->setComment('所属部门'))
             ->addColumn(Column::string('address')->setDefault('')->setComment('联系地址'))
             ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
             ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
//             ->addForeignKey('sector_id', 'sector', 'id')
            ->create();

        //管理员表
        $this->table('admin')
             ->addColumn(Column::string('username')->setDefault('')->setComment('用户名'))
             ->addColumn(Column::string('password')->setDefault('')->setComment('密码'))
             ->addColumn(Column::string('email')->setDefault('')->setComment('邮箱'))
             ->addColumn(Column::tinyInteger('status')->setDefault(0)->setComment('状态'))
             ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
             ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
             ->create();

        //职员，部门中间表
        $this->table('sector_personnel')
             ->addColumn(Column::integer('sector_id')->setDefault(0)->setComment('部门ID'))
             ->addColumn(Column::integer('personnel_id')->setDefault(0)->setComment('职员ID'))
             ->create();

        //密码重置
        $this->table('admin_password_reset')
             ->addColumn(Column::string('email')->setDefault('')->setComment('邮箱'))
             ->addColumn(Column::string('token')->setDefault('')->setComment('验证值'))
             ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
             ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
             ->create();

        $this->table('user_password_reset')
            ->addColumn(Column::string('email')->setDefault('')->setComment('邮箱'))
            ->addColumn(Column::string('token')->setDefault('')->setComment('验证值'))
            ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
            ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
            ->create();

        //文章
        $this->table('article')
            ->addColumn(Column::string('title')->setDefault('')->setComment('标题'))
            ->addColumn(Column::string('img')->setDefault('')->setComment('图片'))
            ->addColumn(Column::text('content')->setComment('内容'))
            ->addColumn(Column::string('author')->setDefault('')->setComment('作者'))
            ->addColumn(Column::tinyInteger('status')->setDefault(0)->setComment('状态'))
            ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
            ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
            ->create();
        //论坛用户
        $this->table('user')
            ->addColumn(Column::string('username')->setDefault('')->setComment('用户名'))
            ->addColumn(Column::string('password')->setDefault('')->setComment('密码'))
            ->addColumn(Column::tinyInteger('status')->setDefault(0)->setComment('状态'))
            ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
            ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
            ->create();
        //话题
        $this->table('discuss')
            ->addColumn(Column::string('title')->setDefault('')->setComment('标题'))
            ->addColumn(Column::text('content')->setComment('内容'))
            ->addColumn(Column::integer('uid')->setDefault(0)->setComment('发布人ID'))
            ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
            ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
            ->create();
        //话题评论
        $this->table('review')
            ->addColumn(Column::integer('uid')->setDefault(0)->setComment('评论人ID'))
            ->addColumn(Column::integer('discuss_id')->setDefault(0)->setComment('话题ID'))
            ->addColumn(Column::text('content')->setComment('内容'))
            ->addColumn(Column::string('create_time')->setDefault('')->setComment('创建时间'))
            ->addColumn(Column::string('update_time')->setDefault('')->setComment('更新时间'))
            ->create();
    }
}
