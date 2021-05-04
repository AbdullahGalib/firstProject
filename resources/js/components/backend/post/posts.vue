<template>
    <div>
      <div class="col-md-12 ">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posts</h3>
                <router-link class="btn btn-success float-right" to="add-post">Add Post</router-link>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" v-if="posts.length>0">
                  <thead>
                    <tr>
                      <th><input type="checkbox" @click="selectAll" v-model="selectedAll"></th>
                      <th>Index</th>
                      <th>User Id</th>
                      <th>Category Id</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Slug</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(post, index) in posts">
                      <td><input type="checkbox" :value="post.id" v-model="selected" ></td>
                      <td>{{ ++index }}</td>
                      <td>{{ post.user_id}}</td>
                      <td>{{ post.category_id}}</td>
                      <td>{{ post.title}}</td>
                      <td>{{ post.content | substring(17, '..')}}</td>
                      <td>{{ post.slug }}</td>
                      <td><span class="badge" :class="statusColor(post.status)">{{ post.status | capitalize }}</span></td>
                      <td>{{ post.created_at | time }}</td>
                      <td>
                          <router-link class="btn btn-info btn-sm text-white" :to="`edit-post/${post.id}`">Edit</router-link>
                          <button class="btn btn-danger btn-sm" @click="deletepost(post.id)">Delete</button>
                      </td>
                    </tr>
                    <tr v-if="selected.length>0">
                      <td colspan="7">
                        <button class="btn btn-success" @click="statusMode(selected,'published')">Published</button>
                        <button class="btn btn-warning" @click="statusMode(selected,'draft')">Draft</button>
                        <button class="btn btn-danger" v-if="selected.length>0" @click="deletePostItems(selected)">Delete</button>
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
    name: 'posts',

   data(){
        return{
            selected: [],
            selectedAll:false,
        }
    },

    mounted(){
        this.$store.dispatch("getPosts")
    },
    watch:{
      selected(selected){
        this.selectedAll = (selected.length===this.posts.length)
      },
    },
    computed:{
          posts(){
            return  this.$store.getters.posts;
          }
    },
    methods:{
        statusColor(status){
            let color = {
                'draft': 'badge-warning',
                'published':'badge-success',
            }
            return color[status]
        },
        deletepost(id){
            this.confirm(()=>{
            axios.get("delete-post/"+id)
                .then( (response)=>{
                this.$store.dispatch("getPosts")
                toastr.success('post has been delete succesfully!',{timeout:4000})
                Swal.fire('Deleted!','Your file has been deleted.','success')

                });
            })
        },
        selectAll(event){
          if( event.target.checked == false){
            this.selected= []
          }else{
            this.posts.forEach(post => {
              this.selected.push(post.id)
            });
          };
        },
        deletePostItems(selected){
         this.confirm(()=>{
            axios.post("/remove/postItems",{data: selected}).then((response)=>{
                this.$store.dispatch("getPosts")
                this.selected= [],
                this.selectedAll=false,
                toastr.success(response.data.total>1 ?response.data.total+' posts has been delete succesfully!':'1 Post has been delete succesfully!',{timeout:4000})
            })
          })
        },
        statusMode(selected, status){
            let msg = status
         axios.post("/change/postItems",{data: selected, status:status}).then((response)=>{
            this.$store.dispatch("getPosts")
            this.selected= [],
            this.selectedAll=false,
            toastr.success(response.data.total>1 ?response.data.total+' Posts has been '+ msg +' succesfully!':'1 Post has been '+ msg+' succesfully!',{timeout:4000})
          })
        }
    }
}
</script>
<style scoped>

</style>
