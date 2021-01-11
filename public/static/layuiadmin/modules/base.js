/** layuiAdmin.std-v1.0.0 LPPL License By http://www.layui.com/admin/ */
;layui.define(function (e) {
    var i = (layui.$, layui.layer, layui.laytpl, layui.setter, layui.view, layui.admin);
    i.events.logout = function () {
        i.req({
            url: layui.setter.base + "json/user/logout.js", type: "get", data: {}, done: function (e) {
                i.exit(function () {
                    location.href = "user/login.html"
                })
            }
        })
    },
    i.events.request = function(url , param  , method = 'get'){
        url = 'http://base.echo.cysky.cc/admin/'+url
        i.method(url,param,function (res) {
            return res
        })
    },
    e("base", {})
});