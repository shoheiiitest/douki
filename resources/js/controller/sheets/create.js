import { HotTable, HotColumn } from '@handsontable/vue';
import Handsontable from 'handsontable';

var CtrSheets = new Vue({
    el : '#CtrSheets',
    data : {
        show:false,
        test:['aaa','bbb','ccc'],
        loading:false,
        sheet_name:'',
        file_name:'',
        files:[],
        errors:[],
        msg : '　',
        root:'testHot',
        hotSettings: {
            data: [],//Handsontable.helper.createSpreadsheetData(6, 10),
            dateFormat: 'YYYY/MM/DD',
            columns:[],
            rowHeaders: true,
            colHeaders: [],
            filters: true,
            dropdownMenu: true,
            //colWidths: 200, 列幅を指定
            contextMenu: true,
            manualColumnResize: true,
            // minSpareCols: 2,
            // minSpareRows: 1,
            stretchH: 'last',
            licenseKey: 'non-commercial-and-evaluation',
        },
    },
    methods:{
        async getItems(mode){
            this.loading = true;
            var pathArray = window.location.pathname.split('/');
            var project_id = pathArray[3];
            var requestPath = '/api/sheets/getItems/'+ mode + '/' + project_id;
            if(mode=='edit') {
                var sheet_id = pathArray[4];
                requestPath += '/' + sheet_id;
            }

            const result = await axios.get(requestPath).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.hotSettings.colHeaders = result.headers;
                for(var i=0; i<result.headers.length; i++){
                    switch (result.colTypes[i]) {
                        case 0://結果
                            this.hotSettings.columns[i] ={
                                readOnly:true,
                            };
                            break;
                        case 1:
                            this.hotSettings.columns[i] ={type:'text'};
                            break;
                        case 2:
                            this.hotSettings.columns[i] ={
                                editor: 'select',
                                selectOptions: result.members
                            };
                            break;
                        case 3:
                            this.hotSettings.columns[i] ={type:'date'};
                            break;
                        case 4:
                            this.hotSettings.columns[i] ={
                                editor: 'select',
                                selectOptions: result.items[i],
                            };
                            break;

                    }

                }

                if(mode=='create'){
                    this.hotSettings.data = Handsontable.helper.createEmptySpreadsheetData(5,this.hotSettings.colHeaders.length);
                }else if(mode=='edit'){
                    this.sheet_name = result.sheet_name;
                    this.hotSettings.data = result.data;
                }
            }else{
                alert('エラーでござる');
            }
            // console.log(this.hotSettings.colHeaders.length);
            this.loading = false;

        },

        async submit(mode,project_id,sheet_id=null){
            var data = {
                mode:mode,
                project_id: project_id,
                sheet_id:sheet_id,
                sheet_name:this.sheet_name,
                cases:this.$refs.testHot.hotInstance.getData(),
            };
            this.loading = true;
            var requestPath = '/api/sheets/submit';
            const result = await axios.post(requestPath,data).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.file_name = '';
                this.files = [];
                this.modal("保存成功でござる");
                this.errors = [];
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('何かエラーがあるでござる');
                this.loading = false;
            }
            this.loading = false;

        },

        addRow(){console.log("aaa");
            this.hotSettings.data.push([]);
        },

        deleteRow(){
            this.hotSettings.data.pop();
        },

        async exportSheet(project_id,sheet_id){
            // this.loading = true;
            var requestPath = '/sheet/export/' + project_id + '/' + sheet_id;
            window.location.href = requestPath;
            // this.loading = false;
        },

        upFile(e,target){
            console.log(e);
            this.file_name = e.target.files[0].name;
            this.files = e.target.files[0];
        },

        async setImportFile(){
            this.loading = true;
            let formData = new FormData();
            formData.append('customFile',this.files);
            formData.append('customFileName',this.file_name);

            this.loading = true;
            var requestPath = '/api/sheets/setImportFile';
            let result = await axios.post(requestPath,formData,{ 'content-type': 'multipart/form-data' }).then(function (response) {
                console.log(response.data);
                console.log(response.data.sheet_name);
                console.log(response.data.rows);
                // this.sheet_name = response.data.sheet_name;
                // this.hotSettings.data = response.data.rows;
                // this.loading = false;
                // this.show = true;
                // var handler = function(){CtrSheets.show = false};
                // var r = setTimeout(handler,2000);
                return response.data;
            }).catch(function (error) {
                return error;
            });

            this.sheet_name = result.sheet_name;
            this.hotSettings.data = result.rows;
            this.file_name = '';
            this.files = [];
            this.loading = false;
            // this.show = true;
            this.modal("取り込みに成功しました(まだDBには保存されておりませぬ)");
            var handler = function(){CtrSheets.show = false};
            var r = setTimeout(handler,2000);

            // this.loading = false;

        },

        modal(msg){
            	//.modalについたhrefと同じidを持つ要素を探す
            var modalThis = $('body').find("#demo1");
            this.msg = msg;
            //bodyの最下にwrapを作る 
            $('body').append('<div id="modalWrap" />');
            var wrap = $('#modalWrap'); wrap.fadeIn('200');
            modalThis.fadeIn('200');
            //モーダルの高さを取ってくる 
            function mdlHeight() {
                var wh = $(window).innerHeight();
                var attH = modalThis.find('.modalInner').innerHeight();
                modalThis.css({ height: attH });
            }
            mdlHeight();
            $(window).on('resize', function () {
                mdlHeight();
            });
            function clickAction() {
                modalThis.fadeOut('200');
                wrap.fadeOut('200', function () {
                    wrap.remove();
                });
            }
            //wrapクリックされたら 
            wrap.on('click', function () {
                clickAction(); return false;
            });
            //2秒後に消える 
            setTimeout(clickAction.bind(this), 2000);
        }

    },

    mounted(){
        var mode = window.location.pathname.split('/')[2];
        this.getItems(mode);
    },

    components:{
        HotTable,
        HotColumn
    },

});
