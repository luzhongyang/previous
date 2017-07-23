<? if(!defined('IN_ASK2')) exit('Access Denied'); ?>

  <? if($hidefooter!='hidefooter') { ?><div class="web-footer ">
 <div class="container">
  <div class="row">
<div class="col-sm-24 ">
    <p class="mar-t-2 text-center">

        <p class="copyright text-center">
        Powered by<a target="_blank" href="https://www.ask2.cn">Ask2V3.5社交版</a>服务
               <a target="_blank" href="http://www.ask2test.com/?rss/list.html">问题RSS订阅</a>
              <a target="_blank" href="http://www.ask2test.com/?rss/articlelist.html">文章RSS订阅</a>
        <? if($setting['wap_domain']) { ?><a target="_blank" href="http://<?=$setting['wap_domain']?>">手机版</a><? } ?>        <a target="_blank" href="http://www.ask2test.com/?tags.html">网站标签</a>
        <a target="_blank" href="http://www.ask2test.com/?new.html">最新问题</a>
        <span class="icp"><?=$setting['site_icp']?></span>

        </p>
    </p>
   
</div>

  </div>
   
    </div>
    </div>
 
  <? } ?>  <? if($user['uid']!=0) { ?> <? if($user['email']==null||$user['email']==''||$user['email']=='null') $spck=1; ?>  <? if($spck==1) { include template('usercheck'); ?>
 <? } ?>  <? } ?>   <? if($setting['cancopy']==1) { ?>              <script src="<?=SITE_URL?>static/js/nocopy.js" type="text/javascript"></script>
                <? } ?>                
<script src="<?=SITE_URL?>static/js/jquery.lazyload.min.js" type="text/javascript"></script>
<script>
$(function(){
 $("img").addClass("lazy");
$("img.lazy").fadeIn("2000");
})

</script>
<div class="display:none;">
 <? if($setting['site_statcode']) { ?> <? echo str_replace('\\','',$setting['site_statcode']); } ?> 
 
</div>

</body>
</html>