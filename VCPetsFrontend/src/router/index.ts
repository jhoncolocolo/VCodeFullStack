import {createRouter, createWebHistory, RouteRecordRaw} from 'vue-router'
import Home from '@/views/HomeComponent.vue'
import NotExists from '@/views/NotExists.vue'
import PetIndex from '@/views/Pets/PetIndex.vue'
import PetCreate from '@/views/Pets/PetCreate.vue'
import PetEdit from '@/views/Pets/PetEdit.vue'
import CategoryIndex from '@/views/Categories/CategoryIndex.vue'
import CategoryCreate from '@/views/Categories/CategoryCreate.vue'
import CategoryEdit from '@/views/Categories/CategoryEdit.vue'
import TagIndex from '@/views/Tags/TagIndex.vue'
import TagCreate from '@/views/Tags/TagCreate.vue'
import TagEdit from '@/views/Tags/TagEdit.vue'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {   
        name: 'pet.index', 
        path: '/pet', 
        component: PetIndex
    },
    {
        name: 'pet.create', 
        path: '/pet/create', 
        component: PetCreate
    },
    {   
        name: 'pet.edit', 
        path : '/pet/edit/:id', 
        component: PetEdit
    },
    {   
        name: 'categories.index', 
        path: '/categories', 
        component: CategoryIndex
    },
    {
        name: 'categories.create', 
        path: '/categories/create', 
        component: CategoryCreate
    },
    {   
        name: 'categories.edit', 
        path : '/categories/edit/:id', 
        component: CategoryEdit
    },
    {   
        name: 'tags.index', 
        path: '/tags', 
        component: TagIndex
    },
    {
        name: 'tags.create', 
        path: '/tags/create', 
        component: TagCreate
    },
    {   
        name: 'tags.edit', 
        path : '/tags/edit/:id', 
        component: TagEdit
    },
    {
        name:'notexists', 
        path : '/404',
        component: NotExists
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

router.beforeEach( (to,from,next) =>{
    if( to.matched.length > 0){
        next()
     }else{
         next('/404')

     }
})
export default router