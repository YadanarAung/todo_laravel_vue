<template>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="page_title"> Todo List</h2>
        <router-link class="btn btn-success pull-right" v-bind:to="{path: '/edit/0'}"> Create </router-link>

        </div>
          <div class="panel-body">  
            <div id="alert" class="alert alert-success" v-if="showMsg === 1" v-show="showMsg">
              <strong>Success!</strong> {{error_msg}}
            </div>
            <table id="dt-todo" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Duedate</th>
                  <th>Action</th>
                </tr>
             </thead>
            </table>

          </div>
          <!-- start of modal -->
            <div id="myModal" class="modal fade">
              <div class="modal-dialog" > 
                <div class="modal-content"> 
                  <div class="modal-header"> 
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4> 
                  </div>
                  <div class="modal-body"> 
                    <form class="form-horizontal" role="form" action=""> 
                      <div class="form-group"> 
                        <label class="col-md-12 control-label" style="text-align:center;">Are you sure you want to delete ?</label> 
                      </div> 
                    </form> 
                  </div>
                  <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger btn-confirm">Delete</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          <!--end of -->
         
  </div>
</template>

<script>

require('./../datatable/jquery.dataTables');
require('./../boostrap/bootstrap.min');

export default {
         data() {
        return{
            error_msg:'',
            showMsg:0,              
            }
        },
        dtable:null,
        mounted:function(){
            var self=this;

            //initialize jquery datatable
            $(function(){
                self.dtable = $('#dt-todo').DataTable({
                    processing:true,
                    serverSide:true,
                    ajax:'api/todos',
                    order: [[ 1, "desc" ]],
                    pageLength:10,
                    aoColumns: [
                                    {bSortable: false, searchable: false, data: "serial_no"},
                                    {data: "title"},
                                    {data: "description"},
                                    {data: "dmy_duedate"},
                                    {bSortable: false,data: "action"}
                                ]
                  });

                  //delete confirmation popup on click delete button
                  jQuery('#dt-todo').delegate('.btndelete', 'click', function(e){                    
                    var id = $(this).data('id');
                    jQuery('#myModal').modal('show');

                    //confirm to delete
                    jQuery('.btn-confirm').click(function(){
                      self.continue_delete(id);
                    }); 
                  });                
                });

        },
        methods:{
          continue_delete:function(id){ //delete in database
            axios.delete('api/todos/' + id)
              .then((res) => {
                  jQuery('#myModal').modal('hide');
                  this.dtable.draw();
                  this.showMsg=1;
                  this.error_msg = "Delete Successfully!";
                  
                  $("document").ready(function(){$("#alert").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert").slideUp(500);
                  });}) 
              })
              .catch((err) => console.error(err));
            }
        }
    }

</script>
