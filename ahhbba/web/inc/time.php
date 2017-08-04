<html>
    <head>
        <title>Untitled Document</title>
        <meta http-equiv=refresh content='600;'>
        <link rel="stylesheet" type="text/css" href="default.css" />
        <style type="text/css">
            <!--
            #Layer1 {
                position:absolute;
                width:254px;
                height:26px;
                z-index:1;
                left: 18px;
                top: -3px;
            }
            -->
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body >
    <center><? print(date('Y-m-d'))." "; ?>
        <span id="tm"></span>
    </center>
</body>
</html>
<SCRIPT language=javascript>
    function clocks(var1, var2, var3)
    {
        var3++;
        if (var3 == 60)
        {
            var3 = 0;
            var2++;
        }
        if (var2 == 60)
        {
            var2 = 0;
            var1++;
        }
        if (var1 < 10)
        {
            h = "0" + var1;
        }
        else
        {
            h = var1;
        }
        if (var2 < 10)
        {
            i = "0" + var2;
        }
        else
        {
            i = var2;
        }
        if (var3 < 10)
        {
            s = "0" + var3;
        }
        else
        {
            s = var3;
        }
        tm.innerText = h + ":" + i + ":" + s;
        setTimeout("clocks(" + var1 + "," + var2 + "," + var3 + ")", 1000);
    }
    clocks( < ? echo date("H,i,s")? > );
</SCRIPT>
