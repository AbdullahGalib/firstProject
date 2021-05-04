import axios from "axios";

export default{
    state: {
        categoryData: [],
        postData: []
      },
      getters: {
        categories (state) {
          return state.categoryData;
        },
        posts (state) {
            return state.postData;
          }
      },
      actions:{
        getCategories(data){
            axios.get("/get-categoreis").then((response)=>{
               data.commit("categoreis", response.data.categories)
            })
        },
        getPosts(data){
            axios.get("/get-posts").then((response)=>{
               data.commit("posts", response.data.posts)
            })
        },

        getActiveCategories(data){
            axios.get("/get-active-categoreis").then((response)=>{
                data.commit("categoreis", response.data.categories)
             })
        }
      },
      mutations:{
        categoreis(state, data){
            state.categoryData = data;
        },
        posts(state, data){
            state.postData = data;
        }
      }
}
