import { HotTable, HotColumn } from '@handsontable/vue';
import Handsontable from 'handsontable';

var CtrIndex = new Vue({
    el: "#CtrIndex",
    data:{
        hotSettings: {
            data: [
                // ['one', 'two', 'three'],
                // ['four', 'five', 'six'],
                // ['seven', 'eight', 'nine']
            ],
            rowHeaders: true,
            colHeaders: true,
            filters: true,
            dropdownMenu: true,
            //colWidths: 200, 列幅を指定
            contextMenu: true,
            manualColumnResize: true,
            // minSpareCols: 2,
            minSpareRows: 3,
            stretchH: 'last',
            licenseKey: 'non-commercial-and-evaluation',
        },
        secondColumnSettings: {
            title: 'Second column header'
        },
        root:'testHot',
        headers:[],
        sheet:[],
        cases:[],
        caseContents:[],
        loading:false,
        color:'#2D93C5',
        col_show:false,
        hot:[]

    },
    methods:{
        async getItems(flg=false,caseId,headerId){
            this.loading = true;

            var pathArray = window.location.pathname.split('/');
            var project_id = pathArray[2];
            var sheet_id = pathArray[3];

            var requestPath = '/api/cases/getItems/' + String(project_id) + '/' + String(sheet_id);
            const result = await axios.get(requestPath).then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            this.headers = result.headers;
            this.sheet = result.sheet;
            this.cases = result.cases;
            this.caseContents = result.caseContents;
            if(flg){this.closeEdit(caseId,headerId);}
            // this.loadExcel();
            this.loading = false;
        },
        async loadLists(){
            await this.getItems();
            this.hotSettings.data = this.loadExcel();
            // await this.loadExcel();
            // console.log(this.hot.getData());
        },
        editColumns(caseId,headerId){
            $('.label_' + caseId + '_' + headerId).hide();
            $('.edit_' + caseId + '_' + headerId).show();
            this.caseContents[caseId][headerId] = this.caseContents[caseId][headerId].replace(/<br \/>/g,'\n');
        },
        closeEdit(caseId,headerId){
            this.caseContents[caseId][headerId] = this.caseContents[caseId][headerId].replace(/\n/g,'<br />');
            $('.edit_' + caseId + '_' + headerId + ' textarea').val(this.caseContents[caseId][headerId].replace(/<br \/>/g,'\n'));
            $('.label_' + caseId + '_' + headerId).show();
            $('.edit_' + caseId + '_' + headerId).hide();
        },
        async submitContents(caseId,headerId){
            console.log(hot.getData(1,3));
            this.loading = true;
            var data = {
                case_id:caseId,
                header_id:headerId,
                content:$('.edit_' + caseId + '_' + headerId + ' textarea').val(),
            };
            var flg = await axios.post('/api/cases/submit',data).then(function (response) {
                return response.data.success;
            }).catch(function (error) {
                return error;
            });

            if(flg){
                this.getItems(true,caseId,headerId);

            }else{
                alert('DBの更新に失敗しました。');
            }
        },
        loadExcel(){
            var data = [];
            var headers = [];
            var contents = [];
            var rowContents = [];
            var length = this.headers.length;
            for(var i=0; i<length; i++){
                headers[i] = this.headers[i].col_name;
            }
            data[0] = headers;
            var keys = [];
            var s = 0;
            Object.keys(this.cases).forEach(function(key){
               keys[s] = key;
               s++;
            });
            for(var i=0; i<keys.length; i++){

                for(var h=0; h<length; h++){
                    rowContents[h] = this.caseContents[keys[i]][this.headers[h].id].replace(/<br \/>/g,'\n');
                }
                contents[i] = $.extend(true, [], rowContents);
                data[i+1] = contents[i];
            }
            return data;
        },
        getCellData(){
            // this.$refs.testHot.hotInstance.loadData([['new', 'data']]);
            console.log(this.$refs.testHot.hotInstance.getData());
            console.log(this.$refs.testHot.hotInstance.getData()[1]);
        },
    },
    computed:{


    },
    mounted(){
        this.loadLists();
    },

    components:{
        HotTable,
        HotColumn
    }

});
