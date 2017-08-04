<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class Netbot extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        //error_reporting(0);
        $this->load->model('netbot_mdl');
        $this->load->helper('netbot');
    }
    public function index()
    {
        $this->load->model('group_mdl');
        $group_main = $this->group_mdl->getlist('main');
        $this->config->load('area', TRUE);
        $netbot_area = $this->config->item('netbot_area', 'area');
        $page = array();
        $page['menu1'] = 'main';
        $page['menu2'] = 'netbot';
        $page['title'] = '主机管理';
        $page['nav1'] = '控制中心';
        $page['nav2'] = '主机管理';
        $view_data = array();
        $view_data['group_main'] = $group_main;
        $view_data['netbot_area'] = $netbot_area;
        $view_data['page'] = $page;
        $this->load->view('admin/netbot', $view_data);
    }
    public function getlist()
    {
        $post = $this->input->post();
        $customActionType = '';
        $netbots = array();
        $mcnt = 0;
        $filter = '';
        $sql = '';
        $sql2 = '';
        
        //是否是admin
        if ($this->user_role != 'administrator') {
            $member = $this->member_mdl->info_view($this->user);
            $task_group = json_decode($member['grouplist'], true);
            $main = array();
            $expand = array();
            foreach ($task_group as $tg) {
                $ng_type = $this->db->query('SELECT ng_type FROM groups where ng_id=' . $tg . '  limit 1')->row()->ng_type;
                if ($ng_type == 'main') {
                    $main[] = $tg;
                } else {
                    $expand[] = $tg;
                }
            }
            if (empty($main) && empty($expand)) {
                goto backdata;
            } elseif (!empty($main) && empty($expand)) {
                $sql = 'SELECT * FROM netbot';
                $sql2 = 'SELECT count(*) as mcnt FROM netbot';
                $filter = ' where  nb_group in (' . implode(',', $main) . ') ';
            } elseif (empty($main) && !empty($expand)) {
                $sql = 'select * from (select distinct nge_netbot_id from netbot_group_expand where nge_group_id in (' . implode(',', $expand) . ') ) as a LEFT JOIN  netbot  ON a.nge_netbot_id =netbot.nb_guid	';
                $sql2 = 'select count(*) as mcnt from (select distinct nge_netbot_id from netbot_group_expand where nge_group_id in (' . implode(',', $expand) . ') ) as a LEFT JOIN  netbot  ON a.nge_netbot_id =netbot.nb_guid	';
            } else {
                $sql = 'select * from ((select nb_guid as u from netbot where nb_group in (' . implode(',', $main) . ')) UNION (select nge_netbot_id as u from netbot_group_expand where nge_group_id in (' . implode(',', $expand) . '))) as a LEFT JOIN  netbot  ON a.u =netbot.nb_guid';
                $sql2 = 'select count(*) as mcnt from ((select nb_guid as u from netbot where nb_group in (' . implode(',', $main) . ')) UNION (select nge_netbot_id as u from netbot_group_expand where nge_group_id in (' . implode(',', $expand) . '))) as a LEFT JOIN  netbot  ON a.u =netbot.nb_guid';
            }
        } else {
            $sql = 'SELECT * FROM netbot';
            $sql2 = 'SELECT count(*) as mcnt FROM netbot';
            if (isset($post['customActionType'])) {
                $customActionType = $post['customActionType'];
                if ($customActionType == 'group_action') {
                    $customActionName = $post['customActionName'];
                    $customActionVal = $post['customActionVal'];
                    $id = $post['id'];
                    switch ($customActionName) {
                        case 'main':
                            //移动主分组
                            foreach ($id as $val) {
                                $sqlmain = 'update  netbot set nb_group=' . $customActionVal . '  where nb_id=' . $val;
                                $this->db->query($sqlmain);
                            }
                            break;
                        case 'expand':
                            $this->load->model('groupexpand_mdl');
                            foreach ($id as $val) {
                                $sqlexpand = 'select nb_guid from netbot where nb_id=' . $val;
                                $guid = $this->db->query($sqlexpand)->row()->nb_guid;
                                if (!$this->groupexpand_mdl->check($guid, $customActionVal)) {
                                    $ge = array();
                                    $ge['nge_netbot_id'] = $guid;
                                    $ge['nge_group_id'] = $customActionVal;
                                    $this->groupexpand_mdl->add($ge);
                                }
                            }
                            break;
                        default:
                    }
                }
            }
        }
        //获得分组
        $this->load->model('group_mdl');
        $group_main = $this->group_mdl->getlist('main');
        $groupname = array();
        //遍历分组
        foreach ($group_main as $gvalue) {
            $groupname[$gvalue['ng_id']] = $gvalue['ng_name'];
        }
        
     
        $action = '';
        if (isset($post['action'])) {
            $action = $post['action'];
        }
        if ($action == 'filter') {
            if (!empty($post['nb_guid'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_guid=\'' . $post['nb_guid'] . '\' ';
            }
            if (!empty($post['nb_name'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_name=\'' . $post['nb_name'] . '\' ';
            }
            if (!empty($post['nb_cname'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_cname=\'' . $post['nb_cname'] . '\' ';
            }
            if (!empty($post['nb_vid'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_vid=\'' . $post['nb_vid'] . '\' ';
            }
            if (!empty($post['nb_group'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_group=\'' . $post['nb_group'] . '\' ';
            }
            if ($post['nb_stauts'] != '') {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_stauts=\'' . $post['nb_stauts'] . '\' ';
            }
            if (!empty($post['nb_date_from'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_lasttime>\'' . $post['nb_date_from'] . '\' ';
            }
            if (!empty($post['nb_date_to'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_lasttime<\'' . $post['nb_date_to'] . '\' ';
            }
            if (!empty($post['nb_add_from'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_addtime>\'' . $post['nb_add_from'] . '\' ';
            }
            if (!empty($post['nb_add_to'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_addtime<\'' . $post['nb_add_to'] . '\' ';
            }
            if (!empty($post['nb_area'])) {
                if ($filter == '') {
                    $filter .= ' where ';
                } else {
                    $filter .= ' and ';
                }
                $filter .= ' nb_area=\'' . $post['nb_area'] . '\' ';
            }
        }
        //print_r($_POST);
        //exit;
        //排序
        $column = $post['order'][0]['column'];
        $dir = $post['order'][0]['dir'];
        $start = $post['start'];
        $length = $post['length'];
        $order = '';
        switch ($column) {
            case 0:
                $order = 'nb_id';
                break;
            case 1:
                $order = 'nb_guid';
                break;
            case 2:
                $order = 'nb_addtime';
                break;
            case 3:
                $order = 'nb_lasttime';
                break;
            case 4:
                $order = 'nb_name';
                break;
            case 5:
                $order = 'nb_cname';
                break;
            case 6:
                $order = 'nb_vid';
                break;
            case 7:
                $order = 'nb_group';
                break;
            case 8:
                $order = 'nb_area';
                break;
            case 9:
                $order = 'nb_stauts';
                break;
            default:
        }
     		$sql="SELECT * FROM ".$table." ".$filter;
		$sql2="SELECT count(*) as mcnt FROM  ".$table." ".$filter;	
        $sql .= ' order by ' . $order . ' ' . $dir;
        $sql .= ' limit ' . $start . ',' . $length;
        
       
        
        $query = $this->db->query($sql);
        $netbots = $query->result_array();
        $mcnt = $this->db->query($sql2)->row()->mcnt;
        backdata:
        $iTotalRecords = $mcnt;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $records = array();
        $records['data'] = array();
        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;
        $status_list = array(array('info' => '断开'), array('success' => '正常'), array('danger' => '激活'), array('warning' => '静默'));
        $this->config->load('area', TRUE);
        $netbot_area = $this->config->item('netbot_area', 'area');
    
        //遍历列表
        foreach ($netbots as $value) {
            $status = $status_list[$value['nb_stauts']];
            $id = $value['nb_id'];
            $guid = $value['nb_guid'];
            $ss = '<span class="label label-sm label-' . key($status) . '">' . current($status) . '</span>';
            $set = '<a href="/admin/netbot/view/' . $guid . '" class="btn btn-xs default" data-target="#ajaxview" data-toggle="modal"><i class="fa fa-search"></i> View</a>';
            if ($value['nb_stauts'] == 1 || $value['nb_stauts'] == 2) {
                $set .= '<a href="javascript:setstauts(\'' . $value['nb_guid'] . '\',2,\'激活\')" class="btn btn-xs blue"><i class="fa fa-forward"></i>激活</a>';
            }
            $records['data'][] = array('<input type="checkbox" name="id[]"  value="' . $id . '">', $guid, $value['nb_addtime'], $value['nb_lasttime'], $value['nb_name'], $value['nb_cname'], $value['nb_vid'], $groupname[$value['nb_group']], $netbot_area[$value['nb_area']], $ss, $set);
        }
   
        $records['draw'] = $sEcho;
        $records['recordsTotal'] = $iTotalRecords;
        $records['recordsFiltered'] = $iTotalRecords;
        echo json_encode($records);
        
        
        
    }
    public function view()
    {
        $guid = $this->uri->segment(4);
        $netbot = $this->netbot_mdl->info($guid);
        $error = array();
        if (empty($netbot)) {
            $error['msg'] = '该主机不存在！';
            goto endedit;
        }
        if ($this->user_role != 'administrator') {
            $role_check = $this->member_mdl->role_check_guid($this->user, $guid);
            if (!$role_check) {
                $error['msg'] = '您没有该主机权限！';
                goto endedit;
            }
        }
        $stauts = '';
        $action = '';
        switch ($netbot['nb_stauts']) {
            case 1:
                $stauts = '<i class="fa fa-play"></i>正常';
                $action .= '<a href="javascript:setstauts(\'' . $netbot['nb_guid'] . '\',3,\'静默\')" class="btn btn-xs blue"><i class="fa fa-eye-slash"></i>静默</a>';
                break;
            case 2:
                $stauts = '<i class="fa fa-forward"></i>已激活 (' . $netbot['nb_stauts_val'] . ')';
                break;
            case 3:
                $stauts = '<i class="fa  fa-eye-slash"></i>已静默 (' . $netbot['nb_stauts_val'] . ')';
                break;
            default:
                $stauts = '<i class="fa fa-stop"></i>已断开 (' . $netbot['nb_stauts_val'] . ')';
                $action .= '<a href="javascript:setstauts(\'' . $netbot['nb_guid'] . '\',3,\'静默\')" class="btn btn-xs blue"><i class="fa fa-eye-slash"></i>静默</a>';
        }
        $netbot['stauts'] = $stauts;
        $netbot['action'] = $action;
        $netbot['ng_name'] = $this->db->query('SELECT ng_name FROM groups where ng_id=' . $netbot['nb_group'] . '  limit 1')->row()->ng_name;
        $gexps = $this->db->query('SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id=\'' . $netbot['nb_guid'] . '\'')->result_array();
        $nb_group_expand = '';
        foreach ($gexps as $val) {
            $ng_name = $this->db->query('SELECT ng_name FROM groups where ng_id=' . $val['nge_group_id'] . '  limit 1')->row()->ng_name;
            $nb_group_expand .= '【' . $ng_name . '】';
        }
        $netbot['nb_group_expand'] = $nb_group_expand;
        $view_data = array();
        $view_data['netbot'] = $netbot;
        $this->config->load('area', TRUE);
        $netbot_area = $this->config->item('netbot_area', 'area');
        $view_data['netbot_area'] = $netbot_area;
        $this->config->load('os', TRUE);
        $netbot_os = $this->config->item('netbot_os', 'os');
        $view_data['netbot_os'] = $netbot_os;
        endedit:
        if (!empty($error)) {
            $this->load->view('admin/error', $error);
        } else {
            $this->load->view('admin/netbot_view', $view_data);
        }
    }
    public function viewchat()
    {
        $guid = $this->uri->segment(4);
        $netbot = $this->netbot_mdl->info($guid);
        if (empty($netbot)) {
            $error['msg'] = '该主机不存在！';
            goto endedit;
        }
        if ($this->user_role != 'administrator') {
            $role_check = $this->member_mdl->role_check_guid($this->user, $guid);
            if (!$role_check) {
                $error['msg'] = '您没有该主机权限！';
                goto endedit;
            }
        }
        $stauts = '';
        $action = '';
        switch ($netbot['nb_stauts']) {
            case 1:
                $stauts = '<i class="fa fa-play"></i>正常';
                $action .= '<a href="javascript:setstauts(\'' . $netbot['nb_guid'] . '\',3,\'静默\')" class="btn btn-xs blue"><i class="fa fa-eye-slash"></i>静默</a>';
                break;
            case 2:
                $stauts = '<i class="fa fa-forward"></i>已激活 (' . $netbot['nb_stauts_val'] . ')';
                break;
            case 3:
                $stauts = '<i class="fa  fa-eye-slash"></i>已静默 (' . $netbot['nb_stauts_val'] . ')';
                break;
            default:
                $stauts = '<i class="fa fa-stop"></i>已断开 (' . $netbot['nb_stauts_val'] . ')';
                $action .= '<a href="javascript:setstauts(\'' . $netbot['nb_guid'] . '\',3,\'静默\')" class="btn btn-xs blue"><i class="fa fa-eye-slash"></i>静默</a>';
        }
        $netbot['stauts'] = $stauts;
        $netbot['action'] = $action;
        $netbot['ng_name'] = $this->db->query('SELECT ng_name FROM groups where ng_id=' . $netbot['nb_group'] . '  limit 1')->row()->ng_name;
        $gexps = $this->db->query('SELECT nge_group_id FROM netbot_group_expand where nge_netbot_id=\'' . $netbot['nb_guid'] . '\'')->result_array();
        $nb_group_expand = '';
        foreach ($gexps as $val) {
            $ng_name = $this->db->query('SELECT ng_name FROM groups where ng_id=' . $val['nge_group_id'] . '  limit 1')->row()->ng_name;
            $nb_group_expand .= '【' . $ng_name . '】';
        }
        $netbot['nb_group_expand'] = $nb_group_expand;
        $view_data = array();
        $view_data['netbot'] = $netbot;
        endedit:
        if (!empty($error)) {
            $this->load->view('admin/error', $error);
        } else {
            $this->load->view('admin/netbot_viewchat', $view_data);
        }
    }
    public function setstauts()
    {
        $guid = $this->input->post('guid');
        if ($this->user_role != 'administrator') {
            $role_check = $this->member_mdl->role_check_guid($this->user, $guid);
            if (!$role_check) {
                show_json_netbot(NULL, 0, '您没有该主机权限！');
            }
        }
        $val = intval($this->input->post('val'));
        $stauts = intval($this->input->post('stauts'));
        $netbot = $this->netbot_mdl->info($guid);
        switch ($stauts) {
            case 3:
                $tl_function = 'sleep';
                if ($netbot['nb_stauts'] == 3) {
                    show_json_netbot(NULL, 1, '已改变');
                }
                $tl_vars = array();
                $tl_vars['interval'] = $val;
                $taskdata = $this->netbot_mdl->tl_send($guid, $tl_function, $tl_vars, 'cron', 0);
                show_json_netbot(NULL, 1, $taskdata);
                break;
            case 11:
                $tl_function = 'setconfig';
                $tl_vars = array();
                $tl_vars['nb_interval'] = $val;
                $taskdata = $this->netbot_mdl->tl_send($guid, $tl_function, $tl_vars, 'cron', 0);
                show_json_netbot(NULL, 1, $taskdata);
                break;
            default:
        }
    }
    public function getchatlist()
    {
        $this->load->model('chatlist_mdl');
        if ($this->user_role != 'administrator') {
            $chatlist = $this->chatlist_mdl->getlist_user($this->user);
        } else {
            $chatlist = $this->chatlist_mdl->getlist();
        }
        if (empty($chatlist)) {
            show_json_netbot(NULL, 0, '没有数据');
        }
        $msg = '';
        foreach ($chatlist as $value) {
            $set = '';
            $set .= '<a href="javascript:stopchat(\'' . $value['id'] . '\',\'' . $value['guid'] . '\')" class="btn btn-xs blue"><i class="fa fa-stop"></i>停止激活</a>';
            if ($value['stauts'] == 1) {
                $stauts = '<a href="/admin/main/chat?netbotguid=' . $value['guid'] . '" class="btn btn-xs blue" target=_chat><i class="fa fa-clock-o"></i>进入管理</a>';
            } else {
                $stauts = '等待激活……';
            }
            $msg .= '<tr><td>' . $value['guid'] . '</td><td>' . $value['name'] . '</td><td>' . $value['cname'] . '</td><td>' . $value['username'] . '</td><td>' . $value['lasttime'] . '</td><td>' . $stauts . '</td><td>' . $set . '</td></tr>';
        }
        show_json_netbot(NULL, 1, $msg);
        die;
    }
    public function addchat()
    {
        $guid = $this->input->post('guid');
        if ($this->user_role != 'administrator') {
            $role_check = $this->member_mdl->role_check_guid($this->user, $guid);
            if (!$role_check) {
                show_json_netbot(NULL, 0, '您没有该主机权限！');
            }
        }
        $val = $this->input->post('val');
        $username = $this->user;
        $netbot = $this->netbot_mdl->info($guid);
        if ($netbot['nb_stauts'] != 1 && $netbot['nb_stauts'] != 2) {
            show_json_netbot(NULL, 0, '该机器已断开，无法激活');
        }
        $this->load->model('chatlist_mdl');
        if ($this->chatlist_mdl->check($username, $guid)) {
            show_json_netbot(NULL, 0, '激活列表中已存在');
        }
        $taskdata = array();
        if ($netbot['nb_stauts'] == 1) {
            if (!$this->chatlist_mdl->check4($guid)) {
                $tl_vars = array();
                $tl_vars['interval'] = $val;
                $this->db->query('update tasklist_cron set tl_stauts=3  where tl_netbot=\'' . $guid . '\' and tl_function=\'startchat\' and tl_stauts=0');
                $this->db->query('update tasklist_chat set tl_stauts=3  where tl_netbot=\'' . $guid . '\'  and tl_stauts=0');
                $taskdata = $this->netbot_mdl->tl_send($guid, 'startchat', $tl_vars, 'cron', 0);
            }
            $stauts = 0;
        } else {
            $stauts = 1;
        }
        $data = array();
        $data['guid'] = $guid;
        $data['name'] = $netbot['nb_name'];
        $data['cname'] = $netbot['nb_cname'];
        $data['username'] = $username;
        $data['lasttime'] = date('Y-m-d H:i:s');
        $data['stauts'] = $stauts;
        $this->chatlist_mdl->add($data);
        show_json_netbot(NULL, 1, $taskdata);
    }
    public function stopchat()
    {
        $id = $this->input->post('id');
        $username = $this->user;
        $this->load->model('chatlist_mdl');
        $info = $this->chatlist_mdl->info($id);
        $guid = $info['guid'];
        $netbot = $this->netbot_mdl->info($guid);
        $this->chatlist_mdl->del($id);
        if ($netbot['nb_stauts'] != 2) {
            $this->db->query('update tasklist_cron set tl_stauts=3  where tl_stauts=0 and tl_netbot=\'' . $guid . '\' and tl_function=\'startchat\' ');
            $this->db->query('update tasklist_chat set tl_stauts=3  where tl_stauts=0 and tl_netbot=\'' . $guid . '\' and tl_function=\'endchat\' ');
            show_json_netbot(NULL, 1, '该机器已断开');
        }
        if ($this->chatlist_mdl->check2($guid)) {
            show_json_netbot(NULL, 1, '激活列表有其他用户');
        }
        $this->db->query('update tasklist_cron set tl_stauts=3  where tl_stauts=0 and tl_netbot=\'' . $guid . '\' and tl_function=\'startchat\' ');
        $this->db->query('update tasklist_chat set tl_stauts=3  where tl_stauts=0 and tl_netbot=\'' . $guid . '\' and tl_function=\'endchat\' ');
        $tl_vars = array();
        $taskdata = $this->netbot_mdl->tl_send($guid, 'endchat', $tl_vars, 'chat', 0);
        show_json_netbot(NULL, 1, $taskdata);
    }
    public function getgroupset()
    {
        $ng_type = $this->input->post('ng_type');
        $this->load->model('group_mdl');
        $list = $this->group_mdl->getlist($ng_type);
        $grouptype = array('main' => '主分组', 'expand' => '扩展分组');
        $html = '<option value="">选择值...</option>';
        foreach ($list as $value) {
            $html .= '<option value="' . $value['ng_id'] . '">' . $value['ng_name'] . '</option>';
        }
        echo $html;
        die;
    }
    public function setname()
    {
        $guid = $this->input->post('guid');
        if ($this->user_role != 'administrator') {
            $role_check = $this->member_mdl->role_check_guid($this->user, $guid);
            if (!$role_check) {
                show_json_netbot(NULL, 0, '您没有该主机权限！');
            }
        }
        $name = $this->input->post('name');
        if (empty($guid) || empty($name)) {
            show_json_netbot(NULL, 0, '值不能为空！');
        }
        $data = array();
        $data['nb_name'] = $name;
        $this->netbot_mdl->update($guid, $data);
        show_json_netbot(NULL, 1, '修改成功！');
    }
}