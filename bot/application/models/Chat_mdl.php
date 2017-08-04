<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class Chat_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function chat_send($tl_function, $tl_vars, $wait = 0, $path = '')
    {
        //创建任务
        $tl_netbot = $this->netbotguid;
        $app = $this->db->query('SELECT * FROM app where app_fun=\'' . $tl_function . '\'  limit 1')->row_array();
        $task_vars = json_encode($tl_vars, JSON_UNESCAPED_UNICODE);
        $send_type = 'chat';
        if ($_SESSION['netbottype'] == 'offline') {
            $send_type = 'cron';
            $wait = 0;
        }
        $tl = array();
        $tl['tl_netbot'] = $tl_netbot;
        $tl['tl_taskid'] = 0;
        $tl['tl_addtime'] = date('Y-m-d H:i:s');
        $tl['tl_stauts'] = 0;
        $tl['tl_isback'] = 1;
        $tl['tl_backfun'] = $app['app_backfun'];
        $tl['tl_app'] = $app['app_type'];
        $tl['tl_function'] = $app['app_fun'];
        $tl['tl_plug_url'] = $app['app_plugurl'];
        $tl['tl_plug_md5'] = $app['app_plugmd5'];
        $tl['tl_vars'] = $task_vars;
        $tl['tl_type'] = $send_type;
        $tl['username'] = $this->user;
        $this->db->insert('tasklist_' . $send_type, $tl);
        $tl['tl_id'] = $this->db->insert_id();
        //$td=array();
        //$td['tl_vars']=$task_vars;
        //$td['id']=$tl['tl_id'];
        //$this->db->insert("taskdata_".$send_type, $td);
        //$this->load->model('netbot_mdl');
        //$mc_up=array();
        //$mc_up['nb_task_new']=1;
        //$this->netbot_mdl->mc_update($tl_netbot,$mc_up);
        if ($send_type == 'chat') {
            $this->cache->save('chat' . $tl_netbot, 1, 100);
        } else {
            $this->cache->delete($tl_netbot);
        }
        if (!$wait) {
            return $tl['tl_id'];
        }
        $path_hash = md5($tl['tl_id']);
        $file_path = $this->config->item('tasktmp_path') . '/chat/' . $path_hash . '.txt';
        if ($wait == 2) {
            $task_data = $this->wait_task_result2($path);
        } else {
            $task_data = $this->wait_task_result($file_path);
        }
        if ($task_data) {
            return json_decode($task_data, true);
        } else {
            return false;
        }
    }
    public function chat_send_screen($tl_function, $tl_vars)
    {
        //创建任务
        $tl_netbot = $this->netbotguid;
        $app = $this->db->query('SELECT * FROM app where app_fun=\'' . $tl_function . '\'  limit 1')->row_array();
        $task_vars = json_encode($tl_vars, JSON_UNESCAPED_UNICODE);
        $send_type = 'chat';
        $tl = array();
        $tl['tl_netbot'] = $tl_netbot;
        $tl['tl_taskid'] = 0;
        $tl['tl_addtime'] = date('Y-m-d H:i:s');
        $tl['tl_stauts'] = 0;
        $tl['tl_isback'] = 1;
        $tl['tl_backfun'] = $app['app_backfun'];
        $tl['tl_app'] = $app['app_type'];
        $tl['tl_function'] = $app['app_fun'];
        $tl['tl_plug_url'] = $app['app_plugurl'];
        $tl['tl_plug_md5'] = $app['app_plugmd5'];
        $tl['tl_vars'] = $task_vars;
        $tl['tl_type'] = $send_type;
        $tl['username'] = $this->user;
        $this->db->insert('tasklist_' . $send_type, $tl);
        $tid = $this->db->insert_id();
        $this->cache->save('chat' . $tl_netbot, 1, 100);
        $path_hash = $tl_netbot . '/chat_' . $tid;
        $file_path = $this->config->item('upload_path') . '/' . $path_hash . '.tmp';
        // $file_path=$this->config->item('tasktmp_path').'/chat/screen2.jpg';
        $task_data = $this->wait_task_result($file_path);
        if ($task_data) {
            return $task_data;
        } else {
            return false;
        }
    }
    private function wait_task_result2($file)
    {
        $task_data = '';
        if (file_exists($file)) {
            $file_old_time = filemtime($file);
        } else {
            $file_old_time = 0;
        }
        $i = 0;
        while ($i < 60) {
            usleep(200000);
            // sleep 10ms to unload the CPU
            if ($file_old_time == 0) {
                if (file_exists($file)) {
                    $task_data = read_file($file);
                    return $task_data;
                }
            } else {
                if (filemtime($file) > $file_old_time) {
                    $task_data = read_file($file);
                    return $task_data;
                }
            }
            $i++;
        }
        return false;
    }
    public function wait_task_result($file)
    {
        $task_data = '';
        $i = 0;
        //echo $file;
        while ($i < 60) {
            usleep(200000);
            // sleep 10ms to unload the CPU
            if (file_exists($file)) {
                $task_data = read_file($file);
                unlink($file);
                return $task_data;
            }
            $i++;
        }
        return false;
    }
    public function get_task_chat($tl_id)
    {
        $task_data = $this->db->query('SELECT * FROM tasklist_chat where tl_id=' . $tl_id . '  limit 1')->row_array();
        return $task_data;
    }
}