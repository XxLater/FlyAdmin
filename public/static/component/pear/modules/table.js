layui.define(['table', 'form', 'jquery','drawer','http','notice','laydate'], function(exports){
    "use strict";
    var MOD_NAME = 'table',
		$       = layui.jquery,
        form    = layui.form,
        table   = layui.table,
        drawer  = layui.drawer,
        http    = layui.http,
        notice  = layui.notice,
        laydate = layui.laydate,
        BASEPATH= '',
        service = function()
        {
            this.configs = {}
        };

    service.prototype.render = function(ele,option)
    {
        cols = call.createCols(option.cols);
        
        var table_param = {
            elem: ele,
            method: 'POST',
            url: option.url,
            page: true,
            cols: cols,
            skin: 'line',
            toolbar: '#blockButton',
            defaultToolbar: [{
                layEvent: 'refresh',
                icon: 'layui-icon-refresh',
            }, 'filter', 'print', 'exports']
            ,parseData: function(res){ //res 即为原始返回的数据
                return {
                "code": res.code, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.data.total, //解析数据长度
                "data": res.data.data //解析数据列表
                };
            }
            ,response: {
                 statusName: 'code' //规定数据状态的字段名称，默认：code
                ,statusCode: 1 //规定成功的状态码，默认：0
                ,msgName: 'msg' //规定状态信息的字段名称，默认：msg
                ,dataName: 'data' //规定数据列表的字段名称，默认：data
            }
            ,initSort: {
                field: option.pk //排序字段，对应 cols 设定的各字段名
                ,type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
            }    
        }

        if(total_fields[0] != '' && total_fields.length > 0)
        {
            table_param.totalRow = true;
        }

        return table.render(table_param)
    }

    var call = {
        createCols = function(cols)
        {
            let cols = []

            
        }
    }

    

    
    
    exports(MOD_NAME, table);
  });
  
  