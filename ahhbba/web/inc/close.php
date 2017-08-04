<script language="javascript">
<!-- 
    function clock() {
        i = i - 1
        document.title = "本窗口将在" + i + "秒后自动关闭!";
        if (i > 0)
            setTimeout("clock();", 1000);
        else
            self.close();
    }
    var i = 5
    clock();
//--> 
</script> 
<center><br><br><br><br><h1>
        <?
        $title=$_GET['title'];

        echo  $title  ;


        ?></h1>
</center>