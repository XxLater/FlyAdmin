layui.define(['layer', 'jquery', 'element'], function(exports) {
    "use strict request";
    var MOD_NAME = 'request',
        $ = layui.jquery,
        layer = layui.layer,
        element = layui.element;

    var request = new function() {
        this.post = function(url,param,callback) {
            return new Promise(function(resolve,reject) {
                $.post(url,param,function (res){
                    if (res.code !== 1)
                    {
                        reject(res)
                    }
                    resolve(res)
                });
            })
        },
        this.get = function (url,param,callback)
        {
            $.get(url,param,function (res){
                callback(res)
            });
        }
    };
    exports(MOD_NAME, request);
})
