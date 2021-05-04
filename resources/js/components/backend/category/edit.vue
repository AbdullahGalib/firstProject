<template name="component-name">
    <div>
        <div class="col-md-8 offset-2">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update category</h3>

                <router-link class="btn btn-success float-right" to="/categories">Categories</router-link>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" @submit.prevent="updateCategory">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Write Category name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" placeholder="Enter your category name" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                      <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="active" value="1" v-model="form.status" name="status" :class="{ 'is-invalid': form.errors.has('status') }">
                        <label class="form-check-label" for="active" name="status">Active</label>
                      </div>
                      <div class="form-check form-check-inline">
                      <input type="radio" class="form-check-input" id="inactive" value="0" v-model="form.status" name="status" :class="{ 'is-invalid': form.errors.has('status') }">
                        <label class="form-check-label" for="inactive">Inactive</label>
                      </div>
                        <has-error style="display:block important;" :form="form" field="status"></has-error>

                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" :disabled="form.busy" class="btn btn-success">Update category</button>
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
    name:'editCategory',
    data(){
      return{
        form: new Form({
          id: null,
          name: null,
          status: null
        })
      }
    },
    mounted(){
        this.getCategory()
    },
    methods:{
      updateCategory(){
        const app = this
        this.form.post('/update-category')
        .then(function (data) {
          /*Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
            })*/
            toastr.success('Category has been updated Successfully!',{timeout:4000})

            return app.$router.push("/categories")
        })
      },

      getCategory(){
          let data = this
          axios.get("/get-category/"+ this.$route.params.id)
          .then((response)=>{
              data.form.fill(response.data.category)
          })
      }

    }
}
</script>
