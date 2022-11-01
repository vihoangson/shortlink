var timeoutPage = 0;
setInterval(()=>{
    if(timeoutPage > 100){
        timeoutPage = 0;
        $(".progress").hide();
        $(".page-header,.card-section").hide();
        $(".loading-page").show();
        setInterval(()=>{
            location.href = '/';
        },2000);
    }else{
        $(".progress-bar").css({"width":timeoutPage+"%"});
        timeoutPage+=1;
    }
}, config.time_count);
console.log(config.time_count);
