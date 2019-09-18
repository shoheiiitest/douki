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
            rowHeaders: true,
            colHeaders: [],
            filters: true,
            dropdownMenu: true,
            //colWidths: 200, 列幅を指定
            contextMenu: true,
            manualColumnResize: true,
            // minSpareCols: 2,
            minSpareRows: 20,
            stretchH: 'last',
            licenseKey: 'non-commercial-and-evaluation',
        },
    },
    methods:{
        async getHeaders(){
            this.loading = true;
            var pathArray = window.location.pathname.split('/');
            var project_id = pathArray[3];

            const result = await axios.get('/api/sheets/getHeaders/'+ project_id).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });

            if(result.success){
                this.hotSettings.colHeaders = result.headers;
                this.hotSettings.data = Handsontable.helper.createEmptySpreadsheetData(20,this.hotSettings.colHeaders.length);
            }else{
                alert('エラーでござる');
            }
            // console.log(this.hotSettings.colHeaders.length);
            this.loading = false;

        },

        async submit(){
            // var data = {
            //     project_name:this.project_name,
            // };
            // this.loading = true;
            // var requestPath = '/api/projects/submit';
            // const result = await axios.post(requestPath,data).then(function (response) {
            //     return response.data;
            // }).catch(function (error) {
            //     return error;
            // });
            //
            // if(result.success){
            //     location.href='/';
            // }else if(result.message != undefined){
            //     this.errors = result.message;
            //     this.loading = false;
            // }else{
            //     alert('エラーでござる');
            //     this.loading = false;
            // }

            console.log(this.$refs.testHot.hotInstance.getData());

        },
    },

    mounted(){
        this.getHeaders();
    },

    components:{
        HotTable,
        HotColumn
    },

});
