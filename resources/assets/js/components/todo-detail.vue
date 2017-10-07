<template id="post">
    <div>
     <div class="panel panel-default">
        <div class="panel-heading">
         <h2 class="page_title"> Detail </h2>
        </div>
        <div class="panel-body">  
            <div class="form-group">
                <label class="control-label col-xs-3">Title - </label>
                <div class="control-label col-xs-8">
                    {{todo.title}}
                </div>
            </div>

             <div class="form-group" style="clear: left;">
                <label class="control-label col-xs-3">Description - </label>
                <div class="control-label col-xs-8">
                    {{todo.description}}
                </div>
            </div>

             <div class="form-group" style="clear: left;">
                <label class="control-label col-xs-3">Duedate - </label>
                <div class="control-label col-xs-8">
                    {{todo.duedate}}
                </div>
            </div>

            <div class="form-group" style="clear: left;">
                <label class="control-label col-xs-3">Created At - </label>
                <div class="control-label col-xs-8">
                    {{todo.createdat}}
                </div>
            </div> 

            <div class="form-group" style="clear: left;">
                <label class="control-label col-xs-3">Updated At - </label>
                <div class="control-label col-xs-8">
                    {{todo.updatedat}}
                </div>
            </div>
            
        </div>
      </div>
      <router-link class="btn btn-link pull-left" v-bind:to="{path: '/'}"> Go To List </router-link>
    </div>
</template>

<script>
     export default {
        data() {
        return{
            todo: {
                    id:'',
                    title: '',
                    description: '',
                    duedate: '',
                    createdat: '',
                    updatedat: ''
                }
            }
        },
        created(){
        	this.get_detail_id();
        },
        methods: {                 
            get_detail_id(){
           		var urlstring = window.location;
           		var arr = String(urlstring).split("/");
           		var id = arr[arr.length-1];

           		axios.get('../api/todos/'+id)
                    .then((res) => {                 	
                        this.todo.title= res.data.title;
                        this.todo.description= res.data.description;
                        this.todo.duedate= res.data.duedate;
                        this.todo.createdat= res.data.created_at;
                        this.todo.updatedat= res.data.updated_at;
                    })
                    .catch((err) => {//console.error(err)
                           // console.log(err.response.data.message);
                        }
                    );
            }
        }
    }
</script>