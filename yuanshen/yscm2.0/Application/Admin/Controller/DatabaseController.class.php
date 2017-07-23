<?php
/**
* 数据库操作
*/
namespace Admin\Controller;
use Think\Controller;
ini_set('max_execution_time', 0);
class DatabaseController extends BaseController{
	public $backup_path; //备份文件夹相对路
	public function _initialize(){
		parent::_initialize();
		$this->backup_path = 'Data/Backup/';
	}

	// 数据库备份展示，列出所有数据表信息
	public function index() {
		//query是查功能，execute是增删改功能
		$dbtables = M()->query('SHOW TABLE STATUS');
		$total = 0;
		foreach ($dbtables as $k => $v) {
			$dbtables[$k]['size'] = get_byte($v['data_length'] + $v['index_length']);
			$total+=$v['data_length'] + $v['index_length'];
		}
		$total=get_byte($total); //获取多少张表
		$tableNum=count($dbtables); //获取数据库大小
		$this->assign('list_table',$dbtables);
		$this->assign('total',$total);
		$this->assign('tableNum',$tableNum);
		\Cookie::set('_currentUrl_', __SELF__);
		$this->display();
	}

	//优化表
	public function optimize() {
		$id = I('id',0 , 'intval');
		$batchFlag = I('get.batchFlag', 0, 'intval');
		//批量删除
		if ($batchFlag) {
			$table = I('key', array());
		}else {
			$table[] = I('tablename' , '');
		}
		if (empty($table)) {
			$this->error('请选择要优化的表');
		}
		$strTable = implode(', ', $table);
		if (!M()->query("OPTIMIZE TABLE {$strTable} ")) {
			$strTable = '';
		}
		$this->success("优化表成功" . $strTable, U('Database/index'));
	}

	//修复表
	public function repair() {
		$id = I('id',0 , 'intval');
		$batchFlag = I('get.batchFlag', 0, 'intval');
		//批量删除
		if ($batchFlag) {
			$table = I('key', array());
		}else {
			$table[] = I('tablename' , '');
		}
		if (empty($table)) {
			$this->error('请选择修复的表');
		}
		$strTable = implode(', ', $table);
		if (!M()->query("REPAIR TABLE {$strTable} ")) {
			$strTable = '';
		}
		$this->success("修复表成功" . $strTable, U('Database/index'));

	}

	//处理数据库备份
	public function insert(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要备份的数据库表！');
		}	
		$filesize = intval($_POST['filesize']);
		if ($filesize < 512) {
			$this->error('出错了,请为分卷大小设置一个大于512的整数值！');
		}
		$file = $this->backup_path;
		$random = mt_rand(1000, 9999);
		$sql = ''; 
		$p = 1;
		foreach($_POST['ids'] as $table){
			$rs = M(str_replace(C('DB_PREFIX'),'',$table));
			$array = $rs->select();
			$sql.= "TRUNCATE TABLE `$table`;\n";
			foreach($array as $value){
				$sql.= $this->insertsql($table, $value);
				if (strlen($sql) >= $filesize*1000) {
					$filename = $file.date('Ymd').'_'.$random.'_'.$p.'.sql';
					write_file($filename,$sql);
					$p++;
					$sql='';
				}
			}
		}
		if(!empty($sql)){
			$filename = $file.date('Ymd').'_'.$random.'_'.$p.'.sql';
			write_file($filename,$sql);
		}
		$this->assign("jumpUrl",U('/admin/database/restore'));
		$this->success('数据库分卷备份已完成,共分成'.$p.'个sql文件存放！');
	}

	//生成SQL备份语句
	public function insertsql($table, $row){
		$sql = "INSERT INTO `{$table}` VALUES ("; 
		$values = array(); 
		foreach ($row as $value) { 
			$values[] = "'" . mysql_escape_string($value) . "'"; 
		}
		$sql .= implode(', ', $values) . ");\n"; 
		return $sql;
	}

	//展示还原
	public function restore(){
		$filepath = $this->backup_path.'*.sql';
		$filearr = glob($filepath);
		if (!empty($filearr)) {
			foreach($filearr as $k=>$sqlfile){
				preg_match("/([0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num);
				$restore[$k]['filename'] = basename($sqlfile);
				$restore[$k]['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
				$restore[$k]['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
				$restore[$k]['pre'] = $num[1];
				$restore[$k]['number'] = $num[2];
				$restore[$k]['path'] = $this->backup_path;
			}
			\Cookie::set('_currentUrl_', __SELF__);
			$this->assign('list_restore',$restore);
			$this->display();
		}else{
			$this->assign("jumpUrl",U('Database/index'));
			$this->error('没有检测到备份文件,请先备份或上传备份文件到'.$this->backup_path);
		}
	}

	//导入还原
	public function back(){
		$rs = M();
		$pre = $_GET['id'];
		$fileid = $_GET['fileid'] ? intval($_GET['fileid']) : 1;
		$filename = $pre.$fileid.'.sql';
		$filepath = $this->backup_path.$filename;		
		if(file_exists($filepath)){
			$sql = read_file($filepath);
			$sql = str_replace(array("\r\n","�"), "\n", $sql); 
			foreach(explode(";\n", trim($sql)) as $query) {
				$rs->execute(trim($query));
			}
			$this->assign("jumpUrl",U('Database/back',array('id'=>$pre,'fileid'=>($fileid+1))));
			$this->success('第'.$fileid.'个备份文件恢复成功,准备恢复下一个,请稍等！');
		}else{
			$this->assign("jumpUrl",U('Database/index'));
			$this->success('数据库恢复成功！');
		}
		
	}

	//下载还原
	public function down(){
		$filepath = $this->backup_path.$_GET['id'];
		if (file_exists($filepath)) {
			$filename = $filename ? $filename : basename($filepath);
			$filetype = trim(substr(strrchr($filename, '.'), 1));
			$filesize = filesize($filepath);
			header('Cache-control: max-age=31536000');
			header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
			header('Content-Encoding: none');
			header('Content-Length: '.$filesize);
			header('Content-Disposition: attachment; filename='.$filename);
			header('Content-Type: '.$filetype);
			readfile($filepath);
			exit;
		}else{
			$this->error('出错了,没有找到分卷文件！');
		}
	}

	//删除分卷文件
	public function del(){
		$filename = trim($_GET['id']);
		if($filename){
			@unlink($this->backup_path.$filename);
			$this->success($filename.'已经删除！');
		}else{
			$this->error('请选择要删除的分卷文件！');
		}
		
	}

	//删除所有分卷文件
	public function delall(){
		if(!empty($_POST['key'])){
			foreach($_POST['key'] as $value){
				@unlink($this->backup_path.$value);
			}
			$this->success('批量删除分卷文件成功！');
		}else{
			$this->error('请选择要删除的分卷文件！');
		}	
	}

	//展示高级SQL
	public function sql(){
		\Cookie::set('_currentUrl_', __SELF__);
		$this->display();
	}

	//执行SQL语句
	public function upsql(){
		$sql = trim($_POST['sql']);
		if (empty($sql)) {
			$this->error('SQL语句不能为空！');
		}else{
			$rs = M();
			$array_sql = explode(';', $sql);
			foreach($array_sql as $key=>$value){
				//show_bug($value);
				$rs->execute(trim(stripslashes($value)));				
			}
			$this->assign("waitSecond",10);
			$this->success('SQL语句成功运行!');
		}
	}

	//展示批量替换
	public function replace(){
		$rs = M();
		$list = $rs->query('SHOW TABLES FROM '.C('DB_NAME'));
		$tablearr = array();
		foreach ($list as $key => $val) {
			$tablearr[$key] = current($val);
		}
		\Cookie::set('_currentUrl_', __SELF__);
		$this->assign('list_table',$tablearr);	
		$this->display();
	}	

	//Ajax展示字段信息
	public function ajaxfields(){
		$id = str_replace(C('DB_PREFIX'),'',$_GET['id']);
		if (!empty($id)) {
			$rs = D("Admin/".$id);
			$array = $rs->getDbFields();
			echo "<div style='border:1px solid #ccc;width:500px;background-color:#FEFFF0;padding:6px;line-height:24px;'>";
			echo "表(".C('DB_PREFIX').$id.")含有的字段：<br>";
			foreach($array as $key=>$val){
				if(!is_int($key)){
					break;
				}
				if (ereg("cfile|username|userpwd|user|pwd",$val)){
					continue;
				}
				echo "<a href=\"javascript:rpfield('".$val."')\">".$val."</a>\r\n";
			}
			echo "</div>";
		}else{
			echo 'no fields';
		}
	}

	//执行批量替换
	public function upreplace(){
		if(empty($_POST['rpfield'])){
			$this->error("请手工指定要替换的字段！");
		}
		if(empty($_POST['rpstring'])){
			$this->error("请指定要被替换内容！");
		}
		$exptable = str_replace(C('DB_PREFIX'),'',$_POST['exptable']);
		$rs = D("Admin/".$exptable);
		$exptable = C('DB_PREFIX').$exptable;//表
		$rpfield = trim($_POST['rpfield']);//字段
		$rpstring = $_POST['rpstring'];//被替换的
		$tostring = $_POST['tostring'];//替换内容
		$condition = trim(stripslashes($_POST['condition']));//条件
		$condition = empty($condition) ? '' : " where $condition ";
		$rs->execute(" update $exptable set $rpfield = Replace($rpfield,'$rpstring','$tostring') $condition ");
		$lastsql = $rs->getLastSql();
		$this->success('批量替换完成!SQL执行语句!<br>'.$lastsql);
	}
}
?>