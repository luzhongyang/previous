<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class  TagLibCalldata extends TagLib{
    
    protected  $tags = array(
        'calldata'=> array(
            'attr'=> 'mdl,where,limit,order,debug,cache,format','close'=>1
        ),
        'callfunc'=>array(
            'attr' => 'mdl,func,debug','close' => 1
        ),
		'callfuncw'=>array(
            'attr' => 'mdl,func,debug,where','close' => 1
        )
    );
    
    
    public function _callfunc($attr,$content){
        $attr = $this->parseXmlAttr($attr);
        $attr['mdl'] = empty($attr['mdl']) ? '' : $attr['mdl'];
        $attr['func'] = empty($attr['func']) ? '' : $attr['func'];
        $attr['debug'] = $attr['debug'] ? true : false;
        if(empty($attr['mdl']) || empty($attr['func'])){
            return  '';
        }
        $str = '<?php  ';
        
         $str.=' $items = D("'.$attr['mdl'].'")->'.$attr['func'].'(); ';
  
         if($attr['debug']){           
            $str.=' print_r(D("'.$attr['mdl'].'")->getLastSql()); ';
        }
        
        $str.= ' $index=0; foreach($items  as $item): $index++; ?>';
        $str.=$content;
        $str.=' <?php endforeach; ?>';
        return $str;
    }

	public function _callfuncw($attr,$content){
        $attr = $this->parseXmlAttr($attr);
        $attr['mdl'] = empty($attr['mdl']) ? '' : $attr['mdl'];
        $attr['func'] = empty($attr['func']) ? '' : $attr['func'];
		$attr['where'] = empty($attr['where']) ? '' : $attr['where'];
        $attr['debug'] = $attr['debug'] ? true : false;
        if(empty($attr['mdl']) || empty($attr['func'])){
            return  '';
        }
        $str = '<?php  ';
        
         $str.=' $items = D("'.$attr['mdl'].'")->'.$attr['func'].'('.$attr['where'].'); ';
  
         if($attr['debug']){           
            $str.=' print_r(D("'.$attr['mdl'].'")->getLastSql()); ';
        }
        
        $str.= ' $index=0; foreach($items  as $item): $index++; ?>';
        $str.=$content;
        $str.=' <?php endforeach; ?>';
        return $str;
    }

	

    public function _calldata($attr,$content){

        $attr = $this->parseXmlAttr($attr);
        
        $attr['mdl'] = empty($attr['mdl']) ? 'Recommend' : $attr['mdl'];
        $attr['where'] = empty($attr['where']) ? '' : $this->parseCondition($attr['where']);
       
        $attr['order'] = empty($attr['order']) ? '' : $attr['order'];
        $attr['limit'] = empty($attr['limit']) ? '0,10' : $attr['limit'];
        $attr['cache'] = $attr['cache'] ? (int)$attr['cache'] : 0;
        $attr['format'] = $attr['format'] ? true : false;
        $attr['debug'] = $attr['debug'] ? true : false;
         $token = join(',',$attr );
        $str = '<?php  ';
        if($attr['cache']){
            $str.='
                $cache = cache(array(\'type\'=>\'File\',\'expire\'=> '.$attr['cache'].'));
                $token = md5("'.$token.'");   
                if(!$items= $cache->get($token)){ ';
        }
        $str.=' $items = D("'.$attr['mdl'].'")->where("'.$attr['where'].'")->order("'.$attr['order'].'")->limit("'.$attr['limit'].'")->select(); ';
        if($attr['debug']){
            
            $str.=' print_r(D("'.$attr['mdl'].'")->getLastSql()); ';
        }
        
        if($attr['format']){
            
            $str.='
                    $items = D("'.$attr['mdl'].'")->CallDataForMat($items);
                
                ';
            
        }

		foreach($items as $k => $v){
			if(is_array($v)){
				foreach($v as $kk => $vv){
					$items[$k][$kk] = $this->getelash($vv);
				}
			}else{
				$items[$k] = $this->getelash($v);
			}
			
		}
        
        if($attr['cache']){
            
            $str.='  
                $cache->set($token,$items);
              }      ;
            ';
        }
        $str.= ' $index=0; foreach($items  as $item): $index++; ?>';
        $str.=$content;
        $str.=' <?php endforeach; ?>';
        return $str;
    }

	// 这里处理文字翻译
	public function getelash($str)
	{
		include_once "Baocms/Lib/libs/English/english.php";
		$english = (array)new english();
		if($english["str_place"][$str]){
			return $english["str_place"][$str];
		}else{
			return $str;
		}
	}
    
}