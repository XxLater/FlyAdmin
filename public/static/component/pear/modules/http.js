layui.define(['jquery', 'layer','notice'], function (exports) {
    "use strict";

    var $ = layui.jquery;
    var layer = layui.layer;
    var notice = layui.notice;

    var http = {};
    http.appPath = '/admin';
    http.ajax = function (userOptions) {
        userOptions = userOptions || {};

        var options = $.extend(true, {}, http.ajax.defaultOpts, userOptions);
        var oldBeforeSendOption = options.beforeSend;
        options.beforeSend = function (xhr) {
            if (oldBeforeSendOption) {
                oldBeforeSendOption(xhr);
            }

            xhr.setRequestHeader("Pragma", "no-cache");
            xhr.setRequestHeader("Cache-Control", "no-cache");
            xhr.setRequestHeader("Expires", "Sat, 01 Jan 2000 00:00:00 GMT");
        };

        options.success = undefined;
        options.error = undefined;

        return $.Deferred(function ($dfd) {
            $.ajax(options)
                .done(function (data, textStatus, jqXHR) {
                    if(data.code !== 1)
                    {
                        http.ajax.customizeHandleErrorResponse(data, userOptions, $dfd);
                        $dfd.reject(data);
                    }
                    $dfd.resolve(data);
                })
                .fail(function (jqXHR) {
                    http.ajax.handleErrorResponse(jqXHR, userOptions, $dfd);
                });
        });
    }
    http.get = function(url,param,userOptions)
    {
        userOptions = userOptions || {}

        var option = $.extend(userOptions,{url:url,type:'GET',data:param})
        
        return http.ajax(option)
    }

    http.post = function(url,param,userOptions)
    {
        userOptions = userOptions || {}

        var option =  $.extend(userOptions,{url:url,type:'POST',data:param})

        return http.ajax(option)
    };

    $.extend(http.ajax, {
        defaultOpts: {
            dataType: 'json',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        },

        defaultError: {
            message: '系统响应',
            details: '操作失败'
        },

        defaultError40001 :{
            message: '系统响应',
            details: '登陆状态失效请重新登陆'
        },

        defaultError40002 :
        {
            message: '系统响应',
            details: '参数验证失败'
        },

        defaultError40003 :{
            message: '系统响应',
            details: '权限不足，非法访问'
        },

        logError: function (error) {
            console.log(error);
        },

        showError: function (error) {
            if (error.details) {
                return layer.alert(error.details, {
                    title: error.message,
                    icon: 2,
                    closeBtn: 0
                });
            } else {
                return layer.alert(http.ajax.defaultError.details, {
                    title: error.message || http.ajax.defaultError.message,
                    icon: 2,
                    closeBtn: 0
                });
            }
        },

        showErrorAndRedirectUrl: function (error, targetUrl) {
            if (error.details) {
                return layer.alert(error.details, {
                    title: error.message,
                    icon: 2,
                    closeBtn: 0,
                    end: http.ajax.handleTargetUrl(targetUrl)
                });
            } else {
                return layer.alert(http.ajax.defaultError.details, {
                    title: error.message || http.ajax.defaultError.message,
                    icon: 2,
                    closeBtn: 0,
                    end: http.ajax.handleTargetUrl(targetUrl)
                });
            }
        },

        handleTargetUrl: function (targetUrl,timeOut=1500) {
            targetUrl = targetUrl || http.appPath;
            setTimeout(function(){
                top.location.href = targetUrl;
            },timeOut)
        },
        customizeHandleErrorResponse :function(data,userOptions,$dfd)
        {
            if (userOptions.ignoreTheError !== true) {
                switch (data.code) {
                    case 0:
                        if(data.msg)
                        {
                            notice.error(data.msg)
                        }else
                        {
                            notice.error(http.ajax.defaultError.details)
                        }
                        break;
                    case 40001:
                        notice.error(http.ajax.defaultError40003.details)
                        http.ajax.showErrorAndRedirectUrl(http.ajax.defaultError40003, http.appPath);
                        break;
                    case 40002:
                        if(data.msg == '')
                        {
                            notice.error(http.ajax.defaultError40002.details)
                        }else
                        {
                            notice.error(data.msg)
                        }
                        break;
                    case 400003:
                        notice.warning(http.ajax.defaultError40003.details)
                        break;
                }
            }
        },
        handleErrorResponse: function (jqXHR, userOptions, $dfd) {
            if (userOptions.ignoreTheError !== true) {
                switch (jqXHR.status) {
                }
            }
            $dfd.reject.apply(this, arguments);
            userOptions.error && userOptions.error.apply(this, arguments);
        },

        ajaxSendHandler: function (event, request, settings) {
            var token = http.ajax.getToken();
            if (!token) {
                return;
            }

            if (!settings.headers || settings.headers[http.ajax.tokenHeaderName] === undefined) {
                request.setRequestHeader(http.ajax.tokenHeaderName, token);
            }
        },

        getToken: function () {
            return http.ajax.getCookieValue(http.ajax.tokenCookieName);
        },

        tokenCookieName: 'XSRF-TOKEN',
        tokenHeaderName: 'X-XSRF-TOKEN',

        getCookieValue: function (key) {
            var equalities = document.cookie.split('; ');
            for (var i = 0; i < equalities.length; i++) {
                if (!equalities[i]) {
                    continue;
                }

                var splitted = equalities[i].split('=');
                if (splitted.length != 2) {
                    continue;
                }

                if (decodeURIComponent(splitted[0]) === key) {
                    return decodeURIComponent(splitted[1] || '');
                }
            }

            return null;
        }
    });

    $(document).ajaxSend(function (event, request, settings) {
        return http.ajax.ajaxSendHandler(event, request, settings);
    });
    exports('http', http);
});