export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavItem',
        name: 'Dashboard',
        to: '/dashboard',
        icon: 'cil-speedometer',
        badge: {
          color: 'primary',
          text: 'NEW'
        }
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Pedidos',
        to: '/theme/colors',
        icon: 'cil-drop',
        items: [
          {
            name: 'Nuevo Pedido',
            to: '/pedidos/nuevo'
          },
          {
            name: 'Tus Pedidos',
            to: '/pedidos/todos'
          },
        ]
      },
    ]
  }
]