var xmlobj;                                 //定义XMLHttpRequest对象

function CreateXMLHttpRequest()

{

    if (window.ActiveXObject)

            //如果当前浏览器支持ActiveXObject，则创建ActiveXObject对象

            {

                xmlobj = new ActiveXObject("Microsoft.XMLHTTP");

            }

    else if (window.XMLHttpRequest)
        //如果当前浏览器支持XMLHttpRequest，则创建

        XMLHttpRequest对象

    {

        xmlobj = new XMLHttpRequest();

    }

}
