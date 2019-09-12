
var test_data = '';
var CtrIndex = new Vue({
    el: "#CtrIndex",
    data:{
        headers:[],
        sheet:[],
        cases:[],
        caseContents:[],
        loading:false,
        col_show:false
    },
    methods:{
        async getItems(){

            var data = {
                project_id : 1,
                sheet_id : 1
            };
            this.loading = true;
            const result = await axios.get('/api/cases/getItems/1/1').then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            this.headers = result.headers;
            this.sheet = result.sheet;
            this.cases = result.cases;
            this.caseContents = result.caseContents;
            this.loading = false;
        },
        loadLists(){
            this.getItems();
            //console.log(this.headers);
            // this.loading = false;

        },
        editColumns(index){
            this.col_show = true;
        },
        closeEdit(){
            this.col_show = false;
        },
        async submitContents(){
            this.loading = true;
            this.col_show = false;
            var data = {
                sheet_id:this.sheet.id,
                caseContents:this.caseContents
            };
            var flg = await axios.post('/api/cases/submit',data).then(function (response) {
                return response.data.success;
            }).catch(function (error) {
                return error;
            });
            if(flg){
                this.getItems();

            }else{
                alert('DBの更新に失敗しました。');
            }
            this.loading = false;
        }
    },
    computed:{


    },
    mounted(){
        this.loadLists();
    }
});
