import moment from 'moment';

import Vue from 'vue'
Vue.filter('time', (a)=>{
    return moment(a).startOf('minute').fromNow();
})

Vue.filter('substring', (content, lenght, s)=>{
    return content.substring(0, lenght)+s
})

Vue.filter('capitalize', (content)=>{
    if(!content) return ''
    content = content.toString()
    return content.charAt(0).toUpperCase()+content.slice(1)
})
