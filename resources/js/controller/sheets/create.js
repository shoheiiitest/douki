import { HotTable, HotColumn } from '@handsontable/vue';
import Handsontable from 'handsontable';

var CtrSheets = new Vue({
    el : '#CtrSheets',
    data : {
        loading:false,
        sheet_name:'',
        errors:[],
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
                                selectOptions: ['Shohei', 'Ha', 'Tam', 'Tho']
                            };
                            break;
                        case 3:
                            this.hotSettings.columns[i] ={type:'date'};
                            break;
                        case 4:
                            this.hotSettings.columns[i] ={
                                editor: 'select',
                                selectOptions: ['Kia', 'Nissan', 'Toyota', 'Honda']
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
                alert('成功でござる');
            }else if(result.message != undefined){
                this.errors = result.message;
                this.loading = false;
            }else{
                alert('何かエラーがあるでござる');
                this.loading = false;
            }
            this.loading = false;

        },
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
