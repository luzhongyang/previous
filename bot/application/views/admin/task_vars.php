


<script> 
  var rowCount=<?php echo $rowCount;?>;  //行数默认4行  
  
   

//添加行  
function addRow(){  
	
    rowCount++;  
    var newRow='<tr id="pathlist'+rowCount+'"><td><input type="text"  class="form-control" name="task_cs[list][path][]"></td><td><select  class="form-control" name="task_cs[list][type][]"><option value="file" >文 件</option><option value="folder" >文件夹</option></select></td><td><a href="#" onclick=delRow('+rowCount+')>删</a></td></tr>';  
    $('#optionContainer').append(newRow);  
}  
  
//删除行  
function delRow(rowIndex){ 
	  //$(this).parents('tr:first').remove();
	   //$(this).parent().parent().remove();   
    $("#pathlist"+rowIndex).remove();  
    rowCount--;  
}   
</script>    