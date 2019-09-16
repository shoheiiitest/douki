
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
        async getItems(caseId,headerId){
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
            this.closeEdit(caseId,headerId);
            this.loading = false;
        },
        loadLists(){
            this.getItems();

        },
        editColumns(caseId,headerId){
            $('.label'+ '_' + caseId + '_' + headerId).hide();
            $('.edit'+ '_' + caseId + '_' + headerId).show();
            this.caseContents[caseId][headerId] = this.caseContents[caseId][headerId].replace(/<br \/>/g,'');
        },
        closeEdit(caseId,headerId){
            $('.label'+ '_' + caseId + '_' + headerId).show();
            $('.edit'+ '_' + caseId + '_' + headerId).hide();
        },
        async submitContents(caseId,headerId){
            this.loading = true;
            var data = {
                case_id:caseId,
                header_id:headerId,
                content:this.caseContents[caseId][headerId]
            };
            var flg = await axios.post('/api/cases/submit',data).then(function (response) {
                return response.data.success;
            }).catch(function (error) {
                return error;
            });

            if(flg){
                this.getItems(caseId,headerId);

            }else{
                alert('DBの更新に失敗しました。');
            }
        }
    },
    computed:{


    },
    mounted(){
        this.loadLists();
    },

});
