<template>
    <div>
      <div class="col-md-8 offset-2">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">categories</h3>
                <router-link class="btn btn-success float-right" to="add-category">Add category</router-link>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" v-if="categories.length>0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" @click="selectAll" v-model="selectedAll"></th>
                      <th>Index</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(category, index) in categories">
                      <td><input type="checkbox" :value="category.id" v-model="selected" ></td>
                      <td>{{ ++index }}</td>
                      <td>{{ category.name}}</td>
                      <td>{{ category.slug }}</td>
                      <td><span class="badge" :class="statusColor(category.status)">{{ 0==category.status ? 'Inactiv':'Active'   }}</span></td>
                      <td>{{ category.created_at | time }}</td>
                      <td>
                          <router-link class="btn btn-info btn-sm text-white" :to="`edit-category/${category.id}`">Edit</router-link>
                          <button class="btn btn-danger btn-sm" @click="deleteCategory(category.id)">Delete</button>
                      </td>
                    </tr>
                    <tr v-if="selected.length>0">
                      <td colspan="7">
                        <button class="btn btn-success" @click="statusMode(selected,1)">Active</button>
                        <button class="btn btn-warning" @click="statusMode(selected,0)">Inactive</button>
                        <button class="btn btn-danger" v-if="selected.length>0" @click="deleteCategoryItems(selected)">Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else class="text-center alert alert-warning"><h4>No data here</h4></div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>

              </div>
            </div>
      </div>
    </div>
</template>
<script>
export default {
    name: 'categories',

   data(){
        return{
            selected: [],
            selectedAll:false,
        }
    },

    mounted(){
        this.$store.dispatch("getCategories")
    },
    watch:{
      selected(selected){
        this.selectedAll = (selected.length===this.categories.length)
      },
    },
    computed:{
          categories(){
            return  this.$store.getters.categories;
          }
    },
    methods:{
        statusColor(status){
            let color = {
                0: 'badge-warning',
                1:'badge-success',
            }
            return color[status]
        },
        deleteCategory(id){
            this.confirm(()=>{
            axios.get("delete-category/"+id)
                .then( (response)=>{
                this.$store.dispatch("getCategories")
                toastr.success('Category has been delete succesfully!',{timeout:4000})
                Swal.fire('Deleted!','Your file has been deleted.','success')

                });
            })
        },
        selectAll(event){
          if( event.target.checked == false){
            this.selected= []
          }else{
            this.categories.forEach(category => {
              this.selected.push(category.id)
            });
          };
        },
        active(){

        },
        deleteCategoryItems(selected){
         this.confirm(()=>{
            axios.post("/remove/categoryItems",{data: selected}).then((response)=>{
                this.$store.dispatch("getCategories")
                this.selected= [],
                this.selectedAll=false,
                toastr.success(response.data.total>1 ?response.data.total+' Categories has been delete succesfully!':'1 Category has been delete succesfully!',{timeout:4000})
            })
          })
        },
        statusMode(selected, status){
            let msg = status==1?'Active':'Inactive'
         axios.post("/change/categoryItems",{data: selected, status:status}).then((response)=>{
            this.$store.dispatch("getCategories")
            this.selected= [],
            this.selectedAll=false,
            toastr.success(response.data.total>1 ?response.data.total+' Categories has been '+ msg +' succesfully!':'1 Category has been '+ msg+' succesfully!',{timeout:4000})
          })
        }
    }
}
</script>
<style scoped>

</style>
