<?php
	namespace app\index\model;
	use think\Model;

	class Search extends Model{
		protected $updateTime = false;

		//两表联查
		public function user(){
			$sql = $this->join('user','search.user_id = user.user_id');
			return $sql;
		}
	}
?>