<template name="component-name">
    <div>
        <div class="col-md-8 offset-2">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add category</h3>

                <router-link class="btn btn-success float-right" to="categories">Categories</router-link>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" @submit.prevent="addCategory">
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

                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" :disabled="form.busy" class="btn btn-success">Sign in</button>
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
    name:'createCategory',
    data(){
      return{
        form: new Form({
          name: null,
          status: null
        })
      }
    },
    methods:{
      addCategory(){
        const app = this
        this.form.post('/add-category')
        .then(function (data) {
          /*Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
            })*/
            app.form.name = null
            app.form.status = null
            toastr.success('Category has been added Successfully!',{timeout:4000})
        })
      },

    }
}
</script>
