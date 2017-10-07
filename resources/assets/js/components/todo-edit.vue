<template>
    <div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="page_title"> {{pgtitle}}</h2>
        </div>
        <div class="panel-body"> 

            <div class="alert alert-warning" v-if="showMsg === 1" v-show="showMsg">
              <strong>Warning!</strong> <span v-html="error_msg"></span>
            </div>
            <form action="#" id="frmtodo" name="frmtodo" class="form-horizontal">
                <div class="form-group">
                    <label for="inputTitle" class="control-label col-xs-3">Title <span class="star">*</span></label>
                    <div class="col-xs-9">
                        <input name="title" required type="text" class="form-control" id="inputTitle" v-model="todo.title"  placeholder="Title">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDescription" class="control-label col-xs-3">Description <span class="star">*</span></label>
                    <div class="col-xs-9">
                        <textarea class="form-control" id="inputDescription" placeholder="Description" v-model="todo.description"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputDuedate" class="control-label col-xs-3">Duedate <span class="star">*</span></label>
                    <div class="col-xs-9">
                       <input type="date" class="form-control" v-model="todo.duedate"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button type="button" class="btn btn-primary" v-on:click="saveTask()">Save</button>
                        <button type="button" v-on:click="clearTask()" class="btn btn-default">Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
      <router-link class="btn btn-link pull-left" v-bind:to="{path: '/'}"> Go To List </router-link>
    </div>
</template>

<script>
     export default {
        data() {
        return{
            pgtitle:'',
            error_msg:'',
            showMsg:'0',
            date:new Date(),
            todo: {
                    id:'',
                    title: '',
                    description: '',
                    duedate: ''
                }
            }
        },
		 created(){
            this.get_detail_id();
        },
        methods:  {      
            get_detail_id(){
                var urlstring = window.location;
                var arr = String(urlstring).split("/");
                this.todo.id = arr[arr.length-1];

                this.pgtitle = (this.todo.id>0)?'Edit':'Create';
                axios.get('../api/todos/'+this.todo.id)
                    .then((res) => {
                        if ( res.status == 200)
                        {
                            this.todo.title= res.data.title;
                            this.todo.description= res.data.description;
                            this.todo.duedate= res.data.duedate;
                        }
                        else
                            this.error_msg = "Select Fail!";
                    })
                    .catch((err) => {//console.error(err)
                           // console.log(err.response.data.message);
                        }
                    );
            },
            saveTask(){
                if ( this.todo.id == 0 ) //insert
                {
                    axios.post('api/todos', this.todo)
                    .then((res) => {
                        if ( res.status == 200)
                        {
                            this.$router.push({name: 'detail',params: { id: res.data.id } });
                        }
                        else
                            this.error_msg = "Save Fail!";
                    })
                    .catch((err) => {//console.error(err)
                        if (err.response.status == 422)
                        {
                           this.showMsg=1;
                           var errmsg ='';

                           if(err.response.data.errors.hasOwnProperty('title'))
                           {
                                err.response.data.errors.title.forEach(function(entry) {
                                   errmsg += '<br/>'+ entry;
                                });
                            }

                            if(err.response.data.errors.hasOwnProperty('description')){
                                err.response.data.errors.description.forEach(function(entry) {
                                    errmsg += '<br/>'+ entry;
                                });
                            }

                             if(err.response.data.errors.hasOwnProperty('duedate')){
                                err.response.data.errors.duedate.forEach(function(entry) {
                                    errmsg += '<br/>'+ entry;
                                });
                            }

                            this.error_msg = errmsg;
                        }
                    });
                }
                else //update
                {
                    axios.put('../api/todos/'+this.todo.id, this.todo)
                    .then((res) => {
                        if ( res.status == 200)
                            this.$router.push({name: 'detail',params: { id: this.todo.id } }) ;
                        else
                            this.error_msg = "Save Fail!";
                        
                    })
                    .catch((err) => {
                        if (err.response.status == 422)
                        {
                           this.showMsg=1;
                           var errmsg ='';

                           if(err.response.data.errors.hasOwnProperty('title'))
                           {
                                err.response.data.errors.title.forEach(function(entry) {
                                   errmsg += '<br/>'+ entry;
                                });
                            }

                            if(err.response.data.errors.hasOwnProperty('description')){
                                err.response.data.errors.description.forEach(function(entry) {
                                    errmsg += '<br/>'+ entry;
                                });
                            }

                             if(err.response.data.errors.hasOwnProperty('duedate')){
                                err.response.data.errors.duedate.forEach(function(entry) {
                                    errmsg += '<br/>'+ entry;
                                });
                            }

                            this.error_msg = errmsg;
                        }
                        }
                    );
                }
            },
            clearTask(){ //clear data
                this.todo.title='';
                this.todo.description='';
                this.todo.duedate='';
            }
        }
    }
</script>
