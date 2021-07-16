layui.define(['layer', 'jquery', 'element','notice'], function(exports) {
    "use strict request";
    var MOD_NAME = 'request',
        $ = layui.jquery,
        layer = layui.layer,
        element = layui.element,
        notice = layui.notice,
        request = function() {
        this.config = {}
        };
    
    service  = {
        request:function(method,url,param,option)
        {
            option = option || {}

            let ajaxOption = $.enxtend({url:url,method:method,data:param,dataType:'json'},option)

            return new Promise(function(resolve,reject) {
                $.ajax({
                    url:url,
                    method:method,
                    data:param,
                    dataType:'json',
                    success:function(result)
                    {
                        switch(result.code)
                        {
                            case 40003:
                                notice.error("登陆状态失效请重新登陆")
                                setTimeout(function(){
                                    top.location.href = '/admin'
                                },1500)
                                reject(result);
                            break;
                            case 0:
                                reject(result);
                            break;
                        }
                        resolve(result)
                    },
                    error:function(error)
                    {
                        reject(error)
                    }
                })
            })
        }
    }

    request.prototype.ajax = function(url,param)
    {
        return service.request('POST',url,param);
    }

    request.prototype.post = function(url,param)
    {
        return service.request('POST',url,param);
    }
    
    request.prototype.get = function(url,param)
    {
        return service.request('GET',url,param);
    }

    var request = new request();

    exports(MOD_NAME, request);
})
