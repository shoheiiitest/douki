
//import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

var CtrIndex = new Vue({
    el: "#CtrIndex",
    data:{
        headers:[],
        sheet:[],
        cases:[],
        caseContents:[],
        loading:false,
        color:'#2D93C5',
        col_show:false,

    },
    methods:{
        async getItems(){
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
            this.cases = result.cases; console.log(result.caseContents);
            this.caseContents = result.caseContents;
            this.loading = false; console.log(this.caseContents);
        },
        loadLists(){
            this.getItems();

        },
        editColumns(index){
            this.col_show = true;
        },
        closeEdit(i){
            this.col_show = false;
            console.log(i);
        },
        async submitContents(){
            this.loading = true;
            // this.col_show = false;
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
                this.col_show = false;

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
    },

});
