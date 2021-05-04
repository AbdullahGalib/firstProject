import home from '../components/backend/home'

//category routes import
import categories from '../components/backend/category/categories'
import creatCategory from '../components/backend/category/create'
import editCategory from '../components/backend/category/edit'

//post routes import
import posts from '../components/backend/post/posts'
import createPost from '../components/backend/post/create'
import editPost from '../components/backend/post/edit'


export const routes = [
    { path: '/home', component: home },

    //category routes
    { path: '/categories', component: categories },
    { path: '/add-category', component: creatCategory },
    { path: '/edit-category/:id', component: editCategory },

    //post routes
    { path: '/posts', component: posts },
    { path: '/add-post', component: createPost },
    { path: '/edit-post/:id', component: editPost },
];
