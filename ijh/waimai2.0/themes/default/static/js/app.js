$(function() {
    $(document).on('pageInit', function(event, sectionId, $section) {
        if(sectionId == 'index') {
            console.log('这里执行的是index页面的函数');
        }

        if(sectionId == 'position') {
            console.log('这里执行的是position页面的函数');
            
        }

        if(sectionId == 'shop-index') {
            console.log('这里执行的是shop-index页面的函数');
        }
    });

    $.init();
})