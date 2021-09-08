window.Vue = require('vue').default;

//component
import ExampleComponent from './components/ExampleComponent.vue';
import MotivationIndex from './components/features/motivation/Index.vue';
import HomeIndex from './components/features/home/Index.vue';
import NoteIndex from './components/features/note/Index.vue';
import TodolistIndex from './components/features/todolist/Index.vue';
import FinanceIndex from './components/features/finance/Index.vue';
import Login from './components/auth/LoginComponent.vue';
import Register from './components/auth/RegisterComponent.vue';
import NotFound from './components/layouts/404-page.vue';

const routes = [
    {
        path: '/', component: HomeIndex, name: 'Home Index'
    },
    {
        path: '/app/motivation', component: MotivationIndex, name: 'Motivation Index'
    },
    {
        path: '/app/notes', component: NoteIndex, name: 'Note index'
    },
    {
        path: '/app/todolist', component: TodolistIndex, name: 'Todolist index'
    },
    {
        path: '/app/finance', component: FinanceIndex, name: 'Finance index'
    },
    {
        path: '/login', component: Login, name: 'Login'
    },
    {
        path: '/register', component: Register, name: 'Register'
    },
    {
        path: '*', component: NotFound, name: '404'
    },

];

export default routes;
