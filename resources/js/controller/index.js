
var test_data = '';
var CtrIndex = new Vue({
    el: "#CtrIndex",
    data:{
        headers:[],
        sheet:[],
        cases:[],
        caseContents:[],
        loading:true,
    },
    methods:{
        async getItems(){

            var data = {
                project_id : 1,
                sheet_id : 1
            };
            const result = await axios.get('/api/cases/getItems/1/1').then(function (response) {
                return response.data;
            }).catch(function (error) {
                return error;
            });
            this.headers = result.headers;
            this.sheet = result.sheet;
            this.cases = result.cases;
            this.caseContents = result.caseContents;
            //this.loading = false;
        },
        loadLists(){
            this.getItems();
            //console.log(this.headers);
        },
    },
    computed:{


    },
    mounted(){
        this.loadLists();
    }
});
