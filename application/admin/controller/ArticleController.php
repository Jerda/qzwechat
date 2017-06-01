<?php

namespace app\admin\controller;

use app\common\model\Article;
use think\Controller;
use think\Exception;
use think\Request;

class ArticleController extends BaseController
{
    protected $name = 'article';

    public function index()
    {
        $articles = Article::paginate();
        return $this->fetch('', compact('articles'));
    }

    public function add(Request $request)
    {
        $this->init();
        $article = '';

        if (!$request->isPost()) {

            if ($this->type == 'edit') {
                $article = Article::get($this->data['id']);
            }
            return $this->fetch($this->type, compact('article'));
        }

        $res = $this->_validate();
        if ($this->_validate() !== true) {
            return back(0, '数据有误'.$res);
        }

        //todo-me
        try {
            if ($this->type == 'add') {
                Article::create($this->data);
            } else {
                Article::update($this->data, ['id' => $this->data['id']]);
            }
        } catch (Exception $e) {
            return back(0, $this->type_name."失败".$e->getMessage());
        }

        return back(1, $this->type_name."成功");
    }
}
