//订阅
function subscribe(issub,id,_token) {
    issub = issub;
    id = id;
    _token = _token;
    $.ajax({
        url: "/user/subscribe",//请求地址
        type: "post",//请求方式
        dataType: "json",//返回数据类型
        data: {_token:_token,id:id,issub:issub},//发送的参数
        success: function (d) {
            console.log(d);
            if(d.error==0){
                alert(d.info);
            }else{
                alert(issub==0?'取消成功':'订阅成功');
                location.reload();
            }
        }
    })
}