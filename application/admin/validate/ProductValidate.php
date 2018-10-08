<?php
namespace app\admin\validate;
use  think\validate;
class ProductValidate extends Validate{
	protected $product=[
		'title'=>'require|max:25'
	];
	if(!$validate->check($data)){
    dump($validate->getError());
}
}
?>