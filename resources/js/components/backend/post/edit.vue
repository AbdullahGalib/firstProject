<template name="component-name">
    <div>
        <div class="col-md-8 offset-2">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Posts</h3>

                <router-link class="btn btn-success float-right" to="/posts">Posts</router-link>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" @submit.prevent="updatePost" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="category_id" class="col-sm-3 col-form-label">Select your  category</label>
                    <div class="col-sm-9">
                        <select v-model="form.category_id"  id="category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                            <option value="">Select Your Post Category</option>
                            <option :value="category.id" v-for="category in categories">{{category.name}}</option>
                        </select>
                      <has-error :form="form" field="category_id"></has-error>
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label">Write Post title</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="title" placeholder="Enter your Post title" v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }">
                      <has-error :form="form" field="title"></has-error>
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="content" class="col-sm-3 col-form-label">Write Post content</label>
                    <div class="col-sm-9">
                      <textarea type="text" class="form-control" id="content" placeholder="Enter your Post content" v-model="form.content" :class="{ 'is-invalid': form.errors.has('content') }"></textarea>
                      <has-error :form="form" field="content"></has-error>
                    </div>
                  </div>
                     <div class="form-group row">
                    <label for="image" class="col-sm-3 col-form-label">Write Post title</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" id="image" placeholder="Enter your Post title"  :class="{ 'is-invalid': form.errors.has('image') }" @change="imageLoad($event)">
                      <has-error :form="form" field="image"></has-error>
                    </div>
                    <div class="col-sm-5">
                        <img :src="form.image" width="300px" alt="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                      <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="active" value="published" v-model="form.status" name="status" :class="{ 'is-invalid': form.errors.has('status') }">
                        <label class="form-check-label" for="active" name="status">Published</label>
                      </div>
                      <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="inactive" value="draft" v-model="form.status" name="status" :class="{ 'is-invalid': form.errors.has('status') }">
                        <label class="form-check-label" for="inactive">Draft</label>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" :disabled="form.busy" class="btn btn-success">Save</button>
                  <button type="reset" class="btn btn-danger float-right">Cancel</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    name:'editPost',
    data(){
      return{
        form: new Form({
          id: null,
          image:'',
          title:null,
          status: null,
          content:null,
          category_id:''
        })
      }
    },
    mounted(){
        this.getPost()
        this.$store.dispatch("getActiveCategories")
    },
    computed:{
        categories(){
        return  this.$store.getters.categories;
        }
    },
    methods:{
      updatePost(){
        this.form.post('/update-post')
        .then(function (data) {
          /*Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
            })*/
            toastr.success('Post has been updated Successfully!',{timeout:4000})

            return this.$router.push("/posts")
        })
      },

      getPost(){
          axios.get("/get-post/"+ this.$route.params.id)
          .then((response)=>{
              this.form.fill(response.data.post)
          })
      }

    }
}
</script>
