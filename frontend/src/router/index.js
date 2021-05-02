import Vue from 'vue'
import Router from 'vue-router'

// Containers
const TheContainer = () => import('@/containers/TheContainer')

// Views
const NuevoPedido = () => import('@/views/Pedidos/New')
const AllPedidos = () => import('@/views/Pedidos/All')
const SinglePedido = () => import('@/views/Pedidos/Single')
const Dashboard = () => import('@/views/Dashboard')
// Views - Pages
const Page404 = () => import('@/views/pages/Page404')
const Page500 = () => import('@/views/pages/Page500')
const Login = () => import('@/views/pages/Login')
const Register = () => import('@/views/pages/Register')


Vue.use(Router)

export default new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})

function configRoutes () {
  return [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: TheContainer,
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: 'pedidos',
          redirect: '/pedidos/todos',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'nuevo',
              name: 'Nuevo Pedido',
              component: NuevoPedido,
              meta: {
                requiresAuth: true
              }
            },
            {
              path: 'todos',
              name: 'Todos los Pedido',
              component: AllPedidos,
              meta: {
                requiresAuth: true
              }
            },
            {
              path: 'ver/:id',
              name: 'Ver Pedido',
              props: true,
              component: SinglePedido,
              meta: {
                requiresAuth: true
              }
            }
          ]
        },
        
      ]
    },
    {
      path: '/auth',
      redirect: '/auth/login',
      component: {
        render (c) { return c('router-view')}
      },
      children: [
        {
          path: 'login',
          name: 'Login',
          component: Login,
          meta: {
            requiresAuth: false
          }
        },
        {
          path: 'register',
          name: 'Register',
          component: Register,
          meta: {
            requiresAuth: false
          }
        }
      ]
    },
    {
      path: '/pages',
      redirect: '/pages/404',
      name: 'Pages',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '404',
          name: 'Page404',
          component: Page404,
          meta: {
            requiresAuth: false
          }
        },
        {
          path: '500',
          name: 'Page500',
          component: Page500,
          meta: {
            requiresAuth: false
          }
        },
      ]
    }
  ]
}

